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

        <button id="scrollToTop" class="scroll-button-up">▲</button>
        <button id="scrollToBottom" class="scroll-button-down">▼</button>

        {{-- Add Form --}}
        <button type="button" class="btn btn-secondary btn-add">+</button>
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

        {{-- Card --}}
        <div class="row" id="card-row">
            @foreach ($barang as $item)
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><strong>{{ $item->nama_barang }}</strong></h5>
                            <p class="card-text">ID Barang: {{ $item->id_barang }}</p>
                            <p class="card-text">Harga: {{ $item->harga }}</p>

                        </div>
                        <div class="card-footer" id="ft">
                            <button type="button" class="btn btn-primary btn-edit" data-id="{{ $item->id_barang }}"
                                data-toggle="modal" data-target="#editModal{{ $item->id_barang }}">Edit</button>
                            <button type="button" class="btn btn-danger btn-delete" data-id="{{ $item->id_barang }}"
                                data-toggle="modal" data-target="#deleteModal{{ $item->id_barang }}">Delete</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
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
                        <button type="button" class="btn btn-outline-danger btn-sm" data-dismiss="modal" aria-label="Close"
                            onclick="closeModal('{{ $item->id_barang }}')">
                            <span aria-hidden="true">&times;</span>
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
                        <button type="button" class="btn btn-outline-danger btn-sm" data-dismiss="modal"
                            aria-label="Close" onclick="closeModal('{{ $item->id_barang }}')">
                            <span aria-hidden="true">&times;</span>
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
                            <button type="submit" class="btn btn-primary btn-delete-confirm">Ya</button>
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

        // Delete Script
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
    <!-- CSS Styles -->
    <style>
        #card-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-gap: 20px;
        }

        #ft {
            padding: 3.5%;
            text-align: center;
            height: 58px;
            margin-top: 3px;
            margin-bottom: 0px;
            border-radius: 0px 0px 27px 27px;
        }

        .card {
            width: 280px;
            height: 105%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border-radius: 30px;
            background-color: #e5e5e583;
            box-shadow: 2px 2px 10px #88888867;
        }

        .card:hover {}

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
