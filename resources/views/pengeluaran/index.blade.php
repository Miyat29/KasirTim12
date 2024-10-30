@extends('layouts.master')

@section('title')
    Daftar Pengeluaran
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Daftar Pengeluaran</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header with-border">
                    <button onclick="addForm('{{ route('pengeluaran.store') }}')" class="btn btn-success btn-xs btn-flat"><i
                            class="fa fa-plus-circle"></i> Tambah</button>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <th width="5%">No</th>
                            <th>Tanggal</th>
                            <th>Deskripsi</th>
                            <th>Nominal</th>
                            <th width="15%"><i class="fa fa-cog"></i></th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @includeIf('pengeluaran.form')
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let table;

        $(function () {
    // Event keyup untuk otomatis memformat saat mengetik
    $('#modal-form').on('keyup', '[name=nominal]', function () {
        let value = $(this).val();
        $(this).val(formatCurrency(value)); // Format nilai saat mengetik
    });

    // DataTable initialization
    table = $('.table').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        autoWidth: false,
        ajax: {
            url: '{{ route('pengeluaran.data') }}',
        },
        columns: [
            {data: 'DT_RowIndex', searchable: false, sortable: false},
            {data: 'created_at'},
            {data: 'deskripsi'},
            {data: 'nominal'},
            {data: 'aksi', searchable: false, sortable: false},
        ]
    });

    // Form submission handler
    $('#modal-form').validator().on('submit', function (e) {
        if (!e.preventDefault()) {
            // Hapus format sebelum mengirim ke server
            $('[name=nominal]').each(function() {
                let value = $(this).val().replace(/\./g, '').replace('Rp ', ''); // Hapus titik dan Rp
                $(this).val(value); // Set nilai tanpa format
            });

            $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
            .done((response) => {
                $('#modal-form').modal('hide');
                table.ajax.reload();
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Data Pengeluaran berhasil disimpan',
                    confirmButtonText: 'Oke'
                });
            })
            .fail((errors) => {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Tidak dapat menyimpan data pengeluaran!',
                    confirmButtonText: 'Oke'
                });
            });
        }
    });
});

// Fungsi untuk memformat angka dengan pemisah ribuan dan prefix Rp




        function addForm(url) {
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text('Tambah Pengeluaran');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('post');
            $('#modal-form [name=deskripsi]').focus();
        }

        function editForm(url) {
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text('Edit Pengeluaran');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('put');
            $('#modal-form [name=deskripsi]').focus();

            $.get(url)
                .done((response) => {
                    $('#modal-form [name=deskripsi]').val(response.deskripsi);
                    $('#modal-form [name=nominal]').val(response.nominal);
                })
                .fail((errors) => {
                    alert('Tidak dapat menampilkan data');
                    return;
                });
        }

         function formatCurrency(value) {
        return value
            .replace(/\D/g, '') // Hanya angka
            .replace(/\B(?=(\d{3})+(?!\d))/g, "."); // Tambahkan titik sebagai pemisah ribuan
        };

        function deleteData(url) {
            Swal.fire({
                title: 'Yakin ingin menghapus data terpilih?',
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post(url, {
                            '_token': $('[name=csrf-token]').attr('content'),
                            '_method': 'delete'
                        })
                        .done((response) => {
                            table.ajax.reload();
                            Swal.fire(
                                'Berhasil!',
                                'Data telah dihapus.',
                                'success'
                            );
                        })
                        .fail((errors) => {
                            Swal.fire(
                                'Gagal!',
                                'Data tidak dapat dihapus.',
                                'error'
                            );
                        });
                }
            });
        }
    </script>
@endpush
