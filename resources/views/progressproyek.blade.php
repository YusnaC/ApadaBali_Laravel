@extends('layouts.app')

@section('title', 'Progress Proyek')

@section('content')

<!-- Section utama untuk menampilkan pencatatan furniture -->
<section id="main-content" class="col-md-12 ms-md-7">
    <div class="pencatatan-furniture-content">
        <div class="row">
            <div class="card shadow-sm rounded-0 py-4 px-3">
                <h4 class="mb-4 fw-bold">Progres Proyek</h4>
                
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                    <form method="GET" id="entriesForm" class="mb-2 mb-md-0">
                        <div class="d-flex align-items-center">
                            <select class="form-select-entries entries-dropdown me-2" name="entries" onchange="document.getElementById('entriesForm').submit()">
                                <option value="10" {{ request('entries') == 10 ? 'selected' : '' }}>10</option>
                                <option value="20" {{ request('entries') == 20 ? 'selected' : '' }}>20</option>
                                <option value="50" {{ request('entries') == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('entries') == 100 ? 'selected' : '' }}>100</option>
                            </select>
                            <span class="entries-label text-secondary small">entries per page</span>
                        </div>
                        <!-- Menyertakan parameter query lainnya -->
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                        <input type="hidden" name="direction" value="{{ request('direction') }}">
                    </form>

                    <div class="form-add d-flex flex-wrap w-md-auto" >
                        <form method="GET" action="{{ route('proyek.progress') }}" class="d-flex search-form flex-grow-1 me-md-2 mb-2 mb-md-0">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-search"></i></span>
                                <input type="text" name="search" class="form-control search-input" placeholder="Search..." value="{{ request('search') }}" style="margin: 5px;"/>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <!-- Kolom untuk ID Furniture dengan pengurutan -->
                                <th class="py-3 px-3" style="width: 10%;">
                                    <a href="{{ route('proyek.progress', array_merge(request()->query(), ['sort' => 'id_proyek', 'direction' => $sortField === 'id_proyek' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                        <span>Id Proyek</span>
                                        <div class="sort-icons">
                                            <i class="bx bxs-up-arrow {{ $sortField === 'id_proyek' && $sortDirection === 'asc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'id_proyek' && $sortDirection === 'desc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                        </div>
                                    </a>
                                </th>
                                <!-- Kolom untuk Tanggal Pembuatan dengan pengurutan -->
                                <th class="py-3 px-3" style="width: 30%;">
                                    <a href="{{ route('proyek.progress', array_merge(request()->query(), ['sort' => 'status_progres', 'direction' => $sortField === 'status_progres' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                        Status
                                        <div class="sort-icons">
                                            <i class="bx bxs-up-arrow {{ $sortField === 'status_progres' && $sortDirection === 'asc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'status_progres' && $sortDirection === 'desc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                        </div>
                                    </a>
                                </th>
                                <!-- Kolom untuk Nama Furniture dengan pengurutan -->
                                <th class="py-3 px-3">
                                    <a href="{{ route('proyek.progress', array_merge(request()->query(), ['sort' => 'progres', 'direction' => $sortField === 'progres' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                        Progres %
                                        <div class="sort-icons">
                                            <i class="bx bxs-up-arrow {{ $sortField === 'progres' && $sortDirection === 'asc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'progres' && $sortDirection === 'desc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                        </div>
                                    </a>
                                </th>
                                
                                <!-- Kolom untuk Aksi -->
                                <th class="py-3 px-3" style="width: 10%;">
                                    <a class="text-white header-link">
                                        Aksi
                                        <div class="sort-icons">
                                            <i class="bx bxs-up-arrow inactive" style="font-size: 9px;"></i>
                                            <i class="bx bxs-down-arrow inactive" style="font-size: 9px;"></i>
                                        </div>
                                    </a>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($projects->isEmpty())
                            <tr>
                                <td colspan="4" class="text-center text-muted">Data tidak ditemukan.</td>
                            </tr>
                            @else
                                @foreach($projects as $project)
                                <tr class="{{ $loop->even ? 'bg-light' : '' }}">
                                    <td>{{ $project->id_proyek }}</td>
                                    <td>
                                        <span class="badge {{ $project->status_progres == 'Proses' ? 'bg-warning text-dark' : 'bg-success text-white' }} rounded-pill px-5 py-2 fs-7 text-white" style="font-size: 0.85rem;">
                                            {{ $project->status_progres }}
                                        </span>
                                    </td>
                                    <td>
                                    <div class="d-flex align-items-center custom-progress-bar">
                                        <div class="progress flex-grow-1" style="height: 10px; border-radius: 10px;">
                                            <div class="progress-bar" 
                                                role="progressbar" 
                                                style="width: {{ $project->progres }}%; background-color: #ff6842; border-radius: 10px;"
                                                aria-valuenow="{{ $project->progres }}" 
                                                aria-valuemin="0" 
                                                aria-valuemax="100">
                                            </div>
                                        </div>
                                        <span class="ms-2 fw-bold">{{ $project->progres }}%</span>
                                    </div>

                                    </td>
                                    <td class="text-center align-middle">
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('progres.show', $project->id_proyek) }}" 
                                                class="btn btn-sm btn-outline-success d-flex rounded-full"
                                                style="width: 40px; height: 40px; padding: 0; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease; border: 1px solid #28a745; color: #28a745;">
                                                <i class='bx bx-show' style="font-size: 18px; color: #28a745;"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>

                    <!-- Pagination section -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                    <span class="text-muted pagination-info">
                            Showing {{ ($currentPage - 1) * $perPage + 1 }} to 
                            {{ min($currentPage * $perPage, $total) }} from {{ $total }} entries
                        </span>


                            <nav>
                                <ul class="pagination">
                                    {{-- Tombol "Previous" --}}
                                    <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
                                        <a class="page-link arrow" 
                                        href="{{ $currentPage > 1 ? route('proyek.progress', array_merge(request()->all(), ['page' => $currentPage - 1])) : '#' }}">
                                            &#x276E;
                                        </a>
                                    </li>

                                    {{-- Loop Halaman --}}
                                    @for ($i = 1; $i <= ceil($total / $perPage); $i++)
                                        <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                                            <a class="page-link"
                                            href="{{ route('proyek.progress', array_merge(request()->all(), ['page' => $i])) }}">
                                                {{ $i }}
                                            </a>
                                        </li>
                                    @endfor

                                    {{-- Tombol "Next" --}}
                                    <li class="page-item {{ $currentPage == ceil($total / $perPage) ? 'disabled' : '' }}">
                                        <a class="page-link arrow" 
                                        href="{{ $currentPage < ceil($total / $perPage) ? route('proyek.progress', array_merge(request()->all(), ['page' => $currentPage + 1])) : '#' }}">
                                            &#x276F;
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
            </div>
        </div>
    </div>
</section>
@endsection
<script>
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.querySelector(".search-input");

    searchInput.addEventListener("input", function () {
        const query = this.value.trim();
        const url = new URL(window.location.href);
        url.searchParams.set("search", query);

        fetch(url)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, "text/html");
                const newTable = doc.querySelector("table tbody");
                const oldTable = document.querySelector("table tbody");

                if (newTable && oldTable) {
                    oldTable.innerHTML = newTable.innerHTML;
                }
            })
            .catch(error => console.error("Error fetching search results:", error));
    });
});
</script>

<!-- this is end new -->
