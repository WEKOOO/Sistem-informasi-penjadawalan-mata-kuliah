@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row g-4">
        <!-- Judul Tabel -->
        <div class="col-12">
            <h4 class="title-with-underline">Tabel Data Mata Kuliah</h4>
        </div>
        
        <!-- Tombol Tambah Data dan Search -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <button class="btn btn-primary" onclick="window.location.href='{{ route('matakuliah.create') }}'">
                + Tambah Data
            </button>

            <form action="{{ route('matakuliah.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control" placeholder="Pencarian..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary ms-2">Cari</button>
            </form>
        </div>
        
        <!-- Tabel Data -->
        <div class="col-12">
            @if($mataKuliah->isEmpty())
                <div class="alert alert-info text-center">
                    Tidak ada data mata kuliah yang tersedia.
                </div>
            @else
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode MK</th>
                            <th>Nama</th>
                            <th>SKS</th>
                            <th>Semester</th>
                            <th>Prodi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mataKuliah as $index => $mk)
                        <tr>
                            <td>{{ $index + 1 + ($mataKuliah->currentPage() - 1) * $mataKuliah->perPage() }}</td>
                            <td>{{ $mk->kode_mk }}</td>
                            <td>{{ $mk->nama }}</td>
                            <td>{{ $mk->sks }}</td>
                            <td>{{ $mk->semester }}</td>
                            <td>{{ $mk->prodi->nama_prodi }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('matakuliah.edit', $mk->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('matakuliah.destroy', $mk->id) }}" method="POST" class="d-inline">
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
        @if($mataKuliah->isNotEmpty())
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Menampilkan {{ $mataKuliah->firstItem() }} - {{ $mataKuliah->lastItem() }} dari {{ $mataKuliah->total() }} data
                </div>
                <nav aria-label="Navigasi Halaman">
                    <ul class="pagination mb-0">
                        {{-- Previous Page Link --}}
                        @if ($mataKuliah->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">Previous</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $mataKuliah->previousPageUrl() }}">Previous</a>
                            </li>
                        @endif

                        {{-- Page Numbers --}}
                        @foreach(range(1, $mataKuliah->lastPage()) as $page)
                            @if($page == $mataKuliah->currentPage())
                                <li class="page-item active">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $mataKuliah->url($page) }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($mataKuliah->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $mataKuliah->nextPageUrl() }}">Next</a>
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