@extends('template.template')

@section('title')
    Shop's Item
    @endsection
@section('title-body')
    Your Shop's Item
    @endsection
@section('body')
<div class="row">
    <div class="col-md-3">
        <a href="item/create" class="btn btn-primary btn-block">Create New</a>
    </div>
    <div class="col-md-3 offset-6">
        <form style="margin-bottom: 15px">
            <div class="input-group">
                <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" name="search">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row">
    @foreach($items as $item)
        @component('component.item')
            @slot('id')
                {{ $item->id }}
                @endslot
            @slot('itemName')
                {{ $item->nama_barang }}
                @endslot
            @slot('stok')
                {{ $item->stok }}
                @endslot
            @slot('harga')
                {{ $item->harga }}
                @endslot
            @slot('image')
                @if($item->image == '')
                    {{ 'http://placehold.it/700x400' }}
                    @else
                        /storage/{{ $item->image }}
                    @endif
                @endslot
            @endcomponent
        @endforeach

</div>
<!-- /.row -->
<div class="modal fade" id="stokModal" tabindex="-1" role="dialog" aria-labelledby="stokEditModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="stokEditModal">Edit Item Stok</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="stokForm" method="post" action="">
                    @csrf
                    <input type="hidden" name="id" id="id" value="">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Stok:</label>
                        <input type="number" class="form-control" id="stok" name="stok">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" form="stokForm" class="btn btn-primary">Send message</button>
            </div>
        </div>
    </div>
</div>
    @endsection
@section('script')
    <script>
        $('#stokModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            const id = button.data('id'); // Extract info from data-* attributes
            const stok = button.data('stok');
            var modal = $(this);
            modal.find('#stokForm').attr('action', '/item/'+id+'/stok');
            modal.find('#stok').val(stok);
            modal.find('#id').val(id);
        });
    </script>
@endsection
