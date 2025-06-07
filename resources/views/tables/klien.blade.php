@extends('layouts.app')

@section('title', 'Managemen Klien')

@section('content')
<!-- Section utama untuk menampilan data klien -->
<section id="main-content" class="col-md-12 ms-md-7">
    <div class="pencatatan-klien-content">
        <div class="row">
            <div class="card shadow-sm rounded-0 py-4 px-3">
                <h4 class="mb-4 fw-bold">Data Klien</h4>
                
                <!-- Dropdown dan Search -->
             
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
                        <!-- Hidden Inputs untuk menjaga query parameter search dan sorting -->
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                        <input type="hidden" name="direction" value="{{ request('direction') }}">
                    </form>

                    <div class="form-add d-flex w-md-auto">
                        <form method="GET" action="{{ route('tables.klien') }}" class="d-flex search-form flex-grow-1 me-md-2 mb-2 mb-md-0">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bx bx-search"></i>
                                </span>
                                <input type="text" name="search" class="form-control search-input" placeholder="Search..." value="{{ request('search') }}" onkeyup="handleSearch(event)" style="margin: 5px;"/>
                            </div>
                        </form>
                        <a href="/Tambah-Data-Klien" class="btn-add fw-bold px-3" style="padding-top:12px;">+ Tambah</a>
                    </div>
               
                </div>
                <!-- Tabel Data -->
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="py-3 px-3" style="width: 10%;">
                                    <a href="{{ route('tables.klien', array_merge(request()->query(), ['sort' => 'id_klien', 'direction' => $sortField === 'id_klien' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                        Id Klien
                                        <div class="sort-icons">    
                                            <i class="bx bxs-up-arrow {{ $sortField === 'id_klien' && $sortDirection === 'asc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'id_klien' && $sortDirection === 'desc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                        </div>
                                    </a>
                                </th>
                                <th class="py-3 px-3" style="width:15%">
                                    <a href="{{ route('tables.klien', array_merge(request()->query(), ['sort' => 'jenis_order', 'direction' => $sortField === 'jenis_order' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                        Jenis Order
                                        <div class="sort-icons">
                                            <i class="bx bxs-up-arrow {{ $sortField === 'jenis_order' && $sortDirection === 'asc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'jenis_order' && $sortDirection === 'desc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                        </div>
                                    </a>
                                </th>
                                <th class="py-3 px-3" style="width:10%">
                                    <a href="{{ route('tables.klien', array_merge(request()->query(), ['sort' => 'id_order', 'direction' => $sortField === 'id_order' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                        Id Order
                                        <div class="sort-icons">
                                            <i class="bx bxs-up-arrow {{ $sortField === 'id_order' && $sortDirection === 'asc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'id_order' && $sortDirection === 'desc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                        </div>
                                    </a>
                                </th>
                                <th class="py-3 px-3">
                                    <a href="{{ route('tables.klien', array_merge(request()->query(), ['sort' => 'nama_klien', 'direction' => $sortField === 'nama_klien' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                        Nama Klien
                                        <div class="sort-icons">
                                            <i class="bx bxs-up-arrow {{ $sortField === 'nama_klien' && $sortDirection === 'asc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'nama_klien' && $sortDirection === 'desc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                        </div>
                                    </a>
                                </th>
                                <th class="py-3 px-3">
                                    <a href="{{ route('tables.klien', array_merge(request()->query(), ['sort' => 'alamat_klien', 'direction' => $sortField === 'alamat_klien' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                        Alamat Klien
                                        <div class="sort-icons">
                                            <i class="bx bxs-up-arrow {{ $sortField === 'alamat_klien' && $sortDirection === 'asc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'alamat_klien' && $sortDirection === 'desc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                        </div>
                                    </a>
                                </th>
                                <th class="py-3 px-3" style="width: 13%;">
                                    <a href="{{ route('tables.klien', array_merge(request()->query(), ['sort' => 'no_whatsapp', 'direction' => $sortField === 'no_whatsapp' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                        No WhatsApp
                                        <div class="sort-icons">
                                            <i class="bx bxs-up-arrow {{ $sortField === 'no_whatsapp' && $sortDirection === 'asc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'no_whatsapp' && $sortDirection === 'desc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                        </div>
                                    </a>
                                </th>
                                <th class="py-3 px-3" style="width:10%">
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

                    <tbody>
                        <!-- Loop untuk menampilkan data proyek -->
                        @forelse($projects as $klien)
                            <tr>
                                <td>{{ $klien['id_klien'] }}</td>
                                <td class="text-start">{{ $klien['jenis_order'] }}</td>
                                <td>{{ $klien['id_order'] }}</td>
                                <td class="text-start">{{ $klien['nama_klien'] }}</td>
                                <td class="text-start">{{ $klien['alamat_klien'] }}</td>
                                <td>{{ $klien['no_whatsapp'] }}</td>
                                <td>
                                <div class="button-container">
                                    <a href="{{ route('klien.edit', $klien['id_klien']) }}" class="btn btn-edit">
                                        <i class="bx bx-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('klien.destroy', $klien['id_klien']) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-delete">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </form>
                                </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Data tidak ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                                              <span class="text-muted pagination-info">
                            Showing {{ ($currentPage - 1) * $perPage + 1 }} to 
                            {{ min($currentPage * $perPage, $total) }} from {{ $total }} entries
                        </span>

<!-- Add this style section at the bottom of the file -->
<style>
@media (max-width: 768px) {
    .pagination-info {
        font-size: 12px;
    }
}
</style>
                        <nav>
                            <ul class="pagination">
                                {{-- Tombol "Previous" --}}
                                <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
                                    <a class="page-link arrow" 
                                    href="{{ $currentPage > 1 ? route('tables.klien', array_merge(request()->all(), ['page' => $currentPage - 1])) : '#' }}">
                                        &#x276E;
                                    </a>
                                </li>

                                {{-- Loop Halaman --}}
                                @for ($i = 1; $i <= ceil($total / $perPage); $i++)
                                    <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                                        <a class="page-link"
                                        href="{{ route('tables.klien', array_merge(request()->all(), ['page' => $i])) }}">
                                            {{ $i }}
                                        </a>
                                    </li>
                                @endfor

                                {{-- Tombol "Next" --}}
                                <li class="page-item {{ $currentPage == ceil($total / $perPage) ? 'disabled' : '' }}">
                                    <a class="page-link arrow" 
                                    href="{{ $currentPage < ceil($total / $perPage) ? route('tables.klien', array_merge(request()->all(), ['page' => $currentPage + 1])) : '#' }}">
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
let searchTimeout;

function handleSearch(event) {
    clearTimeout(searchTimeout);
    
    searchTimeout = setTimeout(() => {
        let searchQuery = event.target.value;
        let currentUrl = new URL(window.location.href);
        
        // Update search parameter
        currentUrl.searchParams.set('search', searchQuery);
        
        // Preserve other parameters
        currentUrl.searchParams.set('sort', '{{ request('sort', 'id_klien') }}');
        currentUrl.searchParams.set('direction', '{{ request('direction', 'asc') }}');
        currentUrl.searchParams.set('entries', '{{ request('entries', '10') }}');
        
        // Make the AJAX request
        fetch(currentUrl)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                
                // Update the table content with error handling
                const newTable = doc.querySelector('.table-responsive');
                const tableElement = document.querySelector('.table-responsive');
                if (newTable && tableElement) {
                    tableElement.innerHTML = newTable.innerHTML;
                }
                
                // Update pagination with error handling
                const newPagination = doc.querySelector('.pagination');
                const paginationElement = document.querySelector('.pagination');
                if (newPagination && paginationElement) {
                    paginationElement.innerHTML = newPagination.innerHTML;
                }
                
                // Update URL without page reload
                history.pushState({}, '', currentUrl);
            })
            .catch(error => console.error('Error:', error));
    }, 300);
}

// Ensure the script runs after DOM is fully loaded
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('.search-input');
    if (searchInput) {
        searchInput.addEventListener('input', handleSearch);
    }
});
</script>