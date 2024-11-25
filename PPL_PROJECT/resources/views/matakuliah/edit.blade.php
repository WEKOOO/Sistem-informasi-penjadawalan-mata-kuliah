<!-- resources/views/mata-kuliah/edit.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Data Mata Kuliah</h5>
                    <a href="{{ route('matakuliah.index') }}" class="btn btn-secondary">
                        Kembali
                    </a>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('matakuliah.update', $mataKuliah->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="kode_mk" class="form-label">Kode Mata Kuliah</label>
                            <input type="text" class="form-control @error('kode_mk') is-invalid @enderror" 
                                   id="kode_mk" name="kode_mk" 
                                   value="{{ old('kode_mk', $mataKuliah->kode_mk) }}" 
                                   placeholder="Masukkan kode mata kuliah">
                            @error('kode_mk')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Mata Kuliah</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                   id="nama" name="nama" 
                                   value="{{ old('nama', $mataKuliah->nama) }}" 
                                   placeholder="Masukkan nama mata kuliah">
                            @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="sks" class="form-label">SKS</label>
                                <input type="number" class="form-control @error('sks') is-invalid @enderror" 
                                       id="sks" name="sks" 
                                       value="{{ old('sks', $mataKuliah->sks) }}" 
                                       min="1" placeholder="Masukkan jumlah SKS">
                                @error('sks')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="semester" class="form-label">Semester</label>
                                <select class="form-select @error('semester') is-invalid @enderror" 
                                        id="semester" name="semester">
                                    <option value="">Pilih Semester</option>
                                    @for($i = 1; $i <= 8; $i++)
                                        <option value="{{ $i }}" 
                                            {{ old('semester', $mataKuliah->semester) == $i ? 'selected' : '' }}>
                                            Semester {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                                @error('semester')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="prodi_id" class="form-label">Program Studi</label>
                            <select class="form-select @error('prodi_id') is-invalid @enderror" 
                                    id="prodi_id" name="prodi_id">
                                <option value="">Pilih Program Studi</option>
                                @foreach($prodi as $p)
                                    <option value="{{ $p->id }}" 
                                        {{ old('prodi_id', $mataKuliah->prodi_id) == $p->id ? 'selected' : '' }}>
                                        {{ $p->nama_prodi }}
                                    </option>
                                @endforeach
                            </select>
                            @error('prodi_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                Update Data
                            </button>
                        </div>
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
        const form = document.querySelector('form');
        
        form.addEventListener('submit', function(e) {
            let isValid = true;
            
            // Validasi Kode MK
            const kodeMK = document.getElementById('kode_mk');
            if (!kodeMK.value.trim()) {
                setInvalid(kodeMK, 'Kode mata kuliah wajib diisi');
                isValid = false;
            }
            
            // Validasi Nama
            const nama = document.getElementById('nama');
            if (!nama.value.trim()) {
                setInvalid(nama, 'Nama mata kuliah wajib diisi');
                isValid = false;
            }
            
            // Validasi SKS
            const sks = document.getElementById('sks');
            if (!sks.value || sks.value < 1) {
                setInvalid(sks, 'SKS minimal 1');
                isValid = false;
            }
            
            // Validasi Semester
            const semester = document.getElementById('semester');
            if (!semester.value) {
                setInvalid(semester, 'Semester wajib dipilih');
                isValid = false;
            }
            
            // Validasi Program Studi
            const prodi = document.getElementById('prodi_id');
            if (!prodi.value) {
                setInvalid(prodi, 'Program studi wajib dipilih');
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault();
            }
        });
        
        function setInvalid(element, message) {
            element.classList.add('is-invalid');
            const feedback = element.nextElementSibling;
            if (feedback && feedback.classList.contains('invalid-feedback')) {
                feedback.textContent = message;
            }
        }
        
        // Reset validation on input
        const inputs = form.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                this.classList.remove('is-invalid');
            });
        });
    });
</script>
@endpush