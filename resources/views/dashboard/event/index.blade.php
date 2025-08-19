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
                        <button type="button" class="btn btn-primary btn-sm btn-rounded btn-icon-text"
                            data-toggle="modal" data-target="#create">
                            <i class="ti-upload btn-icon-prepend"></i> Create
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table id="dataTable" class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Event</th>
                                    <th>Kuota</th>
                                    <th>Kategori Peserta</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach($data as $row)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>
                                        <strong>{{ $row->nama }}</strong>
                                        @if($row->deskripsi)
                                            <br><small class="text-muted">{{ Str::limit($row->deskripsi, 50) }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $row->kuota }}</td>
                                    <td>
                                        {{ optional($kategoriPeserta->firstWhere('id', $row->kategori_peserta_id))->nama ?? '-' }}
                                    </td>
                                    <td>{{ $row->tanggal }}</td>
                                    <td>
                                        <span class="badge badge-{{ $row->status == 'aktif' ? 'success' : ($row->status == 'selesai' ? 'info' : 'danger') }}">
                                            {{ ucfirst($row->status ?? 'aktif') }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-dark btn-sm btn-rounded btn-icon-prepend"
                                            data-toggle="modal" data-target="#edit{{ $row->id }}">
                                            <i class="ti-reload btn-icon-prepend"></i>Edit
                                        </button>
                                        <a href="{{ route('deleteEvent', ['id' => $row->id]) }}"
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

<!-- Modal Create -->
<div class="modal fade" id="create" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Create Event</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>

      <form action="{{ route('createEvent') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Nama Event <span class="text-danger">*</span></label>
                <input type="text" name="nama" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Kuota Event <span class="text-danger">*</span></label>
                <input type="number" name="kuota" class="form-control" min="1" max="100" required>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Kategori Peserta <span class="text-danger">*</span></label>
                <select name="kategori_peserta_id" class="form-control" required>
                  <option value="" disabled selected>-- Pilih Kategori --</option>
                  @foreach($kategoriPeserta as $kategori)
                    <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Tanggal Event <span class="text-danger">*</span></label>
                <input type="date" name="tanggal" class="form-control" required>
              </div>
            </div>
          </div>
          
          <div class="form-group">
            <label>Lokasi</label>
            <input type="text" name="lokasi" class="form-control" placeholder="Masukkan lokasi event">
          </div>
          
          <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3" placeholder="Masukkan deskripsi event"></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary btn-rounded">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Edit -->
@foreach($data as $row)
<div class="modal fade" id="edit{{ $row->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Event</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>

      <form action="{{ route('updateEvent', ['id' => $row->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Nama Event <span class="text-danger">*</span></label>
                <input type="text" name="nama" class="form-control" value="{{ $row->nama }}" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Kuota Event <span class="text-danger">*</span></label>
                <input type="number" name="kuota" class="form-control" value="{{ $row->kuota }}" min="1" max="100" required>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Kategori Peserta <span class="text-danger">*</span></label>
                <select name="kategori_peserta_id" class="form-control" required>
                  @foreach($kategoriPeserta as $kategori)
                    <option value="{{ $kategori->id }}" {{ $kategori->id == $row->kategori_peserta_id ? 'selected' : '' }}>
                      {{ $kategori->nama }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Tanggal Event <span class="text-danger">*</span></label>
                <input type="date" name="tanggal" class="form-control" value="{{ $row->tanggal }}" required>
              </div>
            </div>
          </div>
          
          <div class="form-group">
            <label>Lokasi</label>
            <input type="text" name="lokasi" class="form-control" value="{{ $row->lokasi ?? '' }}" placeholder="Masukkan lokasi event">
          </div>
          
          <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3" placeholder="Masukkan deskripsi event">{{ $row->deskripsi ?? '' }}</textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary btn-rounded">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach

@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    $('#dataTable').DataTable();
});
</script>
@endsection