@extends('layouts.app')

@section('title', 'Progres Proyek')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-11">
        <div class="card shadow-sm rounded-3 border-0">
            <div class="card-body p-4">
                <h4 class="mb-4">Progres Proyek</h4>

                <!-- Controls -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="d-flex align-items-center">
                        <select class="form-select form-select-sm me-2" style="width: 60px;">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <span class="text-muted small">entries per page</span>
                    </div>

                    <div class="d-flex align-items-center">
                        <div class="input-group input-group-sm me-2">
                            <input type="text" class="form-control" placeholder="Search" style="width: 200px;">
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 15%">
                                    <a href="{{ route('proyek.progress', array_merge(request()->query(), ['sort' => 'id_proyek', 'direction' => $sortField === 'id_proyek' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                        Id Proyek
                                        <div class="sort-icons">
                                            <i class="bx bxs-up-arrow {{ $sortField === 'id_proyek' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'id_proyek' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                        </div>
                                    </a>
                                </th>
                                <th style="width: 15%">
                                    <a href="{{ route('tables.proyek', array_merge(request()->query(), ['sort' => 'kategori', 'direction' => $sortField === 'kategori' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                        Status
                                        <div class="sort-icons">
                                            <i class="bx bxs-up-arrow {{ $sortField === 'kategori' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'kategori' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                        </div>
                                    </a>
                                </th>
                                <th style="width: 60%">
                                    <a href="{{ route('tables.proyek', array_merge(request()->query(), ['sort' => 'tgl_proyek', 'direction' => $sortField === 'tgl_proyek' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                        Progress
                                        <div class="sort-icons">
                                            <i class="bx bxs-up-arrow {{ $sortField === 'tgl_proyek' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'tgl_proyek' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                        </div>
                                    </a>
                                </th>
                                <th style="width: 10%">
                                    <a href="{{ route('tables.proyek', array_merge(request()->query(), ['sort' => 'aksi', 'direction' => $sortField === 'aksi' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                        Aksi
                                        <div class="sort-icons">
                                            <i class="bx bxs-up-arrow {{ $sortField === 'aksi' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'aksi' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                        </div>
                                    </a>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($projects as $project)
                            <tr class="{{ $loop->even ? 'bg-light' : '' }}">
                                <td>{{ $project->id_proyek }}</td>
                                <td>
                                    <span class="badge {{ $project->status_progres == 'Proses' ? 'bg-warning text-dark' : 'bg-success text-white' }} rounded-pill px-3">
                                        {{ $project->status_progres }}
                                    </span>
                                </td>
                                <td>
                                    <div class="progress" style="height: 15px;">
                                        <div class="progress-bar bg-danger" 
                                            role="progressbar" 
                                            style="width: {{ $project->progres }}%"
                                            aria-valuenow="{{ $project->progres }}" 
                                            aria-valuemin="0" 
                                            aria-valuemax="100">
                                            {{ $project->progres }}%
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <!-- <button class="btn btn-sm btn-outline-primary rounded-circle">
                                        <i class='bx bx-show'></i>
                                    </button> -->
                                    <a href="{{ route('progres.show', $project->id_proyek) }}" class="btn btn-sm btn-outline-primary rounded-circle">
                                        <i class='bx bx-show'></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted small">
                        Showing 1 to 10 of 30 entries
                    </div>
                    <nav>
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    background: white;
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
}
.progress {
    background-color: #ffecec;
    border-radius: 20px;
    overflow: hidden;
}
.progress-bar {
    background-color: #ff6b6b;
}
.table th {
    font-weight: 500;
    border: none;
}
.table td {
    border-color: #f0f0f0;
}
.badge {
    font-weight: normal;
}
.page-link {
    color: #4285f4;
    border: none;
    padding: 0.4rem 0.75rem;
}
.page-item.active .page-link {
    background-color: #4285f4;
}
.form-select, .form-control {
    border: 1px solid #e0e0e0;
}
.table th {
    font-weight: 500;
    border: none;
    background-color: #4285f4;
    padding: 12px;
}
</style>
@endsection
