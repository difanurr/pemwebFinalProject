@extends('layouts.default')

@section('title', 'Data Customer')

@section('content')

    <div class="container">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        
        <h2>Data Customer</h2>
        <button type="button" class="btn btn-secondary btn-add">+</button>
        <div id="addForm" style="display:none">
            <form action="{{ route('customer.add') }}" method="POST">
                @csrf
                <div class="form-group row">
                    <label for="id_customer" class="col-sm-2 col-form-label">ID Customer</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="id_customer">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nama_customer" class="col-sm-2 col-form-label">Nama Customer</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="nama_customer">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="no_telp" class="col-sm-2 col-form-label">Nomor telepon</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="no_telp">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="alamat">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary btn-tambah">Tambah</button>
                    </div>
                </div>
            </form>
        </div>
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID Customer</th>
                    <th>Nama Customer</th>
                    <th>Nomor Telepon</th>
                    <th>Alamat</th>
                    <th colspan="2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customer as $item)
                    <tr>
                        <td>{{ $item->id_customer }}</td>
                        <td>{{ $item->nama_customer }}</td>
                        <td>{{ $item->no_telp }}</td>
                        <td>{{ $item->alamat }}</td>
                        <td>
                            <button type="button" class="btn btn-primary btn-edit" data-id="{{ $item->id_customer }}"
                                data-toggle="modal" data-target="#editModal{{ $item->id_customer }}">Edit</button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-delete" data-id="{{ $item->id_customer }}"
                                data-toggle="modal" data-target="#deleteModal{{ $item->id_customer }}">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('modal')
    @foreach ($customer as $item)
        <!-- Edit Modal -->
        <div class="modal fade" id="editModal{{ $item->id_customer }}" tabindex="-1" role="dialog"
            aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Data Customer</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" onclick="closeModal('{{ $item->id_customer }}')">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="id_customer">ID Customer:</label>
                                <input type="text" class="form-control" id="id_customer"
                                    value="{{ $item->id_customer }}" readonly>
                                <input type="hidden" id="id_customer-hidden"
                                    value="{{ $item->id_customer }}">
                                <div class="form-group">
                                    <label for="nama_customer">Nama Customer:</label>
                                    <input type="text" id="nama_customer{{ $item->id_customer }}" name="nama_customer"
                                        class="form-control" value="{{ $item->nama_customer }}">
                                </div>
                                <div class="form-group">
                                    <label for="no_telp">Nomor telepon:</label>
                                    <input type="text" id="no_telp{{ $item->id_customer }}" name="no_telp"
                                        class="form-control" value="{{ $item->no_telp }}">
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat:</label>
                                    <input type="text" id="alamat{{ $item->id_customer }}" name="alamat"
                                        class="form-control" value="{{ $item->alamat }}">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            onclick="closeModal('{{ $item->id_customer }}')">Tutup</button>
                        <button type="button" class="btn btn-primary btn-save"
                            data-id="{{ $item->id_customer }}">Simpan Perubahan</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteModal{{ $item->id_customer }}" tabindex="-1" role="dialog"
            aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Apa Anda yakin ingin menghapus data ini?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" onclick="closeModal('{{ $item->id_customer }}')">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ID customer : {{ $item->id_customer }}<br>
                        Nama customer : {{ $item->nama_customer }}<br>
                        Nomor telepon : {{ $item->no_telp }}<br>
                        Alamat : {{ $item->alamat }}
                    </div>
                    <div class="modal-footer">
                        <form id="deleteForm{{ $item->id_customer }}"
                            action="{{ route('customer.delete', $item->id_customer) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-secondary"
                                onclick="closeModal('{{ $item->id_customer }}')">Tidak</button>
                            <button type="submit" class="btn btn-primary btn-delete-confirm">Iya</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $(".btn-edit").click(function() {
                var id_customer = $(this).data("id");
                $("#editModal" + id_customer).modal("show");
            });

            $(".btn-save").click(function() {
                var id_customer = $(this).data("id");
                var nama_customer = $("#nama_customer" + id_customer).val();
                var no_telp = $("#no_telp" + id_customer).val();
                var alamat = $("#alamat" + id_customer).val();
                var id_customer_hidden = $("#id_customer-hidden").val();

                $.post("customer/update/" + id_customer, {
                    id_customer: id_customer_hidden,
                    nama_customer: nama_customer,
                    no_telp: no_telp,
                    alamat: alamat,
                    _token: $("meta[name='csrf-token']").attr("content")
                }, function() {
                    $("#editModal" + id_customer).modal("hide");
                    location.reload();
                });

            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $(".btn-delete").click(function() {
                var id_customer = $(this).data("id");
                $("#deleteModal" + id_customer).modal("show");
            });

            $(".btn-delete-confirm").click(function() {
                var id_customer = $(this).data("id");
                $.ajax({
                    url: "customer/delete/" + id_customer,
                    method: "POST",
                    data: {
                        _method: "DELETE",
                        _token: $("meta[name='csrf-token']").attr("content")
                    },
                });

                $("#deleteModal" + id_customer).modal("hide");
                location.reload();
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            $(".btn-add").click(function() {
                var addForm = $("#addForm");

                if (addForm.is(":visible")) {
                    addForm.hide();
                    $(this).text("+");
                    $(this).removeClass("btn-danger").addClass("btn-secondary");
                } else {
                    addForm.show();
                    $(this).text("X");
                    $(this).removeClass("btn-secondary").addClass("btn-danger");
                }
            });
        });
    </script>

    <script>
        function closeModal(modalId) {
            $('#editModal' + modalId).modal('hide');
            $('#deleteModal' + modalId).modal('hide');
        }
    </script>
@endsection
