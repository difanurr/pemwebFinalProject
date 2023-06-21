@extends('layouts.default')

@section('title', 'Data Transaksi')

@section('content')
    <div class="container">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <h2>Data Transaksi</h2>

        <button id="scrollToTop" class="scroll-button-up">▲</button>
        <button id="scrollToBottom" class="scroll-button-down">▼</button>

        <button type="button" class="btn btn-secondary btn-add">+</button>
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
                        {{-- <input class="form-control" list="list_customer" id="id_customer" name="id_customer" placeholder="Type to search..."> --}}
                        <select class="form-control" name="id_customer"> --}}
                            <option value="" disabled selected>Pilih ID Customer</option>
                            {{-- <datalist id="list_customer">
                                @foreach ($customer as $customerItem)
                                    <option value="{{ $customerItem->id_customer }}">{{ $customerItem->nama_customer }}</option>
                                @endforeach
                            </datalist> --}}
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
                                {{-- <input type="text" id="id_customer{{ $item->id_transaksi }}" name="id_customer"
                                    class="form-control" value="{{ $item->id_customer }}"> --}}
                                <select class="form-control" id="id_customer{{ $item->id_transaksi }}" name="id_customer">
                                    <option value="{{ $item->id_customer }}">{{ $item->id_customer }}</option>
                                    @foreach ($customer as $customerItem)
                                        <option value="{{ $customerItem->id_customer }}">{{ $customerItem->id_customer }}
                                            -
                                            {{ $customerItem->nama_customer }}</option>
                                    @endforeach
                                </select>
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
                                data-id="{{ $item->id_transaksi }}">Ya</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('script')
    <script>
        // Edit Script
        $(document).ready(function() {
            $(".btn-edit").click(function() {
                var id_transaksi = $(this).data("id");
                $("#editModal" + id_transaksi).modal("show");
            });

            $(".btn-save").click(function() {
                var id_transaksi = $(this).data("id");
                var tanggal = $("#tanggal" + id_transaksi).val();
                var id_customer = $("#id_customer" + id_transaksi).val();

                $.ajax({
                    url: "/transaksi/update/" + id_transaksi,
                    type: "POST",
                    data: {
                        id_transaksi: id_transaksi,
                        tanggal: tanggal,
                        id_customer: id_customer,
                        _token: $("meta[name='csrf-token']").attr("content")
                    },
                    success: function(data) {
                        $("#editModal" + id_transaksi).modal("hide");
                        location.reload();
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        });

        // Delete Script
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

        // Add Script
        $(document).ready(function() {
            $(".btn-add").click(function() {
                var addForm = $("#addForm");

                if (addForm.is(":visible")) {
                    addForm.hide();
                    $(this).text("+");
                    $(this).removeClass("btn-danger").addClass("btn-secondary");
                } else {
                    addForm.show();
                    $(this).text("×");
                    $(this).removeClass("btn-secondary").addClass("btn-danger");
                }
            });
        });

        // Close Modal Script
        function closeModal(modalId) {
            $('#editModal' + modalId).modal('hide');
            $('#deleteModal' + modalId).modal('hide');
        }

        // Scroll Script
        $(document).ready(function() {
            // Tombol Scroll ke Bawah
            $('#scrollToBottom').click(function() {
                $('html, body').animate({
                    scrollTop: $(document).height()
                }, 1);
            });

            // // Tombol Scroll ke Atas
            $('#scrollToTop').click(function() {
                $('html, body').animate({
                    scrollTop: 0
                }, 1);
            });

            $('.scroll-button-down').fadeIn();

            // // Tampilkan tombol saat scroll mencapai jarak tertentu
            $(window).scroll(function() {
                var scrollPosition = $(this).scrollTop();
                var documentHeight = $(document).height();
                var windowHeight = $(this).height();
                var scrollThreshold = 50; // Toleransi scroll sebelum mencapai paling akhir

                // Tombol Scroll ke Bawah
                if (scrollPosition + windowHeight >= documentHeight - scrollThreshold) {
                    $('.scroll-button-down').fadeOut();
                } else {
                    $('.scroll-button-down').fadeIn();
                }

                // Tombol Scroll ke Atas
                if (scrollPosition > scrollThreshold) {
                    $('.scroll-button-up').fadeIn();
                } else {
                    $('.scroll-button-up').fadeOut();
                }
            });
        });
    </script>
@endsection

@section('css')
    <style>
        #scrollToBottom {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 999;
            display: none;
        }

        #scrollToTop {
            position: fixed;
            bottom: 60px;
            right: 20px;
            z-index: 999;
            display: none;
        }
    </style>
@endsection
