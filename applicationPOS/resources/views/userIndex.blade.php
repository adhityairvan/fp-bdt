@extends('template.template')
@section('css')
    <link href="/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection
@section('title')
    Manage User
@endsection
@section('title-body')
    Your Shop's Staff
@endsection
@section('body')
    <div class="row">
        <div class="col-md-12">
            <h5>Create new Staff</h5>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="post" action="/user/create">
                @csrf
                <div class="form-group">
                    <label for="name">Nama Pegawai</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Nama Pegawai" value="{{ old('name') }}">
                </div>
                <div class="form-group">
                    <label for="email">Email Pegawai</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email Pegawai" value="{{ old('email') }}">
                </div>
                <div class="form-group">
                    <label for="password">Email Pegawai</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Email Pegawai">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Save</button>
            </form>
        </div>
        <div class="col-md-12">
            <hr>
            <h5>Staff List</h5>
            <div class="table-responsive">
                <table class="table table-borderless" id="userTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Jumlah Transaksi</th>
                        <th>Manage</th>
                    </tr>
                    </thead>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->in_charge_of_count }}</td>
                            <td><button class="btn btn-danger" type="button" data-toggle="modal" data-target="#deleteModal" data-id="{{ $user->id }}">Delete</button> </td>
                        </tr>
                    @endforeach
                    <tbody>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Jumlah Transaksi</th>
                        <th>Manage</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteUserLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete transaction?
                    <form method="post" action="/user/delete" id="deleteForm">
                        @csrf
                        <input type="hidden" id="deleteInput" name="user_id">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger" form="deleteForm">Delete</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#userTable').DataTable({
                bInfo: false,
                paging: true,
                searching: false,
                ordering: false,
            });
            $('#deleteModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                const id = button.data('id');
                const modal = $(this);
                modal.find('#deleteUserLabel').text('Delete User '+id);
                modal.find('#deleteInput').val(id);
            })
        });
    </script>
@endsection
