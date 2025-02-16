@extends('layouts.app')

@section('title', 'Tambah Proyek')

@section('content')
<section id="main-content" class="col-md-12 ms-md-7">
    <div class="pencatatan-proyek-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm rounded-0 py-4">
                    <div class="card-body">
                        <h4 class="mb-4 fw-bold">Tambah Proyek</h4>
                        <form action="{{ route('projects.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="project_id" class="form-label">ID Proyek</label>
                                        <input type="text" class="form-control" id="project_id" name="project_id" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="category" class="form-label">Kategori</label>
                                        <input type="text" class="form-control" id="category" name="category" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="project_date" class="form-label">Tanggal Proyek</label>
                                        <input type="date" class="form-control" id="project_date" name="project_date" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="project_name" class="form-label">Nama Proyek</label>
                                        <input type="text" class="form-control" id="project_name" name="project_name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="location" class="form-label">Lokasi</label>
                                        <input type="text" class="form-control" id="location" name="location" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="area" class="form-label">Area</label>
                                        <input type="text" class="form-control" id="area" name="area" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="number_of_floors" class="form-label">Jumlah Lantai</label>
                                        <input type="number" class="form-control" id="number_of_floors" name="number_of_floors" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="deadline_date" class="form-label">Tanggal Deadline</label>
                                        <input type="date" class="form-control" id="deadline_date" name="deadline_date" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="drafter_id" class="form-label">ID Drafter</label>
                                        <input type="text" class="form-control" id="drafter_id" name="drafter_id" required>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
