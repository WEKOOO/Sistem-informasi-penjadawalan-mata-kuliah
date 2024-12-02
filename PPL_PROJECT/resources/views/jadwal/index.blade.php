@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="float-left">Jadwal Kuliah</h3>
                    <div class="float-right">
                        <form action="{{ route('jadwal.generate') }}" method="POST" class="d-inline">
                            @csrf
                            <input type="text" name="tahun_akademik" placeholder="Tahun Akademik" required class="form-control-sm mr-2" style="display:inline-block; width:auto;">
                            <button type="submit" class="btn btn-primary btn-sm">Generate Jadwal</button>
                        </form>
                    </div>
                </div>

                <div class="card-body">
                    @if($jadwal->isEmpty())
                        <div class="alert alert-info text-center" role="alert">
                            Belum ada jadwal kuliah yang tersedia.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="jadwalTable">
                                <thead>
                                    <tr>
                                        <th>Hari</th>
                                        <th>Jam</th>
                                        <th>Mata Kuliah</th>
                                        <th>Dosen</th>
                                        <th>Ruang</th>
                                        <th>Kelas</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($jadwal as $j)
                                    <tr>
                                        <td>{{ $j->hari->nama_hari }}</td>
                                        <td>
                                            {{ $j->jam->jam_mulai }} - {{ $j->jam->jam_selesai }}
                                            ({{ $j->pengampu->matakuliah->sks * 50 }} menit)
                                        </td>
                                        <td>
                                            {{ $j->pengampu->matakuliah->nama }}
                                            ({{ $j->pengampu->matakuliah->sks }} SKS)
                                        </td>
                                        <td>{{ $j->pengampu->dosen->pluck('nama')->implode(', ') }}</td>
                                        <td>{{ $j->ruang->nama_ruang }}</td>
                                        <td>{{ $j->pengampu->kelas->nama_kelas }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('jadwal.edit', $j->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                                <form action="{{ route('jadwal.destroy', $j->id) }}" method="POST" class="d-inline">
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
                        </div>
                    @endif
                </div>

                @if($jadwal->isNotEmpty())
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Total Jadwal: {{ $jadwal->total() }}</span>
                        <nav aria-label="Page navigation">
                            <ul class="pagination mb-0">
                                {{-- Previous Page Link --}}
                                @if ($jadwal->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">Previous</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $jadwal->previousPageUrl() }}">Previous</a>
                                    </li>
                                @endif

                                {{-- Page Numbers --}}
                                @foreach(range(1, $jadwal->lastPage()) as $page)
                                    @if($page == $jadwal->currentPage())
                                        <li class="page-item active">
                                            <span class="page-link">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $jadwal->url($page) }}">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($jadwal->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $jadwal->nextPageUrl() }}">Next</a>
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
    </div>
</div>

@endsection