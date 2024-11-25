@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambah Jadwal Kuliah</h3>
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

                    <form action="{{ route('jadwalkuliah.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="matakuliah_id" class="form-label">Mata Kuliah</label>
                            <select name="matakuliah_id" id="matakuliah_id" class="form-select" required>
                                <option value="">Pilih Mata Kuliah</option>
                                @foreach($matakuliahs as $matakuliah)
                                    <option value="{{ $matakuliah->id }}" {{ old('matakuliah_id') == $matakuliah->id ? 'selected' : '' }}>
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
                                    <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="dosen_id" class="form-label">Dosen</label>
                            <select name="dosen_id" id="dosen_id" class="form-select" required>
                                <option value="">Pilih Dosen</option>
                                @foreach($dosens as $dosen)
                                    <option value="{{ $dosen->id }}" {{ old('dosen_id') == $dosen->id ? 'selected' : '' }}>
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
                                            <option value="{{ $hari->id }}" {{ old('hari_id') == $hari->id ? 'selected' : '' }}>
                                                {{ $hari->nama_hari }}
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
                                            <option value="{{ $jam->id }}" {{ old('jam_id') == $jam->id ? 'selected' : '' }}>
                                                {{ $jam->jam_id }}
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
                                            <option value="{{ $ruang->id }}" {{ old('ruang_id') == $ruang->id ? 'selected' : '' }}>
                                                {{ $ruang->nama_ruang }}
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
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection