@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Jadwal Kuliah</h3>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('jadwalkuliah.update', $jadwalKuliah->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="matakuliah_id" class="form-label">Mata Kuliah</label>
                            <select name="matakuliah_id" id="matakuliah_id" class="form-select" required>
                                <option value="">Pilih Mata Kuliah</option>
                                @foreach($matakuliahs as $matakuliah)
                                    <option value="{{ $matakuliah->id }}" 
                                        {{ old('matakuliah_id', $jadwalKuliah->matakuliah_id) == $matakuliah->id ? 'selected' : '' }}>
                                        {{ $matakuliah->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="kelas_id" class="form-label">Kelas</label>
                            <select name="kelas_id" id="kelas_id" class="form-select" required>
                                <option value="">Pilih Kelas</option>
                                @foreach($kelas as $k)
                                    <option value="{{ $k->id }}" 
                                        {{ old('kelas_id', $jadwalKuliah->kelas_id) == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="dosen_id" class="form-label">Dosen</label>
                            <select name="dosen_id" id="dosen_id" class="form-select" required>
                                <option value="">Pilih Dosen</option>
                                @foreach($dosens as $dosen)
                                    <option value="{{ $dosen->id }}" 
                                        {{ old('dosen_id', $jadwalKuliah->dosen_id) == $dosen->id ? 'selected' : '' }}>
                                        {{ $dosen->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="hari_id" class="form-label">Hari</label>
                                    <select name="hari_id" id="hari_id" class="form-select" required>
                                        <option value="">Pilih Hari</option>
                                        @foreach($haris as $hari)
                                            <option value="{{ $hari->id }}" 
                                                {{ old('hari_id', $jadwalKuliah->hari_id) == $hari->id ? 'selected' : '' }}>
                                                {{ $hari->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="jam_id" class="form-label">Jam</label>
                                    <select name="jam_id" id="jam_id" class="form-select" required>
                                        <option value="">Pilih Jam</option>
                                        @foreach($jams as $jam)
                                            <option value="{{ $jam->id }}" 
                                                {{ old('jam_id', $jadwalKuliah->jam_id) == $jam->id ? 'selected' : '' }}>
                                                {{ $jam->range }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="ruang_id" class="form-label">Ruang</label>
                                    <select name="ruang_id" id="ruang_id" class="form-select" required>
                                        <option value="">Pilih Ruang</option>
                                        @foreach($ruangs as $ruang)
                                            <option value="{{ $ruang->id }}" 
                                                {{ old('ruang_id', $jadwalKuliah->ruang_id) == $ruang->id ? 'selected' : '' }}>
                                                {{ $ruang->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('jadwalkuliah.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Fungsi untuk menampilkan konfirmasi sebelum meninggalkan halaman
    let formChanged = false;
    
    // Menandai form telah diubah
    document.querySelectorAll('form select').forEach(select => {
        select.addEventListener('change', () => {
            formChanged = true;
        });
    });

    // Konfirmasi sebelum meninggalkan halaman
    window.addEventListener('beforeunload', (event) => {
        if (formChanged) {
            event.preventDefault();
            event.returnValue = 'Anda memiliki perubahan yang belum disimpan. Yakin ingin meninggalkan halaman?';
        }
    });

    // Reset penanda perubahan setelah form di-submit
    document.querySelector('form').addEventListener('submit', () => {
        formChanged = false;
    });
</script>
@endpush
@section('styles')
<style>
    /* Styling untuk form edit */
    .card {
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }
    
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }
    
    .card-title {
        margin-bottom: 0;
        color: #333;
    }
    
    .form-label {
        font-weight: 500;
        color: #555;
    }
    
    .form-select:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    
    .btn {
        padding: 0.5rem 1rem;
        border-radius: 0.25rem;
        font-weight: 500;
    }
    
    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }
    
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }
    
    .alert {
        border-radius: 0.25rem;
        padding: 1rem;
        margin-bottom: 1rem;
    }
    
    .alert-danger {
        background-color: #f8d7da;
        border-color: #f5c6cb;
        color: #721c24;
    }
    
    .gap-2 {
        gap: 0.5rem;
    }
</style>
@endsection
@endsection