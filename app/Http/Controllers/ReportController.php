<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function sales(Request $request)
    {
        $from = $request->input('from', now()->startOfMonth()->toDateString());
        $to = $request->input('to', now()->toDateString());

        if ($request->boolean('export')) {
            return $this->exportCsv($from, $to);
        }

        [$sort, $direction] = $this->tableSort($request, ['created_at', 'sale_number', 'total']);
        $sales = $this->salesQuery($from, $to)->orderBy($sort, $direction)->paginate($this->tablePerPage($request))->withQueryString();

        return view('reports.sales', compact('sales', 'from', 'to'));
    }

    protected function salesQuery(string $from, string $to)
    {
        return Sale::with(['user', 'items'])
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to);
    }

    protected function exportCsv(string $from, string $to): StreamedResponse
    {
        $filename = "sales-{$from}-{$to}.csv";

        return response()->streamDownload(function () use ($from, $to) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Sale #', 'Date', 'Customer', 'Total', 'Items count', 'Cashier']);

            $this->salesQuery($from, $to)->chunk(200, function ($sales) use ($handle) {
                foreach ($sales as $sale) {
                    fputcsv($handle, [
                        $sale->sale_number,
                        $sale->created_at->format('Y-m-d H:i'),
                        $sale->customer_name ?? 'Walk-in',
                        number_format((float) $sale->total, 2, '.', ''),
                        $sale->items->count(),
                        $sale->user?->name ?? '-',
                    ]);
                }
            });

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }
}
