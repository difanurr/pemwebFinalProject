@extends('layouts.default')

@section('Title', 'Data Detail Transaksi')

@section('content')
    <div class="container">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <h2>Data Detail Transaksi</h2>

        <button id="scrollToTop" class="scroll-button-up">▲</button>
        <button id="scrollToBottom" class="scroll-button-down">▼</button>

        <button type="button" class="btn btn-secondary btn-add">+</button>
        <div id="addForm" style="display:none">
            <form action="{{ route('detail.add') }}" method="POST">
                @csrf
                <div class="form-group row">
                    <label for="id_transaksi" class="col-sm-2 col-form-label">ID Transaksi</label>
                    <div class="col-sm-5">
                        <input type="number" class="form-control" name="id_transaksi">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="id_barang" class="col-sm-2 col-form-label">ID Barang</label>
                    <div class="col-sm-5">
                        {{-- <input type="text" class="form-control" name="id_barang"> --}}
                        <select class="form-control" name="id_barang">
                            <option value="" disabled selected>Pilih ID Barang</option>
                            @foreach ($barang as $barangItem)
                                <option value="{{ $barangItem->id_barang }}">{{ $barangItem->id_barang }} -
                                    {{ $barangItem->nama_barang }} (Rp{{ $barangItem->harga }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="jumlah_beli" class="col-sm-2 col-form-label">Jumlah Beli</label>
                    <div class="col-sm-5">
                        <input type="number" class="form-control" name="jumlah_beli" oninput="addTotalBeli()">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="harga_beli" class="col-sm-2 col-form-label">Harga Beli</label>
                    <div class="col-sm-5">
                        <input type="number" class="form-control" name="harga_beli" oninput="addTotalBeli()">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="total_beli" class="col-sm-2 col-form-label">Total Beli</label>
                    <div class="col-sm-5">
                        <input type="number" class="form-control" name="total_beli" id="total_beli" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </div>
            </form>
        </div>

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>ID Barang</th>
                    <th>Jumlah Beli</th>
                    <th>Harga Beli</th>
                    <th>Total Beli</th>
                    <th colspan="2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $groupedDetail = $detail->sortBy(['id_transaksi', 'id_barang'])->groupBy('id_transaksi');
                @endphp

                @foreach ($groupedDetail as $idTransaksi => $items)
                    @php
                        $rowspan = count($items);
                    @endphp

                    @foreach ($items as $key => $item)
                        <tr>
                            @if ($key === 0)
                                <td rowspan="{{ $rowspan }}">{{ $item->id_transaksi }}</td>
                            @endif
                            <td>{{ $item->id_barang }}</td>
                            <td>{{ $item->jumlah_beli }}</td>
                            <td>{{ $item->harga_beli }}</td>
                            <td>{{ $item->total_beli }}</td>
                            <td>
                                <button type="button" class="btn btn-primary btn-edit"
                                    data-id="{{ $item->id_detail_transaksi }}" data-toggle="modal"
                                    data-target="#editModal{{ $item->id_detail_transaksi }}">Edit</button>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-delete"
                                    data-id="{{ $item->id_detail_transaksi }}" data-toggle="modal"
                                    data-target="#deleteModal{{ $item->id_detail_transaksi }}">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>

    </div>
@endsection

@section('modal')
    @foreach ($detail as $item)
        <!-- Edit Modal -->
        <div class="modal fade" id="editModal{{ $item->id_detail_transaksi }}" tabindex="-1" role="dialog"
            aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Data Detail Transaksi</h5>
                        <button type="button" class="btn btn-outline-danger btn-sm" data-dismiss="modal" aria-label="Close"
                        onclick="closeModal('{{ $item->id_detail_transaksi }}')">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            @csrf
                            <div class="form-group">
                                <label for="id_transaksi">ID Transaksi:</label>
                                <input type="number" class="form-control"
                                    id="id_transaksi{{ $item->id_detail_transaksi }}" value="{{ $item->id_transaksi }}">
                            </div>
                            <div class="form-group">
                                <label for="id_barang">ID Barang:</label>
                                {{-- <input type="text" id="id_barang{{ $item->id_detail_transaksi }}" name="id_barang"
                                    class="form-control" value="{{ $item->id_barang }}"> --}}
                                <select class="form-control" id="id_barang{{ $item->id_detail_transaksi }}"
                                    name="id_barang">
                                    <option value="{{ $item->id_barang }}">{{ $item->id_barang }}
                                    </option>
                                    @foreach ($barang as $barangItem)
                                        <option value="{{ $barangItem->id_barang }}">{{ $barangItem->id_barang }} -
                                            {{ $barangItem->nama_barang }} (Rp{{ $barangItem->harga }})</option>
                                    @endforeach
                                </select>

                            </div>

                            <div class="form-group">
                                <label for="jumlah_beli">Jumlah Beli:</label>
                                <input type="number" id="jumlah_beli{{ $item->id_detail_transaksi }}" name="jumlah_beli"
                                    class="form-control" value="{{ $item->jumlah_beli }}"
                                    oninput="editModalTotalBeli('{{ $item->id_detail_transaksi }}')">
                            </div>
                            <div class="form-group">
                                <label for="harga_beli">Harga Beli:</label>
                                <input type="number" id="harga_beli{{ $item->id_detail_transaksi }}" name="harga_beli"
                                    class="form-control" value="{{ $item->harga_beli }}"
                                    oninput="editModalTotalBeli('{{ $item->id_detail_transaksi }}')">
                            </div>
                            <div class="form-group">
                                <label for="total_beli">Total Beli:</label>
                                <input type="number" id="total_beli{{ $item->id_detail_transaksi }}" name="total_beli"
                                    class="form-control" value="{{ $item->total_beli }}" readonly>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            onclick="closeModal('{{ $item->id_detail_transaksi }}')">Tutup</button>
                        <button type="button" class="btn btn-primary btn-save"
                            data-id="{{ $item->id_detail_transaksi }}">Simpan Perubahan</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteModal{{ $item->id_detail_transaksi }}" tabindex="-1" role="dialog"
            aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Apa Anda yakin ingin menghapus data ini?</h5>
                        <button type="button" class="btn btn-outline-danger btn-sm" data-dismiss="modal" aria-label="Close"
                        onclick="closeModal('{{ $item->id_detail_transaksi }}')">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ID Transaksi : {{ $item->id_transaksi }}<br>
                        ID Barang : {{ $item->id_barang }}<br>
                        Jumlah Beli : {{ $item->jumlah_beli }}<br>
                        Harga Beli : {{ $item->harga_beli }}<br>
                        Total Beli : {{ $item->total_beli }}
                    </div>
                    <div class="modal-footer">
                        <form id="deleteForm{{ $item->id_detail_transaksi }}"
                            action="{{ route('detail.delete', $item->id_detail_transaksi) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-secondary"
                                onclick="closeModal('{{ $item->id_detail_transaksi }}')">Tidak</button>
                            <button type="submit" class="btn btn-primary btn-delete-confirm"
                                data-id="{{ $item->id_detail_transaksi }}">Ya</button>
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
                var id_detail_transaksi = $(this).data("id");
                $("#editModal" + id_detail_transaksi).modal("show");
            });

            $(".btn-save").click(function() {
                var id_detail_transaksi = $(this).data("id");
                var id_transaksi = $("#id_transaksi" + id_detail_transaksi).val();
                var id_barang = $("#id_barang" + id_detail_transaksi).val();
                var jumlah_beli = $("#jumlah_beli" + id_detail_transaksi).val();
                var harga_beli = $("#harga_beli" + id_detail_transaksi).val();
                var total_beli = $("#total_beli" + id_detail_transaksi).val();

                // $.post("/detail/update/" + id_detail_transaksi, {
                //     id_transaksi: id_transaksi,
                //     id_barang: id_barang,
                //     jumlah_beli: jumlah_beli,
                //     harga_beli: harga_beli,
                //     total_beli: total_beli,
                //     _token: $("meta[name='csrf-token']").attr("content")
                // }, function() {
                //     $("#editModal" + id_detail_transaksi).modal("hide");
                //     location.reload();
                // }, function(error) {
                //     console.log(error.response.data);
                // })

                $.ajax({
                    url: "/detail/update/" + id_detail_transaksi,
                    type: "POST",
                    data: {
                        id_transaksi: id_transaksi,
                        id_barang: id_barang,
                        jumlah_beli: jumlah_beli,
                        harga_beli: harga_beli,
                        total_beli: total_beli,
                        _token: $("meta[name='csrf-token']").attr("content")
                    },
                    success: function() {
                        $("#editModal" + id_detail_transaksi).modal("hide");
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
                var id_detail_transaksi = $(this).data("id");
                $("#deleteModal" + id_detail_transaksi).modal("show");
            });

            $(".btn-delete-confirm").click(function() {
                var id_detail_transaksi = $(this).data("id");

                $.post("/detail/delete/" + id_detail_transaksi, {
                    id_detail_transaksi: id_detail_transaksi,
                    _token: $("meta[name='csrf-token']").attr("content")
                }, function() {
                    $("#deleteModal" + id_detail_transaksi).modal("hide");
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

        // Total Beli Script
        function addTotalBeli() {
            var jumlahBeli = parseFloat(document.getElementsByName('jumlah_beli')[0].value);
            var hargaBeli = parseFloat(document.getElementsByName('harga_beli')[0].value);
            var totalBeli = jumlahBeli * hargaBeli;
            document.getElementById('total_beli').value = totalBeli;
        }

        // Edit Modal Total Beli Script
        function editModalTotalBeli(detailId) {
            var jumlahBeli = parseFloat(document.getElementById('jumlah_beli' + detailId).value);
            var hargaBeli = parseFloat(document.getElementById('harga_beli' + detailId).value);
            var totalBeli = jumlahBeli * hargaBeli;
            document.getElementById('total_beli' + detailId).value = totalBeli;
        }

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