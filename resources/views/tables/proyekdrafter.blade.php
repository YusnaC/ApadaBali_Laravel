@extends('layouts.app')

@section('title', 'Daftar Proyek')

@section('content')
<style>
    @media (max-width: 768px) {
        .table-responsive {
            margin: 0 !important;
            padding: 0 !important;
            /* width: 100vw; */
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        .card {
            padding-right: 0 !important;
        }
        
        .custom-table {
            min-width: 800px;
            margin: 0;
        }
        .input-group {
            margin-right: 8px !important;
        }
        .pagination{
            margin-left: 5px !important;
            padding-right: 1rem !important;
        }
        .table td, .table th {
            white-space: nowrap;
            padding: 0.75rem !important;
        }
    }
    .table td, .table th {
            white-space: nowrap;
            padding: 0.75rem !important;
        }
    .custom-table tbody tr:nth-of-type(odd) {
        background-color: #fff;
    }
    .custom-table tbody tr:nth-of-type(even) {
        background-color: rgba(128, 0, 0, 0.05);
    }
</style>
<section id="main-content" class="col-12 col-md-12 ms-md-7">
    <div class="Daftar-Proyek-content">
        <div class="row">
            <div class="card shadow-sm rounded-0 py-3 py-md-4 px-2 px-md-3">
                <h4 class="mb-3 mb-md-4 fw-bold">Daftar Proyek</h4>
                
                <!-- Tombol untuk menambah dan mencari -->
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-3">
                    <!-- Dropdown untuk menentukan jumlah entries per page dan label -->
                    <form method="GET" id="entriesForm" class="w-100 w-md-auto">
                        <div class="d-flex align-items-center gap-2">
                            <select class="form-select entries-dropdown" style="max-width: 70px;" name="entries" onchange="document.getElementById('entriesForm').submit()">
                                <option value="10" {{ request('entries') == 10 ? 'selected' : '' }}>10</option>
                                <option value="20" {{ request('entries') == 20 ? 'selected' : '' }}>20</option>
                                <option value="50" {{ request('entries') == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('entries') == 100 ? 'selected' : '' }}>100</option>
                            </select>
                            <span class="entries-label text-secondary">entries per page</span>
                        </div>

                        <!-- Menyertakan parameter query lainnya -->
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                        <input type="hidden" name="direction" value="{{ request('direction') }}">
                    </form>

                    <div class="form-add w-md-auto">
                        <!-- Form pencarian -->
                        <form method="GET" action="{{ route('tables.proyekdrafter') }}" class="d-flex search-form" id="searchForm">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bx bx-search"></i>
                                </span>
                                <input type="text" 
                                       name="search" 
                                       class="form-control search-input" 
                                       placeholder="Search..." 
                                       value="{{ request('search') }}" 
                                       style="margin: 5px;"
                                       id="searchInput"/>
                            </div>
                        </form>
                        
                        @push('scripts')
                        <script>
                            const searchInput = document.getElementById('searchInput');
                            let searchTimer;
                            
                            searchInput.addEventListener('input', function(e) {
                                clearTimeout(searchTimer);
                                const value = this.value;
                                const cursorPosition = this.selectionStart;
                            
                                searchTimer = setTimeout(() => {
                                    fetch(`${window.location.pathname}?search=${value}`)
                                        .then(response => response.text())
                                        .then(html => {
                                            const parser = new DOMParser();
                                            const doc = parser.parseFromString(html, 'text/html');
                                            document.querySelector('.table-responsive').innerHTML = doc.querySelector('.table-responsive').innerHTML;
                                            document.querySelector('.d-flex.flex-column.flex-md-row.justify-content-between.align-items-center').innerHTML = 
                                                doc.querySelector('.d-flex.flex-column.flex-md-row.justify-content-between.align-items-center').innerHTML;
                                            searchInput.focus();
                                            searchInput.setSelectionRange(cursorPosition, cursorPosition);
                                        });
                                }, 500);
                            });
                        </script>
                        @endpush
                    </div>
                </div>

                <!-- Tabel Data -->
                <div class="table-responsive" style="margin:0px;">
                    <table class="table table-bordered custom-table align-middle">
                        <thead style="background-color: #800000;">
                            <tr>
                                <!-- Header tabel dengan link untuk sorting -->
                                <th class="py-3 px-3" style="width: 12%;">
                                    <a href="{{ route('tables.proyekdrafter', array_merge(request()->query(), ['sort' => 'id_proyek', 'direction' => $sortField === 'id_proyek' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                        Id Proyek
                                        <div class="sort-icons">    
                                            <i class="bx bxs-up-arrow {{ $sortField === 'id_proyek' && $sortDirection === 'asc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'id_proyek' && $sortDirection === 'desc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                        </div>
                                    </a>
                                </th>
                                <th class="py-3 px-3" style="width: 14%;">
                                    <a href="{{ route('tables.proyekdrafter', array_merge(request()->query(), ['sort' => 'tgl_proyek', 'direction' => $sortField === 'tgl_proyek' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                        Tgl Proyek
                                        <div class="sort-icons">
                                            <i class="bx bxs-up-arrow {{ $sortField === 'tgl_proyek' && $sortDirection === 'asc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'tgl_proyek' && $sortDirection === 'desc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                        </div>
                                    </a>
                                </th>
                                <th class="py-3 px-3" style="width: 20%;">
                                    <a href="{{ route('tables.proyekdrafter', array_merge(request()->query(), ['sort' => 'nama_proyek', 'direction' => $sortField === 'nama_proyek' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                        Nama Proyek
                                        <div class="sort-icons">
                                            <i class="bx bxs-up-arrow {{ $sortField === 'nama_proyek' && $sortDirection === 'asc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'nama_proyek' && $sortDirection === 'desc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                        </div>
                                    </a>
                                </th>
                                <th class="py-3 px-3" style="width: 20%;">
                                    <a href="{{ route('tables.proyekdrafter', array_merge(request()->query(), ['sort' => 'lokasi', 'direction' => $sortField === 'lokasi' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                        Lokasi
                                        <div class="sort-icons">
                                            <i class="bx bxs-up-arrow {{ $sortField === 'lokasi' && $sortDirection === 'asc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'lokasi' && $sortDirection === 'desc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                        </div>
                                    </a>
                                </th>
                                <th class="py-3 px-3" style="width: 12%;">
                                    <a href="{{ route('tables.proyekdrafter', array_merge(request()->query(), ['sort' => 'luas', 'direction' => $sortField === 'luas' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                        Luas (m²)
                                        <div class="sort-icons">
                                            <i class="bx bxs-up-arrow {{ $sortField === 'luas' && $sortDirection === 'asc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'luas' && $sortDirection === 'desc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                        </div>
                                    </a>
                                </th>
                                <th class="py-3 px-3" style="width: 14%">
                                    <a href="{{ route('tables.proyekdrafter', array_merge(request()->query(), ['sort' => 'jumlah_lantai', 'direction' => $sortField === 'jumlah_lantai' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                        Jumlah Lantai
                                        <div class="sort-icons">
                                            <i class="bx bxs-up-arrow {{ $sortField === 'jumlah_lantai' && $sortDirection === 'asc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'jumlah_lantai' && $sortDirection === 'desc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                        </div>
                                    </a>
                                </th>
                                <th class="py-3 px-3" style="width: 14%;">
                                    <a href="{{ route('tables.proyekdrafter', array_merge(request()->query(), ['sort' => 'tgl_deadline', 'direction' => $sortField === 'tgl_deadline' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                        Tgl Deadline
                                        <div class="sort-icons">
                                            <i class="bx bxs-up-arrow {{ $sortField === 'tgl_deadline' && $sortDirection === 'asc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'tgl_deadline' && $sortDirection === 'desc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                        </div>
                                    </a>
                                </th>
                            </tr>
                        </thead>

                        <tbody class="drafter-table py-4">
                            @forelse($projects as $project)
                                <tr>
                                    <td class="text-center" style="padding:1rem;">{{ $project->id_proyek }}</td>
                                    <td class="text-center">{{ \Carbon\Carbon::parse($project->tgl_proyek)->format('d/m/Y') }}</td>
                                    <td class="text-start text-wrap">{{ $project->nama_proyek }}</td>
                                    <td class="text-start text-wrap">{{ $project->lokasi }}</td>
                                    <td class="text-center">{{ (int)$project->luas }}</td>
                                    <td class="text-center">{{ $project->jumlah_lantai }}</td>
                                    <td class="text-center">{{ \Carbon\Carbon::parse($project->tgl_deadline)->format('d/m/Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-3">Data tidak ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Navigasi Halaman -->
                <!-- Kontrol pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <span class="text-muted pagination-info">
                        Showing {{ $projects->firstItem() ?? 1 }} to 
                        {{ $projects->lastItem() ?? $projects->count() }} from {{ $projects->total() }} entries
                    </span>
                    <style>
.pagination-info {
    font-size: 14px; /* Default size for normal screens */
}

@media (max-width: 768px) {
    .pagination-info {
        font-size: 12px;
    }
}
</style>
                    <nav>
                        <ul class="pagination">
                            {{-- Previous Button --}}
                            <li class="page-item {{ $projects->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link arrow" 
                                href="{{ !$projects->onFirstPage() ? $projects->previousPageUrl() : '#' }}">
                                    &#x276E;
                                </a>
                            </li>

                            {{-- Page Numbers --}}
                            @for ($i = 1; $i <= $projects->lastPage(); $i++)
                                <li class="page-item {{ $i == $projects->currentPage() ? 'active' : '' }}">
                                    <a class="page-link"
                                    href="{{ $projects->url($i) }}">
                                        {{ $i }}
                                    </a>
                                </li>
                            @endfor

                            {{-- Next Button --}}
                            <li class="page-item {{ !$projects->hasMorePages() ? 'disabled' : '' }}">
                                <a class="page-link arrow" 
                                href="{{ $projects->hasMorePages() ? $projects->nextPageUrl() : '#' }}">
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
