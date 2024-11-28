@extends('layouts.dosen')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3>Jadwal Kuliah</h3>
                    <form action="{{ route('jadwal.generate') }}" method="POST" class="form-inline">
                        @csrf
                        <div class="form-group mr-2">
                            <input
                                type="text"
                                name="tahun_akademik"
                                class="form-control"
                                placeholder="Tahun Akademik"
                                required>
                        </div>
                        <button type="submit" class="btn btn-primary">Generate Jadwal</button>
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
                                            ({{ $j->pengampu->matakuliah->sks * 50 ?? 0 }} menit)
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        {{ $j->pengampu->matakuliah->nama ?? '-' }}
                                        ({{ $j->pengampu->matakuliah->sks ?? 0 }} SKS)
                                    </td>
                                    <td>{{ $j->pengampu->dosen->nama ?? '-' }}</td>
                                    <td>{{ $j->ruang->nama_ruang ?? '-' }}</td>
                                    <td>{{ $j->kelas->nama_kelas ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data jadwal dosen yang tersedia.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
