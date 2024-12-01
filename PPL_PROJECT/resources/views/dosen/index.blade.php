@extends('layouts.app')

@section('content')
<style>
    /* Menghilangkan transisi slider */
    .carousel-inner {
        transition: none !important;
    }
</style>

<div class="container-fluid">
    <div class="row g-4">
        <!-- Judul Tabel -->
        <div class="col-12">
            <h4 class="title-with-underline">Tabel Data Dosen</h4>
        </div>

        <!-- Tombol Tambah Data dan Search -->
        <div class="d-flex justify-content-between align-items-center">
            <button class="btn btn-primary" onclick="window.location.href='{{ route('dosen.create') }}'">
                + Tambah Data
            </button>

            <form action="{{ route('dosen.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control" placeholder="Pencarian..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary ms-2">Cari</button>
            </form>
        </div>

        <!-- Slider Tabel -->
        <div class="col-12">
            <div id="tableSlider" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach($dosen->chunk(10) as $index => $chunk)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>NIDN</th>
                                    <th>Email</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($chunk as $i => $d)
                                <tr>
                                    <td>{{ $loop->iteration + $index * 10 }}</td>
                                    <td>{{ $d->nama }}</td>
                                    <td>{{ $d->nidn }}</td>
                                    <td>{{ $d->email }}</td>
                                    <td>
                                        <a href="{{ route('dosen.edit', $d->id) }}" class="btn btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('dosen.destroy', $d->id) }}" method="POST" class="d-inline">
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
                    @endforeach
                </div>
                <!-- Navigasi Slider -->
                <div class="d-flex justify-content-center mt-3">
                    <button class="btn btn-secondary me-2" type="button" data-bs-target="#tableSlider" data-bs-slide="prev">
                        Sebelumnya
                    </button>
                    <button class="btn btn-secondary" type="button" data-bs-target="#tableSlider" data-bs-slide="next">
                        Berikutnya
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
