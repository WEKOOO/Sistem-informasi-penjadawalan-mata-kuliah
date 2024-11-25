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
                            <input type="text" name="tahun_akademik" placeholder="Tahun Akademik" required>
                            <button type="submit" class="btn btn-primary">Generate Jadwal</button>
                        </form>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
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
                                    <td>{{ $j->pengampu->dosen->nama }}</td>
                                    <td>{{ $j->ruang->nama_ruang }}</td>
                                    <td>{{ $j->kelas->nama_kelas }}</td>
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
@endsection