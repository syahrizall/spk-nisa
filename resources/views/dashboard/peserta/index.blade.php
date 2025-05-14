@extends('dashboard.master')
@section('title', 'Data Penerima - Sistem Pendukung Keputusan Penilaian Siswa Berprestasi')

@section('custom-css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
@endsection
@section('content')

<style>
.marginCard {
    margin-bottom: 10px;
}

@media only screen and (min-width: 400px) and (max-width: 767px) {
    .marginResponsive {
        margin-top: 25px;
    }
}
</style>

<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin marginResponsive">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ __('Data Calon Peserta') }}</h4>
                    @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                    @endif

                    <div class="table-responsive">
                        <table id="dataTable" class="table">
                            <thead>
                                <tr>
                                    <button type="button"
                                        class="btn btn-primary btn-sm btn-rounded btn-icon-text marginCard"
                                        data-toggle="modal" data-target="#create">
                                        <i class="ti-upload btn-icon-prepend"></i>Create</button>
                                </tr>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Lengkap</th>
                                    <th>Kategori</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Asal Sekolah</th>
                                    <th>Nomor Telepon</th>
                                    <th>Wiraga</th>
                                    <th>Wirama</th>
                                    <th>Wirasa</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach($data as $row)
                                    <tr>
                                        <td>{{$no++}}</td>
                                        <td>{{$row->nama_lengkap}}</td>
                                        <td>{{$row->kategori_peserta}}</td>
                                        <td>{{$row->jenis_kelamin}}</td>
                                        <td>{{$row->tanggal_lahir}}</td>
                                        <td>{{$row->asal_sekolah}}</td>
                                        <td>{{$row->nomor_hp}}</td>
                                        <td>{{$row->wiraga}}</td>
                                        <td>{{$row->wirama}}</td>
                                        <td>{{$row->wirasa}}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-dark btn-sm btn-rounded btn-icon-prepend"
                                                data-toggle="modal" data-target="#edit{{$row->id}}">
                                                <i class="ti-reload btn-icon-prepend"></i>Edit</button>
                                            <a href="{{route('deletePeserta', ['id'=>$row->id])}}" 
                                                class="btn btn-danger btn-rounded btn-icon-text"
                                                onclick="return confirm('Apakah anda yakin ?')">Delete
                                                <i class="ti-trash btn-icon-append"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create -->
<div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Create Data Peserta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('createPeserta')}}" method="POST">
                <div class="modal-body">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" required">
                    </div>

                    <div class="mb-3">
                        <label for="kategori_peserta_id" class="form-label">Kategori Peserta</label>
                        <select type="text" name="kategori_peserta_id" class="form-control">
                            @foreach($kategori_peserta as $row)
                                <option value="{{$row->id}}">{{$row->nama}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="asal_sekolah" class="form-label">Asal Sekolah</label>
                        <input type="text" name="asal_sekolah" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="nomor_hp" class="form-label">Nomor Telepon</label>
                        <input type="number" name="nomor_hp" class="form-control" required maxlength="15">
                    </div>

                    <div class="mb-3">
                        <label for="wiraga" class="form-label">Wiraga</label>
                        <select type="text" name="wiraga" class="form-control">
                            @foreach($wiraga as $row)
                                <option value="{{$row->id}}">{{$row->range}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="wirama" class="form-label">Wirama</label>
                        <select type="text" name="wirama" class="form-control">
                            @foreach($wirama as $row)
                                <option value="{{$row->id}}">{{$row->range}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="wirasa" class="form-label">Wirasa</label>
                        <select type="text" name="wirasa" class="form-control">
                            @foreach($wirasa as $row)
                                <option value="{{$row->id}}">{{$row->range}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded"
                        style="margin-left:5px; margin:auto;">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit -->
@foreach($data as $row)
    <div class="modal fade" id="edit{{$row->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle{{$row->id}}"
    aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle{{$row->id}}">Edit Data Peserta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('updatePeserta', ['id' => $row->id]) }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control" required
                                style="text-transform: capitalize;" value="{{ $row->nama_lengkap }}">
                        </div>

                        <div class="mb-3">
                            <label for="kategori_peserta_id" class="form-label">Kategori Peserta</label>
                            <select name="kategori_peserta_id" class="form-control">
                            <option value="{{$row->kategori_peserta_id}}">{{$row->kategori_peserta}}</option>
                            <option value="" disabled>=============================</option>
                                @foreach($kategori_peserta as $rows)
                                    <option value="{{ $rows->id }}">
                                        {{ $rows->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-control" required>
                                <option value="">-- Pilih --</option>
                                <option value="Laki-laki" {{ $row->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ $row->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control" required
                                value="{{ $row->tanggal_lahir }}">
                        </div>

                        <div class="mb-3">
                            <label for="asal_sekolah" class="form-label">Asal Sekolah</label>
                            <input type="text" name="asal_sekolah" class="form-control" required
                                value="{{ $row->asal_sekolah }}">
                        </div>

                        <div class="mb-3">
                            <label for="nomor_hp" class="form-label">Nomor Telepon</label>
                            <input type="text" name="nomor_hp" class="form-control" required maxlength="15"
                                value="{{ $row->nomor_hp }}">
                        </div>

                        <div class="mb-3">
                            <label for="wiraga" class="form-label">Wiraga</label>
                            <select name="wiraga" class="form-control">
                            <option value="{{$row->wiraga_id}}">{{$row->wiraga}}</option>
                            <option value="" disabled>=============================</option>
                                @foreach($wiraga as $rows)
                                    <option value="{{ $rows->id }}">
                                        {{ $rows->range }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="wirama" class="form-label">Wirama</label>
                            <select name="wirama" class="form-control">
                            <option value="{{$row->wirama_id}}">{{$row->wirama}}</option>
                            <option value="" disabled>=============================</option>
                                @foreach($wirama as $rows)
                                    <option value="{{ $rows->id }}" {{ $row->wirama == $rows->id ? 'selected' : '' }}>
                                        {{ $rows->range }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="wirasa" class="form-label">Wirasa</label>
                            <select name="wirasa" class="form-control">
                            <option value="{{$row->wirasa_id}}">{{$row->wirasa}}</option>
                            <option value="" disabled>=============================</option>
                                @foreach($wirasa as $rows)
                                    <option value="{{ $rows->id }}" {{ $row->wirasa == $rows->id ? 'selected' : '' }}>
                                        {{ $rows->range }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-rounded">Simpan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endforeach

@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
</script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js">

</script>
<script>
$(document).ready(function() {
    $('#dataTable').DataTable();

});
</script>
@endsection