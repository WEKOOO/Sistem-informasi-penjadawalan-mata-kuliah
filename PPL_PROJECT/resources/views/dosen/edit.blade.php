<!-- resources/views/mata-kuliah/edit.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Data Dosen</h5>
                    <a href="{{ route('dosen.index') }}" class="btn btn-secondary">
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

                    <form action="{{ route('dosen.update', $dosen->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Dosen</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                   id="nama" name="nama"
                                   value="{{ old('nama', $dosen->nama) }}"
                                   placeholder="Masukkan nama dosen">
                            @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nidn" class="form-label">Nidn</label>
                            <input type="text" class="form-control @error('nidn') is-invalid @enderror"
                                   id="nidn" name="nidn"
                                   value="{{ old('nidn', $dosen->nidn) }}"
                                   placeholder="Masukkan Nidn Dosen">
                            @error('nidn')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">email</label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email"
                                    value="{{ old('email', $dosen->email) }}"
                                    placeholder="Masukkan email dosen">
                            @error('email')
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

            // Validasi Nama
            const nama = document.getElementById('nama');
            if (!nama.value.trim()) {
                setInvalid(nama, 'Nama wajib diisi');
                isValid = false;
            }

            // Validasi Nidn
            const nidn = document.getElementById('nidn');
            if (!nidn.value.trim()) {
                setInvalid(nidn, 'NIDN wajib diisi');
                isValid = false;
            }

            // Validasi email
            const email = document.getElementById('email');
            if (!email.value.trim) {
                setInvalid(email, 'email wajib diisi');
                isValid = false;
            }


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
