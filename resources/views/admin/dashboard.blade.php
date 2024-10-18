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
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{ $kategori }}</h3>

              <p>Total Kategori</p>
            </div>
            <div class="icon">
              <i class="fa fa-cube"></i>
            </div>
            <a href="{{ route('kategori.index') }}" class="small-box-footer">lihat <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{ $produk }}</h3>

              <p>Total Produk</p>
            </div>
            <div class="icon">
              <i class="fa fa-cubes"></i>
            </div>
            <a href="{{ route('produk.index') }}" class="small-box-footer">lihat <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{ $supplier }}</h3>

              <p>Total Supplier</p>
            </div>
            <div class="icon">
              <i class="fa fa-truck"></i>
            </div>
            <a href="{{ route('supplier.index') }}" class="small-box-footer">lihat <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{ $member }}</h3>

              <p>Total Member</p>
            </div>
            <div class="icon">
              <i class="fa fa-id-card "></i>
            </div>
            <a href="{{ route('member.index') }}" class="small-box-footer">lihat <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <!-- Main row -->
   <!-- /.row -->

   <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Grafik Pendapatan {{ tanggal_indonesia($tanggal_awal_asli,false) }} s/d {{ tanggal_indonesia($tanggal_akhir_asli,false) }}</h3>

        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">

              <div class="chart">
                <!-- Sales Chart Canvas -->
                <canvas id="salesChart" style="height: 180px;"></canvas>
              </div>
              <!-- /.chart-responsive -->
            </div>
            <!-- /.col -->
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
      <!-- /.row (main row) -->
      <div class="row">
        <div class="col-lg-12">
            <div class="box">
              <br>
              <h3 style="text-align: center; font-weight: bold;">Informasi Produk</h3>
                <div class="box-header with-border">
                </div>
                <div class="box-body table-responsive">
                    <form action="" method="post" class="form-produk">
                        @csrf
                        <table class="table table-stiped table-bordered">
                            <thead>
                                <th width="5%">No</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Merk</th>
                                <th>Stok</th>
                                <th>Keterangan</th>
                            </thead>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
@endsection

@push('scripts')
<!-- ChartJS -->
<script src="{{ asset('admin-lte/bower_components/chart.js/Chart.js') }}"></script>
    <script>
      $(function() {
            // Get context with jQuery - using jQuery's .get() method.
            var salesChartCanvas = $('#salesChart').get(0).getContext('2d');
            // This will get the first returned node in the jQuery collection.
            var salesChart = new Chart(salesChartCanvas);

            var salesChartData = {
                labels: {{ json_encode($data_tanggal) }},
                datasets: [{
                    label: 'pendapatan',
                    fillColor: 'rgba(60,141,188,0.9)',
                    strokeColor: 'rgba(60,141,188,0.8)',
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: {{ json_encode($data_pendapatan) }}
                }]
            };
            var salesChartOptions = {
                    pointDot: false,
                    responsive: true,
                    scaleLabel: function(label) {
                        return 'Rp ' + label.value.toString().replace(/\B(?=(\d{3})+(?!\d))/g,
                            "."); // Format Rupiah
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                userCallback: function(value) {
                                    value = value.toString();
                                    // Menambahkan titik sebagai pemisah ribuan
                                    value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                                    return 'Rp ' + value; // Menambahkan "Rp" di depan nilai
                                }
                            }
                        }]
                    }
                };

                salesChart.Line(salesChartData, salesChartOptions);
            }); 

let table;

$(function () {
    table = $('.table').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        autoWidth: false,
        ajax: {
            url: '{{ route('produk.data') }}',
        },
        columns: [
            {data: 'DT_RowIndex', searchable: false, sortable: false},
            {data: 'kode_produk'},
            {data: 'nama_produk'},
            {data: 'nama_kategori'},
            {data: 'merk'},
            {data: 'stok'},
            {data: 'keterangan'},
        ]
    });
});

    </script>
@endpush