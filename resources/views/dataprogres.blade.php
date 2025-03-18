@extends('layouts.app')

@section('title', 'Detail Progres Proyekkk')

@section('content')
<div class="container-fluid px-4">
    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('proyek.progress') }}" class="text-decoration-none text-dark">
            <i class='bx bx-arrow-back fs-2'></i>
        </a>
    </div>

    <h2 class="mb-4">Detail Progres Proyekkk</h2>

    <!-- Project Info Cards -->
    <div class="row mb-4 g-3">
        <div class="col-md-4">
            <div class="bg-light rounded p-3">
                <small class="text-muted text-white d-block mb-1">Id Proyek</small>
                <span>{{ $progres->id_proyek ?? 'ASB0001' }}</span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="bg-light rounded p-3">
                <small class="text-muted d-block mb-1">Nama Proyek</small>
                <span>{{ $progres->proyek->nama_proyek ?? 'Proyek1' }}</span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="bg-light rounded p-3">
                <small class="text-muted d-block mb-1">Id Drafter</small>
                <span>{{ $progres->proyek->drafter_id ?? 'D0001' }}</span>
            </div>
        </div>
    </div>

    <!-- Progress Files Table -->
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th class="text-muted" style="width: 30%">
                        Nama File
                        <i class='bx bx-sort-alt-2'></i>
                    </th>
                    <th class="text-muted" style="width: 20%">
                        Tgl Progres
                        <i class='bx bx-sort-alt-2'></i>
                    </th>
                    <th class="text-muted" style="width: 35%">
                        Keterangan
                        <i class='bx bx-sort-alt-2'></i>
                    </th>
                    <th class="text-muted" style="width: 15%">
                        Aksi
                        <i class='bx bx-sort-alt-2'></i>
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($progres_files ?? [] as $file)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <i class='bx bx-file-blank text-primary fs-5 me-2'></i>
                            {{ basename($file->dokumen) }}
                        </div>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($file->tgl_progres)->format('d/m/Y') }}</td>
                    <td>{{ $file->keterangan }}</td>
                    <td>
                        <a href="{{ route('progres.download', ['id_proyek' => $file->id_proyek]) }}" 
                           class="btn btn-success btn-sm rounded-1 px-3">
                            <i class='bx bx-download'></i> DOWNLOAD
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">Tidak ada file progres</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
.bg-light {
    background-color: #f8f9fa;
    border: 1px solid #e9ecef;
}

.table th {
    border-bottom: none;
    font-weight: normal;
    padding: 1rem 0.5rem;
}

.table td {
    padding: 1rem 0.5rem;
    vertical-align: middle;
}

.btn-success {
    background-color: #00875A;
    border: none;
    font-size: 0.875rem;
}

.btn-success:hover {
    background-color: #006644;
}

.table tbody tr:nth-child(even) {
    background-color: #f8f9fa;
}

.bx-sort-alt-2 {
    font-size: 1.2rem;
    vertical-align: middle;
    color: #6c757d;
}

.bx-file-blank {
    color: #4285f4;
}
</style>
@endsection