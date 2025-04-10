@extends('layouts.app')

@section('title', 'Progres Proyek')

@section('content')
<style>
    .table {
        border-collapse: collapse;
        width: 100%;
    }

    .table tbody tr:nth-of-type(odd) {
        background-color: #fff;
    }

    .table tbody tr:nth-of-type(even) {
        background-color: rgba(128, 0, 0, 0.05);
    }

    .table thead {
        background-color: #800000;
    }

    .table td, .table th {
        border: 1px solid #dee2e6;
    }

    .pagination .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .pagination .page-link {
        color: #0d6efd;
    }

    .pagination .page-link:hover {
        background-color: #e9ecef;
        border-color: #dee2e6;
        color: #0a58ca;
    }
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
        .custom-table tbody tr:nth-of-type(odd) {
        background-color: #fff;
        }
        .btn-add{
            margin-right: 8px !important;
        }
}
</style>
<section id="main-content" class="col-12 col-md-12 ms-md-7">
    <div class="Progres-Proyek-content">
        <div class="row">
            <div class="card shadow-sm rounded-0 py-3 py-md-4 px-md-3">
                <h4 class="mb-3 mb-md-4 fw-bold">Progres Proyek</h4>
                
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-3">
                    <form method="GET" id="entriesForm" class="w-md-auto">
                        <div class="d-flex align-items-center gap-2">
                            <select class="form-select entries-dropdown" style="max-width: 70px;" name="entries" onchange="document.getElementById('entriesForm').submit()">
                                <option value="10" {{ request('entries') == 10 ? 'selected' : '' }}>10</option>
                                <option value="20" {{ request('entries') == 20 ? 'selected' : '' }}>20</option>
                                <option value="50" {{ request('entries') == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('entries') == 100 ? 'selected' : '' }}>100</option>
                            </select>
                            <span class="entries-label text-secondary">entries per page</span>
                        </div>
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                        <input type="hidden" name="direction" value="{{ request('direction') }}">
                    </form>

                    <div class="form-add w-md-auto d-flex flex-column flex-md-row gap-2">
                        <form method="GET" action="{{ route('tables.progresproyek') }}" class="d-flex search-form" id="searchForm">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-search"></i></span>
                                <input type="text" 
                                       name="search" 
                                       id="searchInput"
                                       class="form-control search-input" 
                                       placeholder="Search..." 
                                       value="{{ request('search') }}" 
                                       style="margin: 5px;"
                                       oninput="handleSearch(this)"
                                       autocomplete="off"/>
                            </div>
                        </form>
                        <a href="/Tambah-Data-Progres" class="btn-add fw-bold px-3 text-center" style="padding-top:12px;">+ Tambah</a>
                    </div>
                </div>

                <div class="table-responsive" style="margin:0px;">
                    <table class="table table-bordered align-middle">
                        <thead style="background-color: #800000;">
                            <tr>
                                <th class="py-3 px-3" style="width: 10%;">
                                    <a href="{{ route('tables.progresproyek', array_merge(request()->query(), ['sort' => 'id_proyek', 'direction' => $sortField === 'id_proyek' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                        Id Proyek
                                        <div class="sort-icons">    
                                            <i class="bx bxs-up-arrow {{ $sortField === 'id_proyek' && $sortDirection === 'asc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'id_proyek' && $sortDirection === 'desc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                        </div>
                                    </a>
                                </th>
                                <th class="py-3 px-3" style="width: 14%;">
                                    <a href="{{ route('tables.progresproyek', array_merge(request()->query(), ['sort' => 'tgl_progres', 'direction' => $sortField === 'tgl_progres' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                        Tgl Progres
                                        <div class="sort-icons">
                                            <i class="bx bxs-up-arrow {{ $sortField === 'tgl_progres' && $sortDirection === 'asc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'tgl_progres' && $sortDirection === 'desc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                        </div>
                                    </a>
                                </th>
                                <th class="py-3 px-3" style="width: 10%;">
                                    <a href="{{ route('tables.progresproyek', array_merge(request()->query(), ['sort' => 'progres', 'direction' => $sortField === 'progres' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                        Progres %
                                        <div class="sort-icons">
                                            <i class="bx bxs-up-arrow {{ $sortField === 'progres' && $sortDirection === 'asc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'progres' && $sortDirection === 'desc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                        </div>
                                    </a>
                                </th>
                                <th class="py-3 px-3">
                                    <a href="{{ route('tables.progresproyek', array_merge(request()->query(), ['sort' => 'keterangan', 'direction' => $sortField === 'keterangan' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                        Keterangan
                                        <div class="sort-icons">
                                            <i class="bx bxs-up-arrow {{ $sortField === 'keterangan' && $sortDirection === 'asc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'keterangan' && $sortDirection === 'desc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                        </div>
                                    </a>
                                </th>
                                <th class="py-3 px-3">
                                    <a href="{{ route('tables.progresproyek', array_merge(request()->query(), ['sort' => 'dokumen', 'direction' => $sortField === 'dokumen' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                        Dokumen
                                        <div class="sort-icons">
                                            <i class="bx bxs-up-arrow {{ $sortField === 'dokumen' && $sortDirection === 'asc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'dokumen' && $sortDirection === 'desc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                        </div>
                                    </a>
                                </th>
                                <th class="py-3 px-3" style="width: 10%;">
                                    <a href="" class="text-white header-link">
                                        Aksi
                                        <div class="sort-icons">
                                            <i class="bx bxs-up-arrow inactive" style="font-size: 9px;"></i>
                                            <i class="bx bxs-down-arrow inactive" style="font-size: 9px;"></i>
                                        </div>
                                    </a>
                                </th>
                            </tr>
                        </thead>

                        <tbody class="drafter-table">
                            @forelse($projects as $progresproyek)
                                <tr>
                                    <td class="text-center">{{ $progresproyek->id_proyek }}</td>
                                    <td class="text-center">{{ \Carbon\Carbon::parse($progresproyek->tgl_progres)->format('d/m/Y') }}</td>
                                    <td class="text-center">{{ $progresproyek->progres }}%</td>
                                    <td class="text-start">{{ $progresproyek->keterangan }}</td>
                                    <td class="text-start document-cell">
                                        @if($progresproyek->dokumen)
                                            <a href="{{ Storage::url($progresproyek->dokumen) }}" 
                                               target="_blank" 
                                               class="text-primary document-link" 
                                               title="{{$progresproyek->dokumen}}">
                                                <i class="bx bx-file"></i> {{basename($progresproyek->dokumen)}}
                                            </a>
                                        @else
                                            <span class="text-muted">Tidak ada dokumen</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('proyek.progress.edit', $progresproyek->id_progres) }}" 
                                               class="btn btn-sm btn-edit px-2 py-2">
                                                <i class="bx bx-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('progres.destroy', $progresproyek->id_progres) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-delete px-2 py-2">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-3">Data tidak ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

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
<script>
let searchTimeout;

function handleSearch(input) {
    clearTimeout(searchTimeout);
    const currentPosition = input.selectionStart;
    
    searchTimeout = setTimeout(() => {
        const form = document.getElementById('searchForm');
        const searchInput = document.getElementById('searchInput');
        
        form.submit();
        
        // Restore focus and cursor position after page reload
        setTimeout(() => {
            searchInput.focus();
            searchInput.setSelectionRange(currentPosition, currentPosition);
        }, 100);
    }, 500);
}

// Restore focus on page load if there was a search value
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    if (searchInput.value) {
        searchInput.focus();
        searchInput.setSelectionRange(searchInput.value.length, searchInput.value.length);
    }
});
</script>
