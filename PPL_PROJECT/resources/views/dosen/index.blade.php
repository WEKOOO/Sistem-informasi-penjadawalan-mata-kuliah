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
        <div class="d-flex justify-content-between align-items-center mb-3">
            <button class="btn btn-primary" onclick="window.location.href='{{ route('dosen.create') }}'">
                + Tambah Data
            </button>

            <form action="{{ route('dosen.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control" placeholder="Pencarian..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary ms-2">Cari</button>
            </form>
        </div>

        <!-- Tabel Data -->
        <div class="col-12">
            @if($dosen->isEmpty())
                <div class="alert alert-info text-center">
                    Tidak ada data dosen yang tersedia.
                </div>
            @else
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="fw-bold" style="color: black; background-color: #d9edfc;">No</th>
                            <th class="fw-bold" style="color: black; background-color: #d9edfc;">Nama</th>
                            <th class="fw-bold" style="color: black; background-color: #d9edfc;">NIDN</th>
                            <th class="fw-bold" style="color: black; background-color: #d9edfc;">Email</th>
                            <th class="fw-bold" style="color: black; background-color: #d9edfc;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dosen as $index => $d)
                        <tr>
                            <td>{{ $index + 1 + ($dosen->currentPage() - 1) * $dosen->perPage() }}</td>
                            <td>{{ $d->nama }}</td>
                            <td>{{ $d->nidn }}</td>
                            <td>{{ $d->email }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('dosen.edit', $d->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('dosen.destroy', $d->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <!-- Pagination -->
        @if($dosen->isNotEmpty())
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Menampilkan {{ $dosen->firstItem() }} - {{ $dosen->lastItem() }} dari {{ $dosen->total() }} data
                </div>
                <nav aria-label="Navigasi Halaman">
                    <ul class="pagination mb-0">
                        {{-- Previous Page Link --}}
                        @if ($dosen->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">Previous</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $dosen->previousPageUrl() }}">Previous</a>
                            </li>
                        @endif

                        {{-- Page Numbers --}}
                        @foreach(range(1, $dosen->lastPage()) as $page)
                            @if($page == $dosen->currentPage())
                                <li class="page-item active">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $dosen->url($page) }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($dosen->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $dosen->nextPageUrl() }}">Next</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">Next</span>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
