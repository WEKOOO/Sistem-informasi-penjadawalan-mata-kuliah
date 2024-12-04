@extends('layouts.dosen')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3>Jadwal Dosen</h3>
                    <form action="{{ route('jadwaldosen.index') }}" method="GET" class="d-flex">
                        <input type="text" name="search" class="form-control" placeholder="Pencarian..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary ms-2">Search</button>
                    </form>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th class="fw-bold" style="color: black; background-color: #d9edfc;">Hari</th>
                                    <th class="fw-bold" style="color: black; background-color: #d9edfc;">Jam</th>
                                    <th class="fw-bold" style="color: black; background-color: #d9edfc;">Mata Kuliah</th>
                                    <th class="fw-bold" style="color: black; background-color: #d9edfc;">Dosen</th>
                                    <th class="fw-bold" style="color: black; background-color: #d9edfc;">Ruang</th>
                                    <th class="fw-bold" style="color: black; background-color: #d9edfc;">Kelas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($jadwalKuliah as $j)
                                <tr>
                                    <td>{{ $j->hari->nama_hari ?? '-' }}</td>
                                    <td>
                                        @if ($j->jam)
                                            {{ $j->jam->jam_mulai ?? '-' }} - {{ $j->jam->jam_selesai ?? '-' }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        {{ $j->pengampu->matakuliah->nama ?? '-' }}
                                        ({{ $j->pengampu->matakuliah->sks }} SKS)
                                    </td>
                                    <td>
                                        @foreach ($j->pengampu->dosen as $dosen)
                                            {{ $dosen->nama }}<br>
                                        @endforeach
                                    </td>
                                    <td>{{ $j->ruang->nama_ruang ?? '-' }}</td>
                                    <td>{{ $j->pengampu->kelas->nama_kelas ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data jadwal dosen yang tersedia.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            Menampilkan {{ $jadwalKuliah->firstItem() }} - {{ $jadwalKuliah->lastItem() }} 
                            dari {{ $jadwalKuliah->total() }} data
                        </div>
                        <div>
                            <ul class="pagination">
                                {{-- Previous Page Link --}}
                                @if ($jadwalKuliah->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">Previous</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $jadwalKuliah->previousPageUrl() }}">Previous</a>
                                    </li>
                                @endif

                                {{-- Nomor Halaman --}}
                                @for ($i = 1; $i <= $jadwalKuliah->lastPage(); $i++)
                                    <li class="page-item {{ $jadwalKuliah->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $jadwalKuliah->appends(['search' => $search])->url($i) }}">
                                            {{ $i }}
                                        </a>
                                    </li>
                                @endfor

                                {{-- Next Page Link --}}
                                @if ($jadwalKuliah->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $jadwalKuliah->nextPageUrl() }}">Next</a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link">Next</span>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection