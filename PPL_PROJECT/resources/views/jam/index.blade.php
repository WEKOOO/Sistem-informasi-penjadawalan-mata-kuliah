@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Jam</h1>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <a href="{{ route('jam.create') }}" class="btn btn-primary mb-3">Tambah Jam</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Jam Mulai</th>
                <th>Jam Selesai</th>
                <th>Durasi (Menit)</th>
                <th>Waktu Shalat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jamList as $jam)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $jam->jam_mulai }}</td>
                    <td>{{ $jam->jam_selesai }}</td>
                    <td>{{ $jam->durasi }}</td>
                    <td>{{ $jam->waktu_shalat ? 'Ya' : 'Tidak' }}</td>
                    <td>
                        <a href="{{ route('jam.edit', $jam->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('jam.destroy', $jam->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus jam ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data jam tersedia</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
