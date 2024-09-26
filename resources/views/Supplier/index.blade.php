@extends('layouts.master')

@section('title')
    Daftar Supplier
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Daftar Supplier</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header with-border">
                <button onclick="addForm('{{ route('supplier.store') }}')" class="btn btn-success btn-xs btn-flat">
                    <i class="fa fa-plus-circle"></i> Tambah
                </button>
            </div>
            <div class="box-body table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                                <th width="5%">No</th> 
                                <th>Nama</th>
                                <th>Telepon</th>
                                <th>Alamat</th>
                                <th width="15%"><i class="fa fa-cog"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- DataTable akan mengisi baris di sini -->
                        </tbody>
                    </table>
            </div>
        </div>
    </div>
</div>

@includeIf('supplier.form')
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let table;

    $(function () {
        table = $('.table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('supplier.data') }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'nama'},
                {data: 'telepon'},
                {data: 'alamat'},
                {data: 'aksi', searchable: false, sortable: false},
            ]
        });

        $('#modal-form').validator().on('submit', function (e) {
            if (!e.isDefaultPrevented()) {
                $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                .done((response) => {
                        $('#modal-form').modal('hide');
                        table.ajax.reload();
                        Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Supplier berhasil disimpan',
                        confirmButtonText: 'OK'
                    });
                    })
                    .fail((errors) => {
                        Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Tidak dapat menyimpan Supplier!',
                        confirmButtonText: 'OK'
                    });
                    });
                return false; // Prevent default form submission
            }
        });
    });

    function addForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah Supplier');
        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=nama]').focus();
    }

    function editForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Supplier');
        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#modal-form [name=nama]').focus();

        $.get(url)
            .done((response) => {
                $('#modal-form [name=nama]').val(response.nama);
                $('#modal-form [name=telepon]').val(response.telepon);
                $('#modal-form [name=alamat]').val(response.alamat);
            })
            .fail(() => {
                alert('Tidak dapat menampilkan data');
            });
    }

    function deleteData(url) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post(url, {
                        '_token': $('[name=csrf-token]').attr('content'),
                        '_method': 'delete'
                    })
                    .done((response) => {
                        $('#modal-form').modal('hide');
                        table.ajax.reload();
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Supplier berhasil dihapus',
                            confirmButtonText: 'OK'
                        });
                    })
                    .fail((errors) => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Tidak dapat menghapus Supplier!',
                            confirmButtonText: 'OK'
                        });
                    });
            }
        });
    }


 
    
</script>
@endpush
