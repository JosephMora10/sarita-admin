@extends('layouts/contentNavbarLayout')

@section('title', 'Orders - Orders')

@section('content')
<div class="col-md-12">
    <div class="card">
        <h5 class="card-header">Crear Pedido</h5>
        <form action="{{ route('orders.store') }}" method="POST" id="orderForm">
            @csrf
            <div class="card-body">
                <div id="products-container">
                    <div class="product-item border rounded p-3 mb-3" data-index="0">
                        <div class="row align-items-end">
                            <div class="col-md-5">
                                <div class="form-floating form-floating-outline mb-3">
                                    <select name="products[0][product_id]" class="form-select product-select" required>
                                        <option value="">Seleccione Producto</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}" data-price="{{ $product->price ?? 0 }}">
                                                {{ $product->description }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label>Producto</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating form-floating-outline mb-3">
                                    <input type="number" name="products[0][quantity]" class="form-control quantity-input" 
                                           min="1" value="1" required>
                                    <label>Cantidad</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating form-floating-outline mb-3">
                                    <input type="text" class="form-control subtotal-input" readonly value="0.00">
                                    <label>Subtotal</label>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="mb-3" style="height: 56px; display: flex; align-items: center; justify-content: center;">
                                    <button type="button" class="btn btn-danger btn-sm remove-product" style="display: none;"></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-danger mb-4" id="add-product">
                    <i class="mdi mdi-plus"></i> Agregar Producto
                </button>
                <div class="row">
                    <div class="col-md-8"></div>
                    <div class="col-md-4">
                        <div class="alert alert-dark">
                            <h5 class="mb-0">Total: Q <span id="total-amount">0.00</span></h5>
                        </div>
                    </div>
                </div>

                <div class="form-floating form-floating-outline mb-4">
                    <select name="payment_method_id" class="form-select" required>
                        <option value="">Seleccione Método de Pago</option>
                        @foreach ($paymentMethods as $paymentMethod)
                            <option value="{{ $paymentMethod->id }}">{{ $paymentMethod->description }}</option>
                        @endforeach
                    </select>
                    <label>Método de Pago</label>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="#" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-danger">Crear Pedido</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@section('page-script')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        let productIndex = 1;
        const productsContainer = document.getElementById('products-container');
        const addProductBtn = document.getElementById('add-product');
        const totalAmountSpan = document.getElementById('total-amount');

        // Agregar nuevo producto
        addProductBtn.addEventListener('click', function() {
            const newProduct = `
                <div class="product-item border rounded p-3 mb-3" data-index="${productIndex}">
                    <div class="row align-items-end">
                        <div class="col-md-5">
                            <div class="form-floating form-floating-outline mb-3">
                                <select name="products[${productIndex}][product_id]" class="form-select product-select" required>
                                    <option value="">Seleccione Producto</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" data-price="{{ $product->price ?? 0 }}">
                                            {{ $product->description }}
                                        </option>
                                    @endforeach
                                </select>
                                <label>Producto</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating form-floating-outline mb-3">
                                <input type="number" name="products[${productIndex}][quantity]" class="form-control quantity-input" 
                                    min="1" value="1" required>
                                <label>Cantidad</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating form-floating-outline mb-3">
                                <input type="text" class="form-control subtotal-input" readonly value="0.00">
                                <label>Subtotal</label>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="mb-3" style="height: 56px; display: flex; align-items: center; justify-content: center;">
                                <button type="button" class="btn btn-danger btn-sm remove-product">
                                    <i class="mdi mdi-delete"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            productsContainer.insertAdjacentHTML('beforeend', newProduct);
            productIndex++;
            updateRemoveButtons();
        });
        
        productsContainer.addEventListener('click', function(e) {
            if (e.target.closest('.remove-product')) {
                e.target.closest('.product-item').remove();
                updateRemoveButtons();
                calculateTotal();
            }
        });

        productsContainer.addEventListener('change', function(e) {
            if (e.target.classList.contains('product-select') || e.target.classList.contains('quantity-input')) {
                const productItem = e.target.closest('.product-item');
                calculateSubtotal(productItem);
                calculateTotal();
            }
        });

        productsContainer.addEventListener('input', function(e) {
            if (e.target.classList.contains('quantity-input')) {
                const productItem = e.target.closest('.product-item');
                calculateSubtotal(productItem);
                calculateTotal();
            }
        });

        function calculateSubtotal(productItem) {
            const select = productItem.querySelector('.product-select');
            const quantityInput = productItem.querySelector('.quantity-input');
            const subtotalInput = productItem.querySelector('.subtotal-input');
            
            const selectedOption = select.options[select.selectedIndex];
            const price = parseFloat(selectedOption.dataset.price) || 0;
            const quantity = parseInt(quantityInput.value) || 0;
            const subtotal = price * quantity;
            
            subtotalInput.value = subtotal.toFixed(2);
        }

        function calculateTotal() {
            let total = 0;
            document.querySelectorAll('.subtotal-input').forEach(function(input) {
                total += parseFloat(input.value) || 0;
            });
            totalAmountSpan.textContent = total.toFixed(2);
        }

        function updateRemoveButtons() {
            const productItems = document.querySelectorAll('.product-item');
            productItems.forEach(function(item, index) {
                const removeBtn = item.querySelector('.remove-product');
                if (productItems.length > 1) {
                    removeBtn.style.display = 'block';
                } else {
                    removeBtn.style.display = 'none';
                }
            });
        }
    });
    </script>
@endsection