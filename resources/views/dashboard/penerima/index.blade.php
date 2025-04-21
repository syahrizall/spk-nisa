@extends('dashboard.master')
@section('title', 'Data Penerima - Sistem Pendukung Keputusan Kelayakan Penerimaan Bantuan Raskin Di Kelurahan Maleber')

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
                    <h4 class="card-title">{{ __('Data Calon Penerima') }}</h4>
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
                                    <th>Alamat</th>
                                    <th>No KK</th>
                                    <th>NIK</th>
                                    <th>Nomor Telepon</th>
                                    <th>Tingkat Pendapatan</th>
                                    <th>Jumlah Anggota Keluarga</th>
                                    <th>Status Pekerjaan</th>
                                    <th>Kondisi Rumah</th>
                                    <th>Kondisi Kesehatan</th>
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
                                        <td>{{$row->nama}}</td>
                                        <td>{{$row->alamat}}</td>
                                        <td>{{$row->no_kk}}</td>
                                        <td>{{$row->nik}}</td>
                                        <td>{{$row->no_telpon}}</td>
                                        <td>{{$row->tingkat_pendapatan}}</td>
                                        <td>{{$row->jumlah_anggota_keluarga}}</td>
                                        <td>{{$row->status_pekerjaan}}</td>
                                        <td>{{$row->kondisi_rumah}}</td>
                                        <td>{{$row->kondisi_kesehatan}}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-dark btn-sm btn-rounded btn-icon-prepend"
                                                data-toggle="modal" data-target="#edit{{$row->id}}">
                                                <i class="ti-reload btn-icon-prepend"></i>Edit</button>
                                            <a href="{{route('deletePenerima', ['id'=>$row->id])}}" 
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
                <h5 class="modal-title" id="exampleModalLongTitle">Create Data Penerima</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('createPenerima')}}" method="POST">
                <div class="modal-body">
                    @csrf
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control" required style="text-transform: capitalize;">
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" name="alamat" class="form-control" required style="text-transform: capitalize;">
                    </div>
                    <div class="mb-3">
                        <label for="no_kk" class="form-label">Nomor Kartu Keluarga</label>
                        <input type="number" name="no_kk" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="nik" class="form-label">Kartu Identitas NIK / Nomor KTP</label>
                        <input type="number" name="nik" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="no_telpon" class="form-label">Nomor Telpon</label>
                        <input type="number" name="no_telpon" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="tingkat_pendapatan" class="form-label">Tingkat Pendapatan</label>
                        <select type="text" name="tingkat_pendapatan" class="form-control">
                            @foreach($tingkat_pendapatan as $row)
                                <option value="{{$row->id}}">{{$row->range}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah_anggota_keluarga" class="form-label">Jumlah Anggota Keluarga</label>
                        <select type="text" name="jumlah_anggota_keluarga" class="form-control">
                            @foreach($jumlah_anggota_keluarga as $row)
                                <option value="{{$row->id}}">{{$row->range}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status_pekerjaan" class="form-label">Status Pekerjaan</label>
                        <select type="text" name="status_pekerjaan" class="form-control">
                            @foreach($status_pekerjaan as $row)
                                <option value="{{$row->id}}">{{$row->range}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="kondisi_rumah" class="form-label">Kondisi Rumah</label>
                        <select type="text" name="kondisi_rumah" class="form-control">
                            @foreach($kondisi_rumah as $row)
                                <option value="{{$row->id}}">{{$row->range}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="kondisi_kesehatan" class="form-label">Kondisi Kesehatan</label>
                        <select type="text" name="kondisi_kesehatan" class="form-control">
                            @foreach($kondisi_kesehatan as $row)
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
                    <h5 class="modal-title" id="exampleModalLongTitle{{$row->id}}">Edit Data Penerima</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('updatePenerima', ['id'=>$row->id])}}" method="POST">
                    <div class="modal-body">
                        @csrf
                        @method('put')
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control" required 
                            style="text-transform: capitalize;" value="{{$row->nama}}">
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" name="alamat" class="form-control" required 
                            style="text-transform: capitalize;" value="{{$row->alamat}}">
                        </div>
                        <div class="mb-3">
                            <label for="no_kk" class="form-label">Nomor Kartu Keluarga</label>
                            <input type="number" name="no_kk" class="form-control" required
                            value="{{$row->no_kk}}">
                        </div>
                        <div class="mb-3">
                            <label for="nik" class="form-label">Kartu Identitas</label>
                            <input type="number" name="nik" class="form-control" required
                            value="{{$row->nik}}">
                        </div>
                        <div class="mb-3">
                            <label for="no_telpon" class="form-label">Nomor Telepon</label>
                            <input type="number" name="no_telpon" class="form-control" required
                            value="{{$row->no_telpon}}">
                        </div>
                        <div class="mb-3">
                            <label for="tingkat_pendapatan" class="form-label">Tingkat Pendapatan</label>
                            <select type="text" name="tingkat_pendapatan" class="form-control">
                                <option value="{{$row->tingkat_pendapatan_id}}">{{$row->tingkat_pendapatan}}</option>
                                <option value="" disabled>=============================</option>
                                @foreach($tingkat_pendapatan as $rows)
                                    <option value="{{ $rows->id }}">
                                        {{$rows->range}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jumlah_anggota_keluarga" class="form-label">Jumlah Anggota Keluarga</label>
                            <select type="text" name="jumlah_anggota_keluarga" class="form-control">
                            <option value="{{$row->jumlah_anggota_keluarga_id}}">{{$row->jumlah_anggota_keluarga}}</option>
                            <option value="" disabled>=============================</option>
                                @foreach($jumlah_anggota_keluarga as $rows)
                                    <option value="{{$rows->id}}">
                                        {{$rows->range}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="status_pekerjaan" class="form-label">Status Pekerjaan</label>
                            <select type="text" name="status_pekerjaan" class="form-control">
                            <option value="{{$row->status_pekerjaan_id}}">{{$row->status_pekerjaan}}</option>
                            <option value="" disabled>=============================</option>
                                @foreach($status_pekerjaan as $rows)
                                    <option value="{{$rows->id}}">
                                        {{$rows->range}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="kondisi_rumah" class="form-label">Kondisi Rumah</label>
                            <select type="text" name="kondisi_rumah" class="form-control">
                            <option value="{{$row->kondisi_rumah_id}}">{{$row->kondisi_rumah}}</option>
                            <option value="" disabled>=============================</option>
                                @foreach($kondisi_rumah as $rows)
                                    <option value="{{$rows->id}}">
                                        {{$rows->range}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="kondisi_kesehatan" class="form-label">Kondisi Kesehatan</label>
                            <select type="text" name="kondisi_kesehatan" class="form-control">
                            <option value="{{$row->kondisi_kesehatan_id}}">{{$row->kondisi_kesehatan}}</option>
                            <option value="" disabled>=============================</option>
                                @foreach($kondisi_kesehatan as $rows)
                                    <option value="{{$rows->id}}">
                                        {{$rows->range}}</option>
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