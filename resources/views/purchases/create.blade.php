@extends('layouts.app')
@section('title', 'New Purchase')
@section('page_title', 'New Purchase Order')
@section('content')
<div class="card border-0 shadow-sm"><div class="card-body p-4">
<form method="POST" action="{{ route('purchases.store') }}" id="purchaseForm">@csrf
<div class="row g-3 mb-4"><div class="col-md-6"><label class="form-label">Supplier</label><select name="supplier_id" class="form-select" required>@foreach($suppliers as $s)<option value="{{ $s->id }}">{{ $s->name }}</option>@endforeach</select></div><div class="col-md-6"><label class="form-label">Order Date</label><input type="date" name="order_date" class="form-control" value="{{ date('Y-m-d') }}" required></div><div class="col-12"><label class="form-label">Notes</label><textarea name="notes" class="form-control" rows="2"></textarea></div></div>
<h5 class="fw-bold mb-3">Line Items</h5>
<div id="itemsWrap"></div>
<button type="button" class="btn btn-outline-primary btn-sm mb-4" id="addItem"><i class="fa-solid fa-plus"></i> Add Item</button>
<button class="btn btn-primary">Save & Receive Stock</button>
</form></div></div>
@endsection
@section('scripts')
<script>
const products = @json($products->map(fn($p)=>['id'=>$p->id,'name'=>$p->name,'cost'=>$p->cost_price]));
let idx=0;
function row(i){return `<div class="row g-2 mb-2 item-row"><div class="col-md-5"><select name="items[${i}][product_id]" class="form-select" required>${products.map(p=>`<option value="${p.id}">${p.name}</option>`).join('')}</select></div><div class="col-md-2"><input type="number" name="items[${i}][quantity]" class="form-control" placeholder="Qty" min="1" value="1" required></div><div class="col-md-3"><input type="number" step="0.01" name="items[${i}][unit_cost]" class="form-control" placeholder="Unit cost" value="${products[0]?.cost||0}" required></div><div class="col-md-2"><button type="button" class="btn btn-outline-danger w-100 remove-item">Remove</button></div></div>`}
document.getElementById('addItem').addEventListener('click',()=>{document.getElementById('itemsWrap').insertAdjacentHTML('beforeend',row(idx++));});
document.getElementById('addItem').click();
document.getElementById('itemsWrap').addEventListener('click',e=>{if(e.target.classList.contains('remove-item')) e.target.closest('.item-row').remove();});
</script>
@endsection
