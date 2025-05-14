@extends('dashboard.master')
@section('title', 'Data Bobot - Sistem Pendukung Keputusan Penilaian Siswa Berprestasi')

@section('custom-css')
<style>
.card-bobot {
    border: none;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    background: linear-gradient(135deg, #333333, #111111);
    color: #fff;
    cursor: pointer;
    height: 200px; /* Tetapkan tinggi card */
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.card-bobot:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 12px rgba(0,0,0,0.15);
    background: linear-gradient(135deg, #444444, #222222);
}

.card-bobot-title {
    margin-top: 0;
    margin-bottom: 20px;
    font-size: 22px;
    font-weight: bold;
    color: #fff;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
    text-align: center; /* Menengahkan teks judul */
}

.card-bobot-content {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: center; /* Menengahkan konten secara vertikal */
    align-items: center; /* Menengahkan konten secara horizontal */
}

.card-bobot-content h1 {
    font-size: 28px;
    margin: 0;
}

.marginResponsive {
    margin-top: 25px;
}

@media only screen and (min-width: 400px) and (max-width: 767px) {
    .marginResponsive {
        margin-top: 25px;
    }
}

.alert {
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-radius: 4px;
}

.alert-success {
    color: #155724;
    background-color: #d4edda;
    border-color: #c3e6cb;
}

.keterangan {
    margin-top: 20px;
    padding: 15px;
    background-color: #f8f9fa;
    border-radius: 8px;
    border-left: 5px solid #4CAF50;
}

.keterangan p {
    margin-bottom: 0;
    font-weight: bold;
    color: #333;
}

.card-bobot.kuning {
    background: linear-gradient(135deg, #FFD700, #FFA500);
}

.card-bobot.merah {
    background: linear-gradient(135deg, #FF4500, #8B0000);
}
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin marginResponsive">
            @if(session('message'))
            <div class="alert alert-success" role="alert">
                {{ session('message') }}
            </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <h2 class="text-center">Data Bobot</h2>
                    <div class="row">
                        @php
                        $totalBobot = 0;
                        @endphp
                        @foreach($data as $row)
                            @php
                            $totalBobot += $row->bobot;
                            @endphp
                            <div class="col-md-4 col-sm-6 mb-3 mt-2">
                                <div class="card-bobot" data-toggle="modal" data-target="#modal-{{$row->id}}">
                                    <h5 class="card-bobot-title">{{$row->nama}}</h5>
                                    <div class="card-bobot-content">
                                        <h1 class="text-center">{{$row->kode}} | {{$row->bobot}}</h1>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="modal-{{$row->id}}" tabindex="-1" role="dialog" aria-labelledby="modalLabel-{{$row->id}}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <form action="{{ route('bobot.update', $row->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalLabel-{{$row->id}}">Ubah Bobot {{$row->nama}}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="nama-{{$row->id}}">Nama</label>
                                                    <input type="text" class="form-control" id="nama-{{$row->id}}" value="{{$row->nama}}" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="kode-{{$row->id}}">Kode</label>
                                                    <input type="text" class="form-control" id="kode-{{$row->id}}" value="{{$row->kode}}" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="bobot-input-{{$row->id}}">Bobot</label>
                                                    <input type="number" class="form-control" id="bobot-input-{{$row->id}}" name="bobot" value="{{$row->bobot}}" step="0.01" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <!-- Card baru untuk total bobot dengan pengkondisian warna dan keterangan -->
                        <div class="col-md-4 col-sm-6 mb-3">
                            <div class="card-bobot {{ $totalBobot < 1 ? 'kuning' : ($totalBobot > 1 ? 'merah' : '') }}">
                                <h5 class="card-bobot-title">Total Bobot</h5>
                                <div class="card-bobot-content">
                                    <h1>{{ number_format($totalBobot, 2) }}</h1>
                                    <p class="mt-4"><strong>Keterangan:</strong> 
                                        @if($totalBobot < 1)
                                            Tingkatkan nilai bobot hingga menjadi 1 sesuai pedoman rumus
                                        @elseif($totalBobot == 1)
                                            Bobot sudah sesuai pedoman rumus
                                        @else
                                            Kurangi nilai bobot hingga menjadi 1 sesuai pedoman rumus
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Keterangan ditambahkan di sini -->
                        <div class="keterangan">
                            <p>Keterangan: Jumlah total bobot harus 1</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
$(document).ready(function() {
    $('.card-bobot').on('click', function() {
        var modalId = $(this).data('target');
        $(modalId).modal('show');
    });

    // Fungsi untuk menutup modal
    $('.modal .close, .modal .btn-secondary').on('click', function() {
        $(this).closest('.modal').modal('hide');
    });

    // Fungsi untuk menutup alert setelah beberapa detik
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000); // Alert akan hilang setelah 5 detik
});
</script>
@endsection