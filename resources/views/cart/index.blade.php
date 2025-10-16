@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10">
    <h2 class="text-2xl font-bold mb-5">My Cart</h2>

    @if($cart && count($cart))
        <form action="{{ route('cart.updateAll') }}" method="POST" id="cart-form">
            @csrf
            <table class="w-full border">
                <thead>
                    <tr>
                        <th class="border px-2 py-1">Product</th>
                        <th class="border px-2 py-1">Quantity</th>
                        <th class="border px-2 py-1">Price</th>
                        <th class="border px-2 py-1">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $grandTotal = 0; @endphp
                    @foreach($cart as $item)
                        @php 
                            $total = $item['price'] * $item['quantity']; 
                            $grandTotal += $total; 
                        @endphp
                        <tr data-unit-price="{{ $item['price'] }}">
                            <td class="border px-2 py-1">{{ $item['name'] }}</td>
                            <td class="border px-2 py-1">
                                <input type="number" 
                                    name="quantities[{{ $item['id'] }}]" 
                                    value="{{ $item['quantity'] }}" 
                                    min="1" 
                                    max="{{ $item['stock'] }}" 
                                    class="w-16 border px-1 py-1 quantity-input">
                                <span class="text-red-600 stock-warning hidden">Max stock: {{ $item['stock'] }}</span>

                            </td>
                            <td class="border px-2 py-1 row-total">₹{{ $total }}</td>
                            <td class="border px-2 py-1">
                                <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                                    @csrf
                                    <button class="bg-red-600 text-white px-2 py-1 rounded">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" class="text-right font-bold px-2 py-1">Grand Total:</td>
                        <td colspan="2" class="font-bold px-2 py-1" id="grand-total">₹{{ $grandTotal }}</td>
                    </tr>
                </tfoot>
            </table>

            <div class="mt-4">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update Cart</button>
                <form action="{{ route('cart.checkout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded ml-2">Checkout</button>
                </form>
            </div>
        </form>
    @else
        <p>Your cart is empty.</p>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const quantityInputs = document.querySelectorAll('.quantity-input');
    const grandTotalEl = document.getElementById('grand-total');

    function updateGrandTotal() {
        let grandTotal = 0;
        document.querySelectorAll('tbody tr').forEach(row => {
            const input = row.querySelector('.quantity-input');
            let qty = parseInt(input.value) || 1;
            const maxStock = parseInt(input.max);
            const warning = row.querySelector('.stock-warning');

            if (qty > maxStock) {
                qty = maxStock;
                input.value = maxStock;
                warning.classList.remove('hidden');
            } else {
                warning.classList.add('hidden');
            }

            const unitPrice = parseFloat(row.dataset.unitPrice);
            const total = qty * unitPrice;
            row.querySelector('.row-total').textContent = '₹' + total.toFixed(2);
            grandTotal += total;
        });
        grandTotalEl.textContent = '₹' + grandTotal.toFixed(2);
    }

    quantityInputs.forEach(input => {
        input.addEventListener('input', updateGrandTotal);
    });
});

</script>
@endsection
