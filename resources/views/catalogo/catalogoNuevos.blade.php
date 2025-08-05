{{-- resources/views/partials/productos-grid.blade.php --}}
<div class="row isotope-grid">
    @foreach($productos as $producto)
    <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item {{ strtolower(Str::slug($producto->categoria->nombre ?? '')) }}">
        <div class="block2">
            @php
            $imagen = $producto->imagenes->first();
            $esNuevo = \Carbon\Carbon::parse($producto->created_at)->gt(now()->subDays(5));
            @endphp

            <div class="block2-pic hov-img0 {{ $esNuevo ? 'label-new' : '' }}" data-label="{{ $esNuevo ? 'New' : '' }}">
                <img class="img-fluid" src="{{ $imagen ? asset('storage/' . $imagen->ruta) : asset('images/default.jpg') }}"
                    alt="IMG-PRODUCT" style="object-fit: cover; width: 100%; height: 330px;">

                <a href="#"
                    class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1"
                    data-product="{{ $producto->id }}">
                    Ver Producto
                </a>
            </div>

            <div class="block2-txt flex-w flex-t p-t-14">
                <div class="block2-txt-child1 flex-col-l ">
                    <a href="#" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                        {{ $producto->nombre }}
                    </a>

                    @if($producto->precio_oferta)
                    <span class="stext-105 cl3">
                        <del>Bs. {{ number_format($producto->precio, 2) }}</del>
                        <span class="cl13 font-weight-bold">Bs. {{ number_format($producto->precio_oferta, 2) }}</span>
                    </span>
                    @else
                    <span class="stext-105 cl3">
                        Bs. {{ number_format($producto->precio, 2) }}
                    </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>