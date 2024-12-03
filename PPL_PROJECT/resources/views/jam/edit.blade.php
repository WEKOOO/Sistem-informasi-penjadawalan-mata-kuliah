@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Jam</h1>
    <form action="{{ route('jam.update', $jam->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="jam_mulai">Jam Mulai</label>
            <input type="time" name="jam_mulai" id="jam_mulai" class="form-control @error('jam_mulai') is-invalid @enderror" value="{{ old('jam_mulai', $jam->jam_mulai) }}">
            @error('jam_mulai')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="jam_selesai">Jam Selesai</label>
            <input type="time" name="jam_selesai" id="jam_selesai" class="form-control @error('jam_selesai') is-invalid @enderror" value="{{ old('jam_selesai', $jam->jam_selesai) }}">
            @error('jam_selesai')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="waktu_shalat">Waktu Shalat</label>
            <input type="checkbox" name="waktu_shalat" id="waktu_shalat" value="1" {{ old('waktu_shalat', $jam->waktu_shalat) ? 'checked' : '' }}>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('jam.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
