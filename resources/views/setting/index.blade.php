@extends('layouts.master')

@section('title')
    Pengaturan
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Pengaturan</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <form action="{{ route('setting.update') }}" method="post" class="form-setting" data-toggle="validator" enctype="multipart/form-data">
                    @csrf
                    <div class="box-body">
                        <div class="form-group row">
                            <label for="nama_perusahaan" class="col-lg-2 col-lg-offset-1 control-label">Nama Perusahaan</label>
                            <div class="col-lg-6">
                                <input type="text" name="nama_perusahaan" class="form-control" id="nama_perusahaan" required outofocus>
                                <span class="help-block with-errors"></span>
                            </div>
                            <!-- offset digunanakan untuk mengatur jarak pada modal/container yang ditampilkan -->
                        </div>
                        <div class="form-group row">
                            <label for="telepon" class="col-lg-2 col-lg-offset-1 control-label">Telepon</label>
                            <div class="col-lg-6">
                                <input type="number" name="telepon" class="form-control" id="telepon" required>
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-lg-2 col-lg-offset-1 control-label">Email</label>
                            <div class="col-lg-6">
                                <input type="email" name="email" class="form-control" id="email" required>
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="youtube" class="col-lg-2 col-lg-offset-1 control-label">Youtube</label>
                            <div class="col-lg-6">
                                <input type="text" name="youtube" class="form-control" id="youtube" required>
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="instagram" class="col-lg-2 col-lg-offset-1 control-label">Instagram</label>
                            <div class="col-lg-6">
                                <input type="text" name="instagram" class="form-control" id="instagram" required>
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="twitter" class="col-lg-2 col-lg-offset-1 control-label">Twitter</label>
                            <div class="col-lg-6">
                                <input type="text" name="twitter" class="form-control" id="twitter" required>
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="facebook" class="col-lg-2 col-lg-offset-1 control-label">Facebook</label>
                            <div class="col-lg-6">
                                <input type="text" name="facebook" class="form-control" id="facebook" required>
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="alamat" class="col-lg-2 col-lg-offset-1 control-label">Alamat</label>
                            <div class="col-lg-6">
                                <textarea name="alamat" class="form-control" id="alamat" rows="3" required></textarea>
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="path_logo" class="col-lg-2 col-lg-offset-1 control-label">Logo Perusahaan</label>
                            <div class="col-lg-4">
                                <input type="file" name="path_logo" class="form-control" id="path_logo"
                                onchange="preview('.tampil-logo', this.files[0], 100)">
                                <span class="help-block with-errors"></span>
                                <br>
                                <div class="tampil-logo"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="path_kartu_member" class="col-lg-2 col-lg-offset-1 control-label">Kartu Member </label>
                            <div class="col-lg-4">
                                <input type="file" name="path_kartu_member" class="form-control" id="path_kartu_member" 
                                onchange="preview('.tampil-kartu-member', this.files[0], 300)">
                                <span class="help-block with-errors"></span>
                                <br>
                                <div class="tampil-kartu-member"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="diskon" class="col-lg-2 col-lg-offset-1 control-label">Diskon</label>
                            <div class="col-lg-2">
                                <input type="number" name="diskon" class="form-control" id="diskon" required>
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tipe_nota" class="col-lg-2 col-lg-offset-1 control-label">Tipe Nota</label>
                            <div class="col-lg-2">
                                <select  name="tipe_nota" class="form-control" id="tipe_nota" required>
                                    <option value="1">Nota Kecil</option>
                                    <option value="2">Nota Besar</option>
                                </select>
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer text-right">
                        <button class="btn btn-sm btn-flat btn-primary"><i class="fa fa-save"></i>  Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(function () {
            showData();

            $('.form-setting').validator().on('submit', function (e) {
                if (! e.preventDefault()) {
                    $.ajax({
                        url: $('.form-setting').attr('action'),
                        type: $('.form-setting').attr('method'),
                        data: new FormData($('.form-setting')[0]),
                        async: false,
                        processData: false,
                        contentType: false,
                    })
                    .done(response => {
                        showData();
                        Swal.fire({
                            icon: "success",
                            title: "Perubahan berhasil disimpan!",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    })
                    .fail(errors => {
                        alert('Tidak dapat menyimpan data');
                        return;
                    });
                };
            });
        });
 
        function showData() {
            $.get('{{ route('setting.show') }}')
                .done(response => {
                    $('[name=nama_perusahaan]').val(response.nama_perusahaan);
                    $('[name=telepon]').val(response.telepon);
                    $('[name=email]').val(response.email);
                    $('[name=youtube]').val(response.youtube);
                    $('[name=instagram]').val(response.instagram);
                    $('[name=twitter]').val(response.twitter);
                    $('[name=facebook]').val(response.facebook);
                    $('[name=alamat]').val(response.alamat);
                    $('[name=diskon]').val(response.diskon);
                    $('[name=tipe_nota]').val(response.tipe_nota);
                    $('title').text(response.nama_perusahaan + ' | Pengaturan');
                    $('.logo-lg').text(response.nama_perusahaan.split('').map(function(item){return item[0]}).join(''));

                    $('.tampil-logo').html(`<img src="{{ url('/') }}${response.path_logo}" width="100">`);
                    $('.tampil-kartu-member').html(`<img src="{{ url('/') }}${response.path_kartu_member}" width="300">`);
                    $('[rel-icon]').attr('href', `{{ url('/') }}/${response.path_logo}`)


                })
                .fail(errors => {
                    alert('Tidak dapat menampilkan data');
                    return;
                })
        }
    </script>
    <!-- fungsinya split untuk memecah string atau array, nah untuk separator yg di pakai disini yaitu spasi,jadi semisal ada kata Toko Ku ketika di split maka di dapat array [0 => 'Toko', 1 => 'Ku'] selanjutnya kita looping tiap2 array tersebut dan ambil huruf pertama maka didapat [0 => 'T', 1 => 'K'] setelah itu kita perlu join lgi misal dgn pemisal nya gak ada maka di dapat string sprti TK -->
@endpush