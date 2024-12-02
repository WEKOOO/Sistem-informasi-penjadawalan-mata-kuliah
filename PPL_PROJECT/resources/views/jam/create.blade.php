@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Tambah Jam Perkuliahan</h3>
                    <a href="{{ route('jam.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('jam.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="jam_mulai" class="form-label">Jam Mulai</label>
                            <input type="time" 
                                   class="form-control @error('jam_mulai') is-invalid @enderror" 
                                   id="jam_mulai" 
                                   name="jam_mulai" 
                                   value="{{ old('jam_mulai') }}" 
                                   required>
                            @error('jam_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="matakuliah_id" class="form-label">Matakuliah</label>
                            <select class="form-control @error('matakuliah_id') is-invalid @enderror" 
                                    id="matakuliah_id" 
                                    name="matakuliah_id" 
                                    required>
                                <option value="">Pilih Matakuliah</option>
                                @foreach ($matakuliahList as $matakuliah)
                                    <option value="{{ $matakuliah->id }}">{{ $matakuliah->nama_matakuliah }} ({{ $matakuliah->sks }} SKS)</option>
                                @endforeach
                            </select>
                            @error('matakuliah_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" 
                                       class="form-check-input @error('waktu_shalat') is-invalid @enderror" 
                                       id="waktu_shalat" 
                                       name="waktu_shalat" 
                                       value="1">
                                <label class="form-check-label" for="waktu_shalat">
                                    Waktu Shalat
                                </label>
                                @error('waktu_shalat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3" id="jam_selesai_container" style="display: none;">
                            <label for="jam_selesai" class="form-label">Jam Selesai</label>
                            <input type="time" 
                                   class="form-control @error('jam_selesai') is-invalid @enderror" 
                                   id="jam_selesai" 
                                   name="jam_selesai" 
                                   value="{{ old('jam_selesai') }}">
                            @error('jam_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const waktuShalatCheckbox = document.getElementById('waktu_shalat');
        const jamSelesaiContainer = document.getElementById('jam_selesai_container');
        const matakuliahSelect = document.getElementById('matakuliah_id');

        function toggleJamSelesai() {
            if (waktuShalatCheckbox.checked) {
                jamSelesaiContainer.style.display = 'block';
                matakuliahSelect.value = ''; // Reset matakuliah jika waktu shalat dipilih
                matakuliahSelect.disabled = true; // Nonaktifkan pemilihan matakuliah
            } else {
                jamSelesaiContainer.style.display = 'none';
                matakuliahSelect.disabled = false; // Aktifkan kembali pemilihan matakuliah
            }
        }

        waktuShalatCheckbox.addEventListener('change', toggleJamSelesai);
        toggleJamSelesai();
    });
</script>
@endpush