<div>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Crear Venta 
                {{-- @if($salesCount > 0)
                    <span class="badge bg-success">{{ $salesCount }} productos agregados</span>
                @endif --}}
            </h5>
            <div class="input-group" style="max-width: 300px;">
                <span class="input-group-text">
                    <i class="icon-base ri ri-search-line"></i>
                </span>
                <input type="text" 
                       class="form-control" 
                       wire:model.live.debounce.300ms="search" 
                       placeholder="Buscar producto...">
            </div>
        </div>

        <div class="card-body">
            @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

                @if($search && $products->isEmpty())
                    <div class="alert alert-danger">
                        No se encontraron resultados para "{{ $search }}"
                    </div>
                @endif

            @foreach ($products as $category => $items)
                <h5 class="mb-4 mt-2 border-bottom-0 pb-2 pt-2 px-3 text-uppercase text-white rounded shadow-sm"
                    style="background: linear-gradient(90deg, #dc3545 0%, #ff4d6d 100%);">
                    {{ $category ?? 'Sin categoría' }}
                </h5>
                <div class="row">
                    @foreach ($items as $product)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                            <div class="card h-100 shadow-sm border-0">
                                @if($product->image)
                                    <img src="{{ asset('assets/json/products/' . $product->image) }}" 
                                        class="card-img-to w-100" 
                                        alt="{{ $product->description }}"
                                        style="height: 200px; object-fit: contain;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center" 
                                        style="height: 200px;">
                                        <i class="icon-base ri ri-image-line" style="font-size: 3rem; color: #ccc;"></i>
                                    </div>
                                @endif
                                
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title text-truncate mb-3">{{ $product->description }}</h5>
                                    <div class="mt-auto">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="fw-bold text-dark">
                                                Q{{ number_format($product->price, 2) }}
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <button 
                                                wire:click="addProduct({{ $product->id }})" 
                                                wire:loading.attr="disabled"
                                                wire:target="addProduct"
                                                class="btn btn-danger w-50 mx-auto d-block">
                                                
                                                <span wire:loading.remove wire:target="addProduct">
                                                    <i class="icon-base ri ri-add-large-fill me-1"></i>
                                                    Agregar
                                                </span>
                                                
                                                <span wire:loading wire:target="addProduct">
                                                    <span class="spinner-border spinner-border-sm me-1"></span>
                                                    Agregando...
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</div>