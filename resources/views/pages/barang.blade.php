@extends('layouts.default')

@section('title', 'Data Barang')

@section('content')
    <div class="container">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <h2>Data Barang</h2>
        <button type="button" class="btn btn-primary btn-add">+</button>
        <div id="addForm" style="display:none">
            <form action="{{ route('barang.add') }}" method="POST">
                @csrf
                <div class="form-group row">
                    <label for="id_barang" class="col-sm-2 col-form-label">ID Barang</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="id_barang">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nama_barang" class="col-sm-2 col-form-label">Nama Barang</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="nama_barang">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="harga" class="col-sm-2 col-form-label">Harga</label>
                    <div class="col-sm-5">
                        <input type="number" class="form-control" name="harga">
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
                    <th>ID Barang</th>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th colspan="2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($barang as $item)
                    <tr>
                        <td>{{ $item->id_barang }}</td>
                        <td>{{ $item->nama_barang }}</td>
                        <td>{{ $item->harga }}</td>
                        <td>
                            <button type="button" class="btn btn-primary btn-edit" data-id="{{ $item->id_barang }}"
                                data-toggle="modal" data-target="#editModal{{ $item->id_barang }}">Edit</button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-delete" data-id="{{ $item->id_barang }}"
                                data-toggle="modal" data-target="#deleteModal{{ $item->id_barang }}">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('modal')
    @foreach ($barang as $item)
        <!-- Edit Modal -->
        <div class="modal fade" id="editModal{{ $item->id_barang }}" tabindex="-1" role="dialog"
            aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Data Barang</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" onclick="closeModal('{{ $item->id_barang }}')">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="id_barang">ID Barang:</label>
                                <input type="text" class="form-control" id="id_barang" value="{{ $item->id_barang }}"
                                    readonly>
                                <input type="hidden" id="id_barang-hidden" value="{{ $item->id_barang }}">
                            </div>
                            <div class="form-group">
                                <label for="nama_barang">Nama Barang:</label>
                                <input type="text" id="nama_barang{{ $item->id_barang }}" name="nama_barang"
                                    class="form-control" value="{{ $item->nama_barang }}">
                            </div>
                            <div class="form-group">
                                <label for="harga">Harga:</label>
                                <input type="number" id="harga{{ $item->id_barang }}" name="harga" class="form-control"
                                    value="{{ $item->harga }}">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            onclick="closeModal('{{ $item->id_barang }}')">Tutup</button>
                        <button type="button" class="btn btn-primary btn-save" data-id="{{ $item->id_barang }}">Simpan
                            Perubahan</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <div class="modal fade" id="deleteModal{{ $item->id_barang }}" tabindex="-1" role="dialog"
            aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Apa Anda yakin ingin menghapus data ini?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" onclick="closeModal('{{ $item->id_barang }}')">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ID barang : {{ $item->id_barang }}<br>
                        Nama barang : {{ $item->nama_barang }}<br>
                        Harga : {{ $item->harga }}
                    </div>
                    <div class="modal-footer">
                        <form id="deleteForm{{ $item->id_barang }}"
                            action="{{ route('barang.delete', $item->id_barang) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-secondary"
                                onclick="closeModal('{{ $item->id_barang }}')">Tidak</button>
                            <button type="submit" class="btn btn-primary btn-delete-confirm">Iya</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('script')
    <!-- Edit Script -->
    <script>
        $(document).ready(function() {
            $(".btn-edit").click(function() {
                var id_barang = $(this).data("id");
                $("#editModal" + id_barang).modal("show");
            });

            $(".btn-save").click(function() {
                var id_barang = $(this).data("id");
                var nama_barang = $("#nama_barang" + id_barang).val();
                var harga = $("#harga" + id_barang).val();
                var id_barang_hidden = $("#id_barang-hidden").val();

                $.post("barang/update/" + id_barang, {
                    id_barang: id_barang_hidden,
                    nama_barang: nama_barang,
                    harga: harga,
                    _token: $("meta[name='csrf-token']").attr("content")
                }, function() {
                    $("#editModal" + id_barang).modal("hide");
                    location.reload();
                });

            });
        });
    </script>

    <!-- Delete Script -->
    <script>
        $(document).ready(function() {
            $(".btn-delete").click(function() {
                var id_barang = $(this).data("id");
                $("#deleteModal" + id_barang).modal("show");
            });

            $(".btn-delete-confirm").click(function() {
                var id_barang = $(this).data("id");
                $.ajax({
                    url: "barang/delete/" + id_barang,
                    method: "POST",
                    data: {
                        _method: "DELETE",
                        _token: $("meta[name='csrf-token']").attr("content")
                    },
                });

                $("#deleteModal" + id_barang).modal("hide");
                location.reload();
            });
        });
    </script>

    <!-- Add Script -->
    <script>
        $(document).ready(function() {
            $(".btn-add").click(function() {
                $("#addForm").show();
            });
        });
    </script>

    <!-- Close Modal Script -->
    <script>
        function closeModal(modalId) {
            $('#editModal' + modalId).modal('hide');
            $('#deleteModal' + modalId).modal('hide');
        }
    </script>

@endsection
