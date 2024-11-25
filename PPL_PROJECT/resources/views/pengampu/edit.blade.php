<!-- resources/views/pengampu/edit.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Data Pengampu</h5>
                    <a href="{{ route('pengampu.index') }}" class="btn btn-secondary">
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

                    <form action="{{ route('pengampu.update', $pengampu->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="dosen_id" class="form-label">Dosen</label>
                            <select class="form-select @error('dosen_id') is-invalid @enderror" 
                                    id="dosen_id" name="dosen_id">
                                <option value="">Pilih Dosen</option>
                                @foreach($dosens as $dosen)
                                    <option value="{{ $dosen->id }}" 
                                        {{ old('dosen_id', $pengampu->dosen_id) == $dosen->id ? 'selected' : '' }}>
                                        {{ $dosen->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('dosen_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="matakuliah_id" class="form-label">Mata Kuliah</label>
                            <select class="form-select @error('matakuliah_id') is-invalid @enderror" 
                                    id="matakuliah_id" name="matakuliah_id">
                                <option value="">Pilih Mata Kuliah</option>
                                @foreach($matakuliahs as $matakuliah)
                                    <option value="{{ $matakuliah->id }}" 
                                        {{ old('matakuliah_id', $pengampu->matakuliah_id) == $matakuliah->id ? 'selected' : '' }}>
                                        {{ $matakuliah->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('matakuliah_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tahun_akademik" class="form-label">Tahun Akademik</label>
                            <input type="text" class="form-control @error('tahun_akademik') is-invalid @enderror" 
                                   id="tahun_akademik" name="tahun_akademik" 
                                   value="{{ old('tahun_akademik', $pengampu->tahun_akademik) }}" 
                                   placeholder="Masukkan tahun akademik">
                            @error('tahun_akademik')
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
            
            // Validasi Dosen
            const dosen = document.getElementById('dosen_id');
            if (!dosen.value) {
                setInvalid(dosen, 'Dosen wajib dipilih');
                isValid = false;
            }
            
            // Validasi Mata Kuliah
            const matakuliah = document.getElementById('matakuliah_id');
            if (!matakuliah.value) {
                setInvalid(matakuliah, 'Mata kuliah wajib dipilih');
                isValid = false;
            }
            
            
            // Validasi Tahun Akademik
            const tahunAkademik = document.getElementById('tahun_akademik');
            if (!tahunAkademik.value.trim()) {
                setInvalid(tahunAkademik, 'Tahun akademik wajib diisi');
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