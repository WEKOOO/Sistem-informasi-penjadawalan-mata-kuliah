@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row g-4">
        <!-- Judul Tabel -->
        <div class="col-12">
            <h4 class="title">Data Ruangan</h4>
        </div>

        <!-- Tombol Tambah Data dan Search -->
        <div class="d-flex justify-content-between align-items-center">
            <button class="btn btn-primary" onclick="window.location.href='{{ route('ruang.create') }}'">
                + Tambah Data
            </button>

            <form action="{{ route('ruang.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control" placeholder="Pencarian..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary ms-2">Cari</button>
            </form>
        </div>

        <!-- Tabel Data -->
        <div class="col-12">
            <table class="table table-bordered table-striped"> <!-- Tambahkan kelas table-striped -->
                <thead>
                    <tr>
                        <th class="fw-bold" style="color: black; background-color: #d9edfc;">No</th>
                        <th class="fw-bold" style="color: black; background-color: #d9edfc;">Nama Ruang</th>
                        <th class="fw-bold" style="color: black; background-color: #d9edfc;">Kapasitas</th>
                        <th class="fw-bold" style="color: black; background-color: #d9edfc;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ruang as $index => $d)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $d->nama_ruang }}</td>
                        <td>{{ $d->kapasitas }}</td>
                        <td>
                            <a href="{{ route('ruang.edit', $d->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('ruang.destroy', $d->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
