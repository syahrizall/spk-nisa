@extends('dashboard.master')
@section('title', 'Data Ranking - Sistem Pendukung Keputusan Penilaian Siswa Berprestasi')

@section('custom-css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
@endsection

@section('content')
<style>
.marginCard { margin-bottom: 10px; }

@media only screen and (min-width: 400px) and (max-width: 767px) {
    .marginResponsive { margin-top: 25px; }
}

.kategori-header {
    background: linear-gradient(to right, #ff6a00, #ee0979);
    color: white;
    padding: 12px 20px;
    border-radius: 6px;
    margin-bottom: 15px;
    font-size: 18px;
    font-weight: bold;
}

.table-container {
    margin-bottom: 40px;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 15px;
    background-color: #ffffff;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
}
</style>

<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin marginResponsive">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ __('Data Ranking') }}</h4>
                    @if(session()->has('message'))
                        <div class="alert alert-success">{{ session()->get('message') }}</div>
                    @endif
                    <div class="mb-3">
                        <a href="{{ route('refreshRanking') }}" class="btn btn-secondary btn-rounded"
                            onclick="return confirm('Apakah anda yakin ?')">Refresh Data
                            <i class="ti-wand btn-icon-append"></i>
                        </a>
                    </div>

                    {{-- Table Per Kategori --}}
                    @php $tableCount = 1; @endphp
                    @foreach($data as $kategori => $list)
                        <div class="table-container">
                            <div class="kategori-header">{{ $kategori }}</div>
                            <div class="table-responsive">
                                <table id="table-{{ $tableCount }}" class="table table-bordered table-striped">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Wiraga</th>
                                            <th>Wirama</th>
                                            <th>Wirasa</th>
                                            <th>Nilai Akhir</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 1; @endphp
                                        @foreach($list as $row)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $row->nama_peserta }}</td>
                                                <td>{{ $row->wiraga }}</td>
                                                <td>{{ $row->wirama }}</td>
                                                <td>{{ $row->wirasa }}</td>
                                                <td><strong>{{ number_format($row->nilai_akhir, 2) }}</strong></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @php $tableCount++; @endphp
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    let tableIndex = 1;
    while ($('#table-' + tableIndex).length) {
        $('#table-' + tableIndex).DataTable({
            paging: false,
            info: false,
            searching: false,
            ordering: false
        });
        tableIndex++;
    }
});
</script>
@endsection
