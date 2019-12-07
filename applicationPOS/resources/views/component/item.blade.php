<div class="col-lg-3 col-md-4 col-sm-6 mb-4">
    <div class="card h-100">
        <a href="#"><img class="card-img-top" src="{{ $image ?? '' }}" alt=""></a>
        <div class="card-body">
            <h4 class="card-title">
                {{ $itemName ?? 'EMPTY ITEM' }}
            </h4>
            <h5>Stok : <b>{{ $stok ?? '0' }}</b></h5>
            <h5>Harga : Rp <b>{{ $harga ?? '0' }}</b></h5>
        </div>
        <div class="card-body">
            <button class="btn btn-outline-primary btn-block" data-toggle="modal" data-target="#stokModal" data-id="{{ $id ?? 1 }}" data-stok="{{ $stok ?? '0' }}">Edit Stok</button>
            <a class="btn btn-outline-warning btn-block" href="item/{{ $id ?? 1 }}">Edit Item</a>
            <a class="btn btn-outline-danger btn-block" href="item/{{ $id ?? 1 }}">Delete Item</a>
        </div>
    </div>
</div>
