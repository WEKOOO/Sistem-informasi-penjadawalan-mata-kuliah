<!-- resources/views/mata-kuliah/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Tambah Data Pengampu</h5>
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

                    <form action="{{ route('pengampu.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label>Dosen</label>
                            <select name="dosen_id" class="form-control @error('dosen_id') is-invalid @enderror">
                                <option value="">Pilih Dosen</option>
                                @foreach($dosens as $dosen)
                                    <option value="{{ $dosen->id }}">{{ $dosen->nama }}</option>
                                @endforeach
                            </select>
                            @error('dosen_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        

                        <div class="mb-3">
                            <label>Mata Kuliah</label>
                            <select name="matakuliah_id" class="form-control @error('matakuliah_id') is-invalid @enderror">
                                <option value="">Pilih Mata Kuliah</option>
                                @foreach($matakuliahs as $matakuliah)
                                    <option value="{{ $matakuliah->id }}">{{ $matakuliah->nama }}</option>
                                @endforeach
                            </select>
                            @error('matakuliah_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="mb-3">
                            <label>Tahun Akademik</label>
                            <input type="text" name="tahun_akademik" class="form-control @error('tahun_akademik') is-invalid @enderror">
                            @error('tahun_akademik')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
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