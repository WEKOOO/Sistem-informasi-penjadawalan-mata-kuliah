<!-- resources/views/mata-kuliah/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Tambah Data Ruangan</h5>
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

                    <form action="{{ route('ruang.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_ruang" class="form-label">Ruangan</label>
                            <input type="text" class="form-control @error('nama_ruang') is-invalid @enderror"
                                   id="nama_ruang" name="nama_ruang" value="{{ old('nama_ruang') }}"
                                   placeholder="Masukkan ruangan">
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
                                Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
