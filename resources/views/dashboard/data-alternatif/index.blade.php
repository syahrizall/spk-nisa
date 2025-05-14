@extends('dashboard.master')
@section('title', 'Data Alternatif - Sistem Pendukung Keputusan Penilaian Siswa Berprestasi')

@section('custom-css')
    {{-- Font modern --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    {{-- DataTables --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .marginCard {
            margin-bottom: 10px;
        }

        @media only screen and (min-width: 400px) and (max-width: 767px) {
            .marginResponsive {
                margin-top: 25px;
            }
        }

        .kategori-header {
            background: linear-gradient(to right, #6a11cb, #00c6ff);
            color: white;
            padding: 12px 20px;
            border-radius: 10px;
            margin-bottom: 15px;
            font-size: 18px;
            font-weight: 600;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .table-container {
            margin-bottom: 35px;
            border-radius: 12px;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 6px 16px rgba(0,0,0,0.08);
        }

        .table thead {
            background-color: #f9fafb;
        }

        .table tbody tr:hover {
            background-color: #f1f5f9;
            transition: all 0.2s ease-in-out;
        }

        .btn-refresh {
            background-color: #6a11cb;
            color: white;
            border: none;
            padding: 8px 14px;
            border-radius: 6px;
            font-weight: 500;
            transition: background-color 0.2s ease;
        }

        .btn-refresh:hover {
            background-color: #5210a2;
            color: #fff;
        }

        .card-title {
            font-size: 22px;
            font-weight: 600;
        }
    </style>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin marginResponsive">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ __('Data Alternatif') }}</h4>

                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif

                    <div class="mb-3">
                        <a href="{{ route('refreshRanking') }}" class="btn-refresh"
                            onclick="return confirm('Apakah anda yakin ?')">
                            Refresh Data
                            <i class="ti-wand btn-icon-append"></i>
                        </a>
                    </div>

                    {{-- Tabel per kategori --}}
                    @php $tableCount = 1; @endphp
                    @foreach($data as $kategori => $pesertaList)
                        <div class="table-container">
                            <div class="kategori-header">{{ $kategori }}</div>
                            <div class="table-responsive">
                                <table id="table-{{ $tableCount }}" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Wiraga</th>
                                            <th>Wirama</th>
                                            <th>Wirasa</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 1; @endphp
                                        @foreach($pesertaList as $row)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $row->nama_peserta }}</td>
                                                <td>{{ $row->wiraga }}</td>
                                                <td>{{ $row->wirama }}</td>
                                                <td>{{ $row->wirasa }}</td>
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
                paging: true,
                pageLength: 10,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: true,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ entri",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                    paginate: {
                        next: "Berikutnya",
                        previous: "Sebelumnya"
                    }
                }
            });
            tableIndex++;
        }
    });
</script>
@endsection
