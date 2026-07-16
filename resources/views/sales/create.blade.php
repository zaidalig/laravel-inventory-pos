@extends('layouts.app')
@section('title', 'New Sale')
@section('page_title', 'POS - New Sale')
@section('content')
<div class="card border-0 shadow-sm"><div class="card-body p-4">
<form method="POST" action="{{ route('sales.store') }}">@csrf
<div class="row g-3 mb-4"><div class="col-md-4"><label class="form-label">Customer Name</label><input name="customer_name" class="form-control" value="{{ old('customer_name') }}"></div><div class="col-md-4"><label class="form-label">Phone</label><input name="customer_phone" class="form-control" value="{{ old('customer_phone') }}"></div><div class="col-md-4"><label class="form-label">Payment</label><select name="payment_method" class="form-select"><option value="cash">Cash</option><option value="card">Card</option><option value="bank_transfer">Bank Transfer</option></select></div><div class="col-md-4"><label class="form-label">Discount</label><input type="number" step="0.01" name="discount" class="form-control" value="{{ old('discount',0) }}"></div><div class="col-md-4"><label class="form-label">Tax</label><input type="number" step="0.01" name="tax" class="form-control" value="{{ old('tax',0) }}"></div></div>
<h5 class="fw-bold mb-3">Items</h5><div id="itemsWrap"></div>
<button type="button" class="btn btn-outline-primary btn-sm mb-4" id="addItem">Add Item</button>
<button class="btn btn-success">Complete Sale</button>
</form></div></div>
@endsection
@section('scripts')
<script>
const products = @json($products->map(fn($p)=>['id'=>$p->id,'name'=>$p->name,'price'=>$p->sale_price,'stock'=>$p->stock_qty]));
let idx=0;
function row(i){return `<div class="row g-2 mb-2 item-row"><div class="col-md-6"><select name="items[${i}][product_id]" class="form-select" required>${products.map(p=>`<option value="${p.id}">${p.name} ($${p.price}) stock:${p.stock}</option>`).join('')}</select></div><div class="col-md-3"><input type="number" name="items[${i}][quantity]" class="form-control" min="1" value="1" required></div><div class="col-md-3"><button type="button" class="btn btn-outline-danger w-100 remove-item">Remove</button></div></div>`}
document.getElementById('addItem').addEventListener('click',()=>{document.getElementById('itemsWrap').insertAdjacentHTML('beforeend',row(idx++));});
document.getElementById('addItem').click();
document.getElementById('itemsWrap').addEventListener('click',e=>{if(e.target.classList.contains('remove-item')) e.target.closest('.item-row').remove();});
</script>
@endsection
