<!-- resources/views/mata-kuliah/edit.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Data Ruangan</h5>
                    <a href="{{ route('ruang.index') }}" class="btn btn-secondary">
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

                    <form action="{{ route('ruang.update', $ruang->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nama_ruang" class="form-label">Program Studi</label>
                            <input type="text" class="form-control @error('nama_ruang') is-invalid @enderror"
                                   id="nama_ruang" name="nama_ruang"
                                   value="{{ old('nama_ruang', $ruang->nama_ruang) }}"
                                   placeholder="Masukkan program studi">
                            @error('nama_ruang')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="kapasitas" class="form-label">Kapasitas Ruangan</label>
                            <select class="form-select @error('kapasitas') is-invalid @enderror"
                                    id="kapasitas" name="kapasitas">
                                <option value="">Pilih kapasitas</option>
                                @for($i = 1; $i <= 150; $i++)
                                    <option value="{{ $i }}" {{ old('kapasitas') == $i ? 'selected' : '' }}>
                                        Kapasitas Ruangan {{ $i }}
                                    </option>
                                @endfor
                            </select>
                            @error('kapasitas')
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

            // Validasi nama_ruang
            const nama_ruang = document.getElementById('nama_ruang');
            if (!nama_ruang.value.trim()) {
                setInvalid(nama_ruang, 'Program Studi wajib diisi');
                isValid = false;
            }

            const kapasitas = document.getElementById('kapasitas');
            if (!kapasitas.value || kapasitas.value < 1) {
                setInvalid(kapasitas, 'kapasitas minimal 1');
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
