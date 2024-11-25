@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">Data Jam Perkuliahan</h3>
                        <a href="{{ route('jam.create') }}" class="btn btn-primary">Tambah Jam</a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Jam Mulai</th>
                                    <th>Jam Selesai</th>
                                    <th>SKS</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($jamList as $index => $jam)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $jam->jam_mulai }}</td>
                                        <td>{{ $jam->jam_selesai }}</td>
                                        <td>{{ $jam->matakuliah ? $jam->matakuliah->sks : 'N/A' }}</td> <!-- Menampilkan SKS dari Matakuliah -->
                                        <td>
                                            @if($jam->waktu_shalat)
                                                <span class="badge bg-info">Waktu Shalat</span>
                                            @else
                                                <span class="badge bg-success">Jam Kuliah</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('jam.edit', $jam->id) }}" 
                                                   class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('jam.destroy', $jam->id) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data</td>
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