@extends('layouts.master')

@section('title')
    Dashboard
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Dashboard</li>
    
@endsection

@section('content')
     <!-- Small boxes (Stat box) -->
     <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div  class="box-body text-center">
                    <h1>Selamat Datang Di DIFFY</h1>
                    <h2>Anda login {{ auth()->user()->name }} (KASIR)</h2>
                    <br><br>
                    <a href="{{ route('transaksi.baru') }}" class="btn btn-success btn-lg">Transkasi Baru</a>
                    <br><br><br>
                </div>
            </div>
        </div>
  </div>
      <!-- /.row (main row) -->
@endsection