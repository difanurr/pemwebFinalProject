@extends('layouts.default')

@section('title', 'Data Transaksi')

@section('content')
    <div class="container">
        <h2>Data Transaksi</h2>

        <button type="button" class="btn btn-primary btn-add">+</button>
        <div id="addForm" style="display:none">
            <form action="{{ route('transaksi.add') }}" method="POST">
                @csrf
                <div class="form-group row">
                    <label for="tanggal" class="col-sm-2 col-form-label">Tanggal</label>
                    <div class="col-sm-5">
                        <input type="date" class="form-control" name="tanggal">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="id_customer" class="col-sm-2 col-form-label">ID Customer</label>
                    <div class="col-sm-5">
                        {{-- <input type="text" class="form-control" name="id_customer"> --}}
                        <select class="form-control" name="id_customer">
                            <option value="" disabled selected>Pilih ID Customer</option>
                            @foreach ($customer as $customerItem)
                                <option value="{{ $customerItem->id_customer }}">{{ $customerItem->id_customer }} -
                                    {{ $customerItem->nama_customer }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </div>
            </form>
        </div>

        <table class="table table-striped table-bordered table-hover mt-3">
            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>Tanggal</th>
                    <th>ID Customer</th>
                    <th colspan="2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaksi as $item)
                    <tr>
                        <td>{{ $item->id_transaksi }}</td>
                        <td>{{ $item->tanggal }}</td>
                        <td>{{ $item->id_customer }}</td>
                        <td>
                            <button type="button" class="btn btn-primary btn-edit" data-id="{{ $item->id_transaksi }}"
                                data-toggle="modal" data-target="#editModal{{ $item->id_transaksi }}">Edit</button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-delete" data-id="{{ $item->id_transaksi }}"
                                data-toggle="modal" data-target="#deleteModal{{ $item->id_transaksi }}">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('modal')
    @foreach ($transaksi as $item)
        <!-- Edit Modal -->
        <div class="modal fade" id="editModal{{ $item->id_transaksi }}" tabindex="-1" role="dialog"
            aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Data Transaksi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" onclick="closeModal('{{ $item->id_transaksi }}')">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            @csrf
                            <div class="form-group">
                                <label for="id_transaksi">ID Transaksi:</label>
                                <input type="number" class="form-control" id="id_transaksi"
                                    value="{{ $item->id_transaksi }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="tanggal">Tanggal:</label>
                                <input type="date" id="tanggal{{ $item->id_transaksi }}" name="tanggal"
                                    class="form-control" value="{{ $item->tanggal }}">
                            </div>
                            <div class="form-group">
                                <label for="id_customer">ID Customer:</label>
                                <input type="text" id="id_customer{{ $item->id_transaksi }}" name="id_customer"
                                    class="form-control" value="{{ $item->id_customer }}">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            onclick="closeModal('{{ $item->id_transaksi }}')">Tutup</button>
                        <button type="button" class="btn btn-primary btn-save" data-id="{{ $item->id_transaksi }}">Simpan
                            Perubahan</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteModal{{ $item->id_transaksi }}" tabindex="-1" role="dialog"
            aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Apa Anda yakin ingin menghapus data ini?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" onclick="closeModal('{{ $item->id_transaksi }}')">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ID Transaksi : {{ $item->id_transaksi }}<br>
                        Tanggal : {{ $item->tanggal }}<br>
                        ID Customer : {{ $item->id_customer }}
                    </div>
                    <div class="modal-footer">
                        <form id="deleteForm{{ $item->id_transaksi }}"
                            action="{{ route('transaksi.delete', $item->id_transaksi) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-secondary"
                                onclick="closeModal('{{ $item->id_transaksi }}')">Tidak</button>
                            <button type="submit" class="btn btn-primary btn-delete-confirm"
                                data-id="{{ $item->id_transaksi }}">Iya</button>
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
                var id_transaksi = $(this).data("id");
                $("#editModal" + id_transaksi).modal("show");
            });

            $(".btn-save").click(function() {
                var id_transaksi = $(this).data("id");
                var tanggal = $("#tanggal" + id_transaksi).val();
                var id_customer = $("#id_customer" + id_transaksi).val();

                $.post("/transaksi/update/" + id_transaksi, {
                    id_transaksi: id_transaksi,
                    tanggal: tanggal,
                    id_customer: id_customer,
                    _token: $("meta[name='csrf-token']").attr("content")
                }, function() {
                    $("#editModal" + id_transaksi).modal("hide");
                    location.reload();
                })
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $(".btn-delete").click(function() {
                var id_transaksi = $(this).data("id");
                $("#deleteModal" + id_transaksi).modal("show");
            });

            $(".btn-delete-confirm").click(function() {
                var id_transaksi = $(this).data("id");

                $.post("/transaksi/delete/" + id_transaksi, {
                    id_transaksi: id_transaksi,
                    _token: $("meta[name='csrf-token']").attr("content")
                }, function() {
                    $("#deleteModal" + id_transaksi).modal("hide");
                    location.reload();
                })

            });


        });
    </script>

    <script>
        $(document).ready(function() {
            $(".btn-add").click(function() {
                $("#addForm").show();
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
