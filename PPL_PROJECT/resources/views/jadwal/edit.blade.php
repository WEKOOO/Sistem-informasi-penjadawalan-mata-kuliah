@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Jadwal Kuliah</h1>
    <form action="{{ route('jadwal.update', $jadwal->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="pengampu_id">Pengampu</label>
            <select name="pengampu_id" id="pengampu_id" class="form-control" required>
                @foreach($pengampu as $item)
                    <option value="{{ $item->id }}" {{ $item->id == $jadwal->pengampu_id ? 'selected' : '' }}>
                        {{ $item->matakuliah->nama }} - {{ $item->dosen->pluck('nama')->implode(', ') }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="ruang_id">Ruang</label>
            <select name="ruang_id" id="ruang_id" class="form-control" required>
                @foreach($ruang as $item)
                    <option value="{{ $item->id }}" {{ $item->id == $jadwal->ruang_id ? 'selected' : '' }}>
                        {{ $item->nama_ruang }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="hari_id">Hari</label>
            <select name="hari_id" id="hari_id" class="form-control" required>
                @foreach($hari as $item)
                    <option value="{{ $item->id }}" {{ $item->id == $jadwal->hari_id ? 'selected' : '' }}>
                        {{ $item->nama_hari }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="jam_id">Jam</label>
            <select name="jam_id" id="jam_id" class="form-control" required>
 @foreach($jam as $item)
                    <option value="{{ $item->id }}" {{ $item->id == $jadwal->jam_id ? 'selected' : '' }}>
                        {{ $item->jam_mulai }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="kelas_id">Kelas</label>
            <select name="kelas_id" id="kelas_id" class="form-control" required>
                @foreach($kelas as $item)
                    <option value="{{ $item->id }}" {{ $item->id == $jadwal->kelas_id ? 'selected' : '' }}>
                        {{ $item->nama_kelas }}
                    </option>
                @endforeach
            </select>
        </div>

        <input type="hidden" name="tahun_akademik" value="{{ $jadwal->tahun_akademik }}">

        <button type="submit" class="btn btn-primary">Update Jadwal</button>
    </form>
</div>
@endsection