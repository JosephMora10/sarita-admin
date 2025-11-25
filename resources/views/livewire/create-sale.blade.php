<div>
    @if(count($cart) > 0)
        <div class="card mb-3 border-0 shadow-sm bg-gradient">
            <div class="card-body d-flex justify-content-between align-items-center flex-wrap py-3">
                <div class="text-white">
                    <h6 class="mb-1 fw-semibold text-white">Resumen de la Orden</h6>
                    <p class="mb-0 small opacity-75 text-white">
                        <strong>{{ count($cart) }}</strong> productos agregados
                    </p>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <h5 class="mb-0 text-white fw-bold">
                        Q{{ number_format($orderTotal, 2) }}
                    </h5>
                    <button wire:click="finalizeOrder"
                            wire:loading.attr="disabled"
                            class="btn btn-light btn-sm px-4 fw-semibold">
                        <span wire:loading.remove wire:target="finalizeOrder">
                            <i class="ri ri-check-double-line me-1"></i> Finalizar
                        </span>
                        <span wire:loading wire:target="finalizeOrder">
                            <span class="spinner-border spinner-border-sm me-1"></span> Guardando...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center py-3 px-4">
            <h5 class="mb-0 fw-bold">Crear Venta</h5>
            <div class="input-group w-auto">
                <span class="input-group-text bg-light border-0 rounded-start-3">
                    <i class="ri ri-search-line text-muted"></i>
                </span>
                <input type="text"
                       class="form-control border-0 bg-light rounded-end-3"
                       style="min-width: 250px;"
                       wire:model.live.debounce.300ms="search"
                       placeholder="Buscar producto...">
            </div>
        </div>

        <div class="card-body p-4">
            @if (session()->has('message'))
                <div class="alert alert-success border-0 shadow-sm mb-4 rounded-3 d-flex align-items-center" role="alert">
                    <i class="ri ri-checkbox-circle-line me-2 fs-5"></i>
                    <span>{{ session('message') }}</span>
                </div>
            @endif

            @if($search && $products->isEmpty())
                <div class="alert alert-warning border-0 shadow-sm rounded-3 d-flex align-items-center">
                    <i class="ri ri-information-line me-2 fs-5"></i>
                    <span>No se encontraron resultados para "{{ $search }}"</span>
                </div>
            @endif

            <div class="row g-2">
                @foreach ($products as $product)
                    <div class="col-4 col-sm-3 col-md-2 col-lg-2 col-xl-15">
                        <div class="card h-100 border-0 shadow-sm product-card rounded-3">
                            
                            <!-- Imagen del producto -->
                            <div class="ratio ratio-1x1 rounded-top-3 overflow-hidden">
                                @if($product->image)
                                    <img src="{{ asset('assets/json/products/' . $product->image) }}"
                                        class="object-fit-cover"
                                        alt="{{ $product->description }}">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center">
                                        <i class="ri ri-image-line display-4 text-muted opacity-25"></i>
                                    </div>
                                @endif
                            </div>

                            <!-- Información del producto -->
                            <div class="card-body p-2 d-flex flex-column">
                                <h6 class="card-title mb-1 fw-semibold text-truncate" style="font-size: 0.75rem; line-height: 1.2;">
                                    {{ $product->description }}
                                </h6>

                                <div class="mb-1">
                                    <span class="fw-bold text-danger" style="font-size: 0.875rem;">
                                        Q{{ number_format($product->price, 2) }}
                                    </span>
                                </div>

                                <button
                                    wire:click="addProduct({{ $product->id }})"
                                    wire:loading.attr="disabled"
                                    wire:target="addProduct"
                                    class="btn btn-danger btn-sm w-100 rounded-2 fw-semibold mt-auto py-1"
                                    style="font-size: 0.75rem;">

                                    <span wire:loading.remove wire:target="addProduct">
                                        <i class="ri ri-add-line"></i> Agregar
                                    </span>

                                    <span wire:loading wire:target="addProduct">
                                        <span class="spinner-border spinner-border-sm"></span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <style>
        /* Gradiente rojo para el resumen */
        .bg-gradient {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
        }

        /* Efectos hover con transiciones suaves */
        .product-card {
            transition: all 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 .5rem 1.5rem rgba(0, 0, 0, 0.15) !important;
        }

        .product-card button:hover {
            transform: scale(1.02);
            box-shadow: 0 .25rem .75rem rgba(220, 38, 38, 0.3);
        }

        .product-card button:active {
            transform: scale(0.98);
        }

        /* Input focus personalizado */
        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(220, 38, 38, 0.15);
            border-color: #ef4444 !important;
        }

        /* Optimización para pantallas pequeñas */
        @media (max-width: 576px) {
            .card-header .input-group {
                width: 100% !important;
                margin-top: 0.5rem;
            }
            
            .card-header {
                flex-direction: column;
                align-items: flex-start !important;
            }
        }
    </style>
</div>