@extends('dashboard.master')
@section('title', 'Event - Sistem Pendukung Keputusan Penilaian Siswa Berprestasi')

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
                    <h4 class="card-title">{{ __('Data Event') }}</h4>
                    @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                    @endif

                    <div class="text-right mb-3">
                        <button type="button"
                                class="btn btn-primary btn-sm btn-rounded btn-icon-text"
                                data-toggle="modal"
                                data-target="#create">
                            <i class="ti-upload btn-icon-prepend"></i> Create
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table id="dataTable" class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Event</th>
                                    <th>Kuota Event</th>
                                    <th>Tanggal Event</th>
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
                                        <td>{{$row->kuota}}</td>
                                        <td>{{$row->tanggal}}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-dark btn-sm btn-rounded btn-icon-prepend"
                                                data-toggle="modal" data-target="#edit{{$row->id}}">
                                                <i class="ti-reload btn-icon-prepend"></i>Edit</button>
                                            <a href="{{route('deleteEvent', ['id'=>$row->id])}}" 
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
<div class="modal fade" id="create" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Create Event</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <form action="{{ route('createEvent') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label>Nama Event</label>
            <input type="text" name="nama" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Kuota Event</label>
            <input type="number" name="kuota" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Tanggal Event</label>
            <input type="date" name="tanggal" class="form-control" required>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary btn-rounded">Simpan</button>
        </div>
      </form>

    </div>
  </div>
</div>

<!-- Edit -->
@foreach($data as $row)
    <div class="modal fade" id="edit{{ $row->id }}" tabindex="-1"
       aria-labelledby="modalEditLabel{{ $row->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel{{ $row->id }}">Edit Event</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('updateEvent', ['id' => $row->id]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Event</label>
                            <input type="text" name="nama" class="form-control"
                                required
                                value="{{ $row->nama }}">
                        </div>

                        <div class="form-group">
                            <label>Kuota Event</label>
                            <input type="number" name="kuota" class="form-control"
                                required
                                value="{{ $row->kuota }}">
                        </div>

                        <div class="form-group">
                            <label>Tanggal Event</label>
                            <input type="date" name="tanggal" class="form-control"
                                required
                                value="{{ $row->tanggal }}">
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