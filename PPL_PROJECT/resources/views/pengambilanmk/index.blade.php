@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row g-4">
        <h4 class="title-with-underline">Tabel Data Mata Kuliah</h4>
        <hr class="short-underline">
        
        <div class="col-md-3">
            <div class="card text-center p-3">
                <div class="card-body">
                    <i class="bi bi-people-fill text-primary" style="font-size: 40px;"></i>
                    <h5 class="card-title mt-2">Dosen</h5>
                    <a href="#" class="btn btn-outline-primary mt-2">Lihat Data</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-3">
                <div class="card-body">
                    <i class="bi bi-person-fill text-success" style="font-size: 40px;"></i>
                    <h5 class="card-title mt-2">Mahasiswa</h5>
                    <a href="#" class="btn btn-outline-success mt-2">Lihat Data</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-3">
                <div class="card-body">
                    <i class="bi bi-building text-warning" style="font-size: 40px;"></i>
                    <h5 class="card-title mt-2">Ruangan</h5>
                    <a href="#" class="btn btn-outline-warning mt-2">Lihat Data</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-3">
                <div class="card-body">
                    <i class="bi bi-journal-text text-danger" style="font-size: 40px;"></i>
                    <h5 class="card-title mt-2">Program Studi</h5>
                    <a href="#" class="btn btn-outline-danger mt-2">Lihat Data</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
