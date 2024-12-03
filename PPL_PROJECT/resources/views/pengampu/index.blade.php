@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row g-4">
        <!-- Judul Tabel -->
        <div class="col-12">
            <h4 class="title-with-underline">Tabel Data Pengampu</h4>
        </div>
        
        <!-- Tombol Tambah Data dan Search -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <button class="btn btn-primary" onclick="window.location.href='{{ route('pengampu.create') }}'">
                + Tambah Data
            </button>

            <form action="{{ route('pengampu.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control" placeholder="Pencarian..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary ms-2">Cari</button>
            </form>
        </div>
        
        <!-- Tabel Data -->
        <div class="col-12">
            @if($pengampus->isEmpty())
                <div class="alert alert-info text-center">
                    Tidak ada data pengampu yang tersedia.
                </div>
            @else
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Dosen</th>
                            <th>Mata Kuliah</th>
                            <th>Kelas</th>
                            <th>Tahun Akademik</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pengampus as $index => $pengampu)
                        <tr>
                            <td>{{ $index + 1 + ($pengampus->currentPage() - 1) * $pengampus->perPage() }}</td>
                            <td>
                                @foreach($pengampu->dosen as $dosen)
                                    {{ $dosen->nama }}{{ !$loop->last ? ', ' : '' }}
                                @endforeach
                            </td>
                            <td>{{ $pengampu->matakuliah->nama }}</td>
                            <td>{{ $pengampu->Kelas->nama_kelas }}</td>
                            <td>{{ $pengampu->tahun_akademik }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('pengampu.edit', $pengampu->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('pengampu.destroy', $pengampu->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin?')">
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
        @if($pengampus->isNotEmpty())
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Menampilkan {{ $pengampus->firstItem() }} - {{ $pengampus->lastItem() }} dari {{ $pengampus->total() }} data
                </div>
                <nav aria-label="Navigasi Halaman">
                    <ul class="pagination mb-0">
                        {{-- Previous Page Link --}}
                        @if ($pengampus->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">Previous</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $pengampus->previousPageUrl() }}">Previous</a>
                            </li>
                        @endif

                        {{-- Page Numbers --}}
                        @foreach(range(1, $pengampus->lastPage()) as $page)
                            @if($page == $pengampus->currentPage())
                                <li class="page-item active">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $pengampus->url($page) }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($pengampus->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $pengampus->nextPageUrl() }}">Next</a>
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