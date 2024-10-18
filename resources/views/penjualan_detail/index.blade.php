@extends('layouts.master')

@section('title')
    Transaksi Penjualan
@endsection

@push('css')
<style>
    .tampil-bayar {
        font-size: 5em;
        text-align: center;
        height: 100px;
    }

    .tampil-terbilang {
        padding: 10px;
        background: #f0f0f0;
    }

    .table-penjualan tbody tr:last-child {
        display: none;
    }

    @media(max-width: 768px) {
        .tampil-bayar {
            font-size: 3em;
            height: 70px;
            padding-top: 5px;
        }
    }
</style>
@endpush

@section('breadcrumb')
    @parent
    <li class="active">Transaksi Penjualan</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-body">
                    
                <form class="form-produk">
                    @csrf
                    <div class="form-group row">
                        <label for="kode_produk" class="col-lg-2">Kode Produk</label>
                        <div class="col-lg-5">
                            <div class="input-group">
                                <input type="hidden" name="id_penjualan" id="id_penjualan" value="{{ $id_penjualan }}">
                                {{-- HIDDEn: input ini berfungsi untuk menyimpan id_penjualan, yang menyimpan ID unik untuk transaksi penjualan saat ini --}}
                                {{-- {{ $id_penjualan }} akan diganti dengan nilai dari variabel $id_penjualan --}}
                                <input type="hidden" name="id_produk" id="id_produk">
                                <input type="text" class="form-control" name="kode_produk" id="kode_produk">
                                {{-- <input type="text" id="kode_produk" class="form-control" placeholder="masukan kode produk dan tekan enter"> --}}
                                {{-- tombol untuk menampilkan produk --}}
                                 <span class="input-group-btn">
                                    <button onclick="tampilProduk()" class="btn btn-info btn-flat" type="button"><i class="fa fa-arrow-right"></i></button>
                                    {{-- onclick="tampilproduk()" : ketika tombol ini di klik, fungsi javascript tampilproduk() akan di panggil --}}
                                </span>
                            </div>
                        </div>
                    </div>
                </form>

                <table class="table table-stiped table-bordered table-penjualan">
                    <thead>
                        <th width="5%">No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th width="15%">Jumlah</th>
                        <th>Diskon</th>
                        <th>Subtotal</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </thead>
                </table>

                <div class="row">
                    <div class="col-lg-8">
                        <div class="tampil-bayar bg-primary"></div>
                        <div class="tampil-terbilang"></div>
                    </div>
                    <div class="col-lg-4">
                        <form action="{{ route('transaksi.simpan') }}" class="form-penjualan" method="post">
                            @csrf
                            <input type="hidden" name="id_penjualan" value="{{ $id_penjualan }}">
                            <input type="hidden" name="total" id="total">
                            <input type="hidden" name="total_item" id="total_item">
                            <input type="hidden" name="bayar" id="bayar">
                            <input type="hidden" name="id_member" id="id_member" value="{{ $memberSelected->id_member }}">

                            <div class="form-group row">
                                <label for="totalrp" class="col-lg-2 control-label">Total</label>
                                <div class="col-lg-8">
                                    <input type="text" id="totalrp" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kode_member" class="col-lg-2 control-label">Member</label>
                                <div class="col-lg-8">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="kode_member" value="{{ $memberSelected->kode_member }}">
                                        <span class="input-group-btn">
                                            <button onclick="tampilMember()" class="btn btn-info btn-flat" type="button"><i class="fa fa-arrow-right"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="diskon" class="col-lg-2 control-label">Diskon Member</label>
                                <div class="col-lg-8">
                                    <input type="number" name="diskon" id="diskon" class="form-control" value="{{ ! empty($memberSelected->id_member) ? $diskon : 0}}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="diskonrp" class="col-lg-2 control-label">Total Diskon</label>
                                <div class="col-lg-8">
                                    <input type="text" name="diskonrp" id="diskonrp" class="form-control"  readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="bayar" class="col-lg-2 control-label">Bayar</label>
                                <div class="col-lg-8">
                                    <input type="text" id="bayarrp"  class="form-control" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="diterima" class="col-lg-2 control-label">Diterima</label>
                                <div class="col-lg-8">
                                    <input type="text" id="diterima"  class="form-control" name="diterima" 
                                        value="{{ $penjualan->diterima ?? 0 }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kembali" class="col-lg-2 control-label">Kembali</label>
                                <div class="col-lg-8">
                                    <input type="text" id="kembali"  name="kembali" class="form-control" value="0" readonly>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-sm btn-flat pull-right btn-simpan"><i class="fa fa-floppy-o"></i> Simpan Transaksi</button>
            </div>
        </div>
    </div>
</div>

@includeIf('Penjualan_detail.produk')
@includeIf('Penjualan_detail.member')
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let table, table2;
    let isStokValid = true; // Variabel untuk validasi stok

    $(function () {
        $('body').addClass('sidebar-collapse');

        table = $('.table-penjualan').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('transaksi.data', $id_penjualan) }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'kode_produk'},
                {data: 'nama_produk'},
                {data: 'harga_jual'},
                {data: 'stok'},
                {data: 'jumlah'},
                {data: 'diskon'},
                {data: 'subtotal'},
                {data: 'action', searchable: false, sortable: false},
            ],
            dom: 'Brt',
            bSort: false,
            paginate: false
        })
        .on('draw.dt', function () {
            loadForm($('#diskon').val());
            setTimeout(() => {
                $('#diterima').trigger('input');
            }, 300);
        });

        // Fungsi untuk memeriksa stok
        function checkStok() {
        isStokValid = true; // Reset nilai sebelum pengecekan stok

        // Cek stok untuk setiap produk dalam tabel
        $('.table-penjualan tbody tr').each(function () {
            let stokTersedia = parseInt($(this).find('.stok').text()); // Stok yang tersedia
            let jumlah = parseInt($(this).find('.quantity').val()) || 0; // Jumlah yang diinput

            if (jumlah > stokTersedia || stokTersedia === 0) {
                isStokValid = false; // Stok tidak cukup atau habis
                return false; // Hentikan pengecekan jika ada stok yang habis
            }
        });
    }

    $('#kode_produk').on('keypress', function (e) {
        if (e.which == 13) {  // Kode 13 adalah kode untuk tombol Enter

            e.preventDefault();
            let kodeProduk = $(this).val().trim(); // Ambil nilai kode produk dari input
            if (kodeProduk !== '') {
                // Kirimkan request AJAX ke server untuk menambah produk berdasarkan kode
                $.ajax({
                    url: '{{ route('transaksi.store') }}', // Sesuaikan dengan route yang benar
                    type: 'POST',
                    data: {
                        kode_produk: kodeProduk, 
                        id_penjualan: '{{ session('id_penjualan') }}', // Kirim ID Penjualan
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        // Reset input setelah produk ditambahkan
                        $('#kode_produk').val('');
                        // Lakukan sesuatu, misalnya refresh data tabel penjualan
                        // Refresh data tabel dengan memanggil ulang fungsi loadTable() jika ada
                        setTimeout(() => {
                            table.ajax.reload();
                        }, 200);
                    },
                    error: function (xhr) {
                        Swal.fire({
                            icon: "warning",
                            title: "Produk tidak ditemukan!",
                            showConfirmButton: false,
                            timer: 1500
                        });

                    // Kosongkan input setelah SweetAlert ditampilkan
                    $('#kode_produk').val('');
                    }
                });
            }
        }
    });

      // Menangani event 'input' pada elemen dengan kelas 'quantity'
    // Event 'input' akan dipicu setiap kali terjadi perubahan pada nilai input
    $(document).on('input', '.quantity', function () {
    // Mendapatkan nilai atribut 'data-id' dari elemen yang sedang diinput
    // 'id' ini dapat digunakan untuk mengidentifikasi item tertentu (misalnya, produk dalam keranjang)
    let id = $(this).data('id');

    // Mengambil nilai input dari elemen '.quantity' dan mengonversinya menjadi bilangan bulat (integer)
    // Variabel 'jumlah' menyimpan jumlah yang diinputkan pengguna
    let jumlah = parseInt($(this).val());

    // Mencari elemen dengan kelas '.stok' yang berada dalam elemen induk dari '.quantity'
    // Proses ini naik dua tingkat ke atas untuk mencari elemen '.stok'
    // Mengambil teks dari elemen '.stok' dan mengonversinya menjadi bilangan bulat (integer)
    // Variabel 'stok' menyimpan jumlah stok yang tersedia
    let stok = parseInt($(this).parent().parent().find('.stok').text());

    // Menampilkan nilai 'stok' di konsol browser untuk debugging
    // Ini digunakan untuk memastikan bahwa nilai yang diperoleh sudah benar
    console.log(stok);

            if (jumlah < 1) {
                $(this).val(1);
                Swal.fire({
                    icon: 'warning',
                    title: 'Jumlah Tidak Valid',
                    text: 'Jumlah tidak boleh kurang dari 1',
                    confirmButtonText: 'OK'
                });
                return;
            }
            if (jumlah > 10000) {
                $(this).val(10000);
                Swal.fire({
                    icon: 'warning',
                    title: 'Jumlah Tidak Valid',
                    text: 'Jumlah tidak boleh lebih dari 10000',
                    confirmButtonText: 'OK'
                });
                return;
            }

            if (stok < jumlah) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Stok Tidak Valid',
                    text: 'Jumlah stok melebihi stok yang tersedia',
                    confirmButtonText: 'OK'
                });
                return;
            }

            $.post(`{{ url('/transaksi') }}/${id}`, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'put',
                    'jumlah': jumlah
                })
                .done(response => {
                    table.ajax.reload(() => loadForm($('#diskon').val()));
                })
                .fail(errors => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Tidak dapat menyimpan data',
                        confirmButtonText: 'OK'
                    });
                    return;
                });
        });


        $(document).on('input', '#diskon', function () {
            if ($(this).val() == "") {
                $(this).val(0).select();
            }
            loadForm($(this).val());
        });

        $('#diterima').on('input', function () {
            let value = $(this).val().replace(/\D/g, ''); //Hapus karakter non digit
            if (value === "") {
                $(this).val(0);
                return;
            }
            $(this).val(new Intl.NumberFormat('id-ID').format(value)); // Format Kembali
            loadForm($('#diskon').val(), value);
        }).focus(function () {
            $(this).select();
        });

        $('.btn-simpan').on('click', function (e) {
            e.preventDefault();

            checkStok(); // Cek validasi stok sebelum menyimpan

            if (!isStokValid) {
            Swal.fire({
                icon: 'error',
                title: 'Stok Tidak Cukup!',
                text: 'Tidak dapat menyimpan transaksi karena stok habis atau tidak mencukupi.',
                confirmButtonText: 'OK'
            });
            return; // Hentikan proses simpan jika stok tidak cukup
        }

            // Mengambil nilai total pembayaran dari elemen dengan ID 'bayar'
            let totalBayar = parseFloat($('#bayar').val()
                .replace(/[^0-9.-]+/g, "")); // Menghapus semua karakter kecuali angka, titik, dan tanda minus
            // Mengubah string menjadi angka desimal (floating-point number)

            // Mengambil nilai uang yang diterima dari elemen dengan ID 'diterima'
            let uangDiterima = parseFloat($('#diterima').val()
                .replace(/\./g, '') // Menghapus titik yang mungkin digunakan sebagai pemisah ribuan
                .replace(',', '.')); // Mengganti koma dengan titik untuk penulisan angka desimal
            // Mengubah string menjadi angka desimal (floating-point number)

            // Mengambil nilai total diskon dari elemen dengan ID 'diskonrp'
            let totalDiskon = $('#diskonrp').val(); // Nilai disimpan sebagai string tanpa konversi

            // Menampilkan nilai-nilai tersebut di konsol browser untuk tujuan debugging
            console.log('Total Bayar:', totalBayar); // Memeriksa apakah total pembayaran sudah benar
            console.log('Uang Diterima:', uangDiterima); // Memeriksa apakah uang diterima sudah benar
            console.log('Total Diskon:', totalDiskon); // Memeriksa apakah total diskon sudah benar


            if (isNaN(uangDiterima) || isNaN(totalBayar)) { 
                // isnan adalah fungsi untuk mengecek apakah suatu nilai bukan angka jika nilai tersebut bukan angka, isnan akan mengembalikan true(benar) sebaliknya jika nilai tersebut angka isnan akan mengembalikan false(salah).
                Swal.fire({
                    icon: 'error',
                    title: 'Input Tidak Valid',
                    text: 'Silakan masukkan angka yang valid untuk bayar dan diterima.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            if (uangDiterima < totalBayar) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Uang diterima tidak mencukupi untuk membayar total transaksi!',
                    confirmButtonText: 'OK'
                });
                return;
            }

            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin menyimpan transaksi ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, simpan!',
                cancelButtonText: 'Tidak, batalkan'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('.form-penjualan').submit();
                }
            });
        });
    });

    function tampilProduk() {
        $('#modal-produk').modal('show');
    }
 
    function hideProduk() {
        $('#modal-produk').modal('hide');
    }

    function pilihProduk(id, kode) {
        $('#id_produk').val(id);
        $('#kode_produk').val(kode);
        hideProduk();
        tambahProduk();
    }

    function tambahProduk() {
        $.post('{{ route('transaksi.store') }}', $('.form-produk').serialize())
            .done(response => {
                $('#kode_produk').focus();
                // table.ajax.reload(() => loadForm($('#diskon').val()));
                table.ajax.reload(null, false)
            })
            .fail(errors => {
                alert('Tidak dapat menyimpan data');
                return;
            });
    }

    function tampilMember() {
        $('#modal-member').modal('show');
    }

    function pilihMember(id, kode) {
        $('#id_member').val(id);
        $('#kode_member').val(kode);
        $('#diskon').val('{{ $diskon }}');
        loadForm($('#diskon').val());
        $('#diterima').val(0).focus().select();
        hideMember();
    }

    function hideMember() {
        $('#modal-member').modal('hide');
    }

    function deleteForm(url) {
            $.post(url, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'delete'
                })
                .done((response) => {
                    table.ajax.reload(() => loadForm($('#diskon').val()));
                })
                .fail((errors) => {
                    alert('Tidak dapat menghapus data');
                    return;
                });
    }


    function loadForm(diskon = 0, diterima = 0) {
        $('#total').val($('.total').text());
        $('#total_item').val($('.total_item').text());

        $.get(`{{ url('/transaksi/loadform') }}/${diskon}/${$('.total').text()}/${diterima}`)
            .done(response => {
                $('#diskonrp').val('Rp. ' + response.diskonrp);
                console.log($('#diskonrp').val());
                $('#totalrp').val('Rp. ' + response.totalrp);
                $('#bayarrp').val('Rp. ' + response.bayarrp);
                $('#bayar').val(response.bayar);
                $('.tampil-bayar').text('Bayar: Rp. ' + response.bayarrp);
                $('.tampil-terbilang').text(response.terbilang);

                $('#kembali').val('Rp.' + response.kembalirp);
                if ($('#diterima').val() != 0) {
                    $('.tampil-bayar').text('Kembali: Rp. ' + response.kembalirp);
                    $('.tampil-terbilang').text(response.kembali_terbilang);
                }
            })
            .fail(errors => {
                alert('Tidak dapat menampilkan data');
                return;
            });
    }
</script>
@endpush