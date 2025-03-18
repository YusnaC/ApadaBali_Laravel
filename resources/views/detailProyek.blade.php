@extends('layouts.app')

@section('title', 'Detail Progres Proyek')

@section('content')
<div class="mb-4 ms-5">
    <a href="{{ route('progresproyek') }}" class="text-decoration-none text-dark d-inline-flex align-items-center">
        <i class='bx bx-arrow-back fs-2'></i>
    </a>
</div>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <div class="card shadow-sm rounded-0">
                <div class="card-body p-4">
                    <div class="card-header bg-white py-3 border-0">
                        <h5 class="card-title mb-0 text-center">Detail Progres Proyek</h5>
                    </div>
                    <div class="project-details mb-5">
                        <div class="row g-4">
                            <div class="col-md-4">
                                <label class="text-muted mb-2">ID Proyek</label>
                                <div class="bg-light p-3 rounded">
                                    {{ $progres->first()->id_proyek }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="text-muted mb-2">Nama Proyek</label>
                                <div class="bg-light p-3 rounded">
                                    {{ $progres->first()->proyek->nama_proyek }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="text-muted mb-2">ID Drafter</label>
                                <div class="bg-light p-3 rounded">
                                    {{ $progres->first()->proyek->id_drafter ?? '-' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <h6 class="mb-4">Daftar File Progres</h6>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama File</th>
                                    <th>Tgl Progres</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($progres as $progress)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class='bx bx-file me-2 text-primary'></i>
                                                {{ basename($progress->dokumen) ?? '-' }}
                                            </div>
                                        </td>
                                        <td>{{ $progress->tgl_progres ?? '-' }}</td>
                                        <td>{{ $progress->keterangan ?? '-' }}</td>
                                        <td>
                                            @if($progress->dokumen)
                                                <a href="{{ Storage::url($progress->dokumen) }}" 
                                                   class="btn btn-success btn-sm px-3">
                                                    <i class='bx bx-download me-1'></i>
                                                    Download
                                                </a>
                                            @else
                                                <span class="text-muted">No file</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">
                                            <div class="text-muted">No progress records found</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    background-color: #ffffff;
    border: none;
}
.card-header {
    background-color: #ffffff;
    border-bottom: none;
}
.bg-light {
    background-color: #f8f9fa;
}
.table th {
    background-color: #4285f4;
    color: #ffffff;
    font-weight: 500;
    border-top: none;
    padding: 12px;
}
.table td {
    vertical-align: middle;
}
.btn-success {
    background-color: #28a745;
    border-color: #28a745;
}
</style>
@endsection