@extends('layouts.dosen')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3>Jadwal Dosen</h3>
                    <form action="{{ route('jadwaldosen.index') }}" method="GET" class="form-inline">
                        <input type="text" name="search" class="form-control mr-2" placeholder="Cari Dosen/Mata Kuliah" value="{{ $search ?? '' }}">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </form>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>Hari</th>
                                    <th>Jam</th>
                                    <th>Mata Kuliah</th>
                                    <th>Dosen</th>
                                    <th>Ruang</th>
                                    <th>Kelas</th>
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
                                    <td>{{ $j->pengampu->matakuliah->nama ?? '-' }}</td>
                                    <td>{{ $j->pengampu->dosen->pluck('nama')->implode(', ') }}</td>
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
                            {{ $jadwalKuliah->appends(['search' => $search])->links() }}
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
