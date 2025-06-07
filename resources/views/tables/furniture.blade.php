@extends('layouts.app')

@section('title', 'Pencatatan Proyek')

@section('content')
<!-- Section utama untuk menampilkan pencatatan furniture -->
<section id="main-content" class="col-md-12 ms-md-7">
    <div class="pencatatan-furniture-content">
        <div class="row">
            <div class="card shadow-sm rounded-0 py-4 px-3">
                <h4 class="mb-4 fw-bold">Pencatatan Furniture</h4>
                
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

                    <div class="form-add d-flex flex-wrap w-md-auto">
                        <form method="GET" action="{{ route('tables.furniture') }}" class="d-flex search-form flex-grow-1 me-md-2 mb-2 mb-md-0" id="searchForm">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-search"></i></span>
                                <input type="text" name="search" class="form-control search-input" placeholder="Search..." value="{{ request('search') }}" onkeyup="handleSearch(event)" style="margin: 5px;"/>
                            </div>
                        </form>
                        <a href="/Tambah-Data-Furniture" class="btn-add fw-bold px-3"  style="padding-top:12px;">+ Tambah</a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <!-- Kolom untuk ID Furniture dengan pengurutan -->
                                <th class="py-3 px-3" style="width: 11%;">
                                    <a href="{{ route('tables.furniture', array_merge(request()->query(), ['sort' => 'id_furniture', 'direction' => $sortField === 'id_furniture' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                        Id Furniture
                                        <div class="sort-icons pl-24">
                                            <i class="bx bxs-up-arrow {{ $sortField === 'id_furniture' && $sortDirection === 'asc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'id_furniture' && $sortDirection === 'desc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                        </div>
                                    </a>
                                </th>
                                <!-- Kolom untuk Tanggal Pembuatan dengan pengurutan -->
                                <th class="py-3 px-3" style="width: 13%;">
                                    <a href="{{ route('tables.furniture', array_merge(request()->query(), ['sort' => 'tgl_pembuatan', 'direction' => $sortField === 'tgl_pembuatan' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                        Tgl Pembuatan
                                        <div class="sort-icons">
                                            <i class="bx bxs-up-arrow {{ $sortField === 'tgl_pembuatan' && $sortDirection === 'asc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'tgl_pembuatan' && $sortDirection === 'desc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                        </div>
                                    </a>
                                </th>
                                <!-- Kolom untuk Nama Furniture dengan pengurutan -->
                                <th class="py-3 px-3">
                                    <a href="{{ route('tables.furniture', array_merge(request()->query(), ['sort' => 'nama_furniture', 'direction' => $sortField === 'nama_furniture' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                        Nama Furniture
                                        <div class="sort-icons">
                                            <i class="bx bxs-up-arrow {{ $sortField === 'nama_furniture' && $sortDirection === 'asc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'nama_furniture' && $sortDirection === 'desc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                        </div>
                                    </a>
                                </th>
                                <!-- Kolom untuk Jumlah Unit dengan pengurutan -->
                                <th class="py-3 px-3" style="width: 11%;">
                                    <a href="{{ route('tables.furniture', array_merge(request()->query(), ['sort' => 'jumlah_unit', 'direction' => $sortField === 'jumlah_unit' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                        Jumlah Unit
                                        <div class="sort-icons">
                                            <i class="bx bxs-up-arrow {{ $sortField === 'jumlah_unit' && $sortDirection === 'asc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'jumlah_unit' && $sortDirection === 'desc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                        </div>
                                    </a>
                                </th>
                                <!-- Kolom untuk Harga Unit dengan pengurutan -->
                                <th class="py-3 px-3" style="width: 12%;">
                                    <a href="{{ route('tables.furniture', array_merge(request()->query(), ['sort' => 'harga_unit', 'direction' => $sortField === 'harga_unit' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                        Harga Unit
                                        <div class="sort-icons">
                                            <i class="bx bxs-up-arrow {{ $sortField === 'harga_unit' && $sortDirection === 'asc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'harga_unit' && $sortDirection === 'desc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                        </div>
                                    </a>
                                </th>
                                <!-- Kolom untuk Lokasi dengan pengurutan -->
                                <th class="py-3 px-3">
                                    <a href="{{ route('tables.furniture', array_merge(request()->query(), ['sort' => 'lokasi', 'direction' => $sortField === 'lokasi' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                        Lokasi
                                        <div class="sort-icons">
                                            <i class="bx bxs-up-arrow {{ $sortField === 'lokasi' && $sortDirection === 'asc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'lokasi' && $sortDirection === 'desc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                        </div>
                                    </a>
                                </th>
                                <!-- Kolom untuk Tanggal Selesai dengan pengurutan -->
                                <th class="py-3 px-3" style="width: 11%;">
                                    <a href="{{ route('tables.furniture', array_merge(request()->query(), ['sort' => 'tgl_selesai', 'direction' => $sortField === 'tgl_selesai' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                        Tgl Selesai
                                        <div class="sort-icons">
                                            <i class="bx bxs-up-arrow {{ $sortField === 'tgl_selesai' && $sortDirection === 'asc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'tgl_selesai' && $sortDirection === 'desc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                        </div>
                                    </a>
                                </th>
                                <!-- Kolom untuk Aksi -->
                                <th class="py-3 px-3" style="width: 10%;">
                                    <a class="text-white header-link">
                                        Aksi
                                        <div class="sort-icons">
                                            <i class="bx bxs-up-arrow {{ $sortField === 'aksi' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"style="font-size: 9px;"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'aksi' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"style="font-size: 9px;"></i>
                                        </div>
                                    </a>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($furnitures as $furniture)
                            <tr>
                                <td>{{ $furniture->id_furniture }}</td>
                                <td>{{ \Carbon\Carbon::parse($furniture->tgl_pembuatan)->format('d/m/Y') }}</td>
                                <td class="text-start">{{ $furniture->nama_furniture }}</td>
                                <td>{{ $furniture->jumlah_unit }}</td>
                                <td>Rp {{ number_format($furniture->harga_unit, 0, ',', '.') }}</td>
                                <td class="text-start">{{ $furniture->lokasi }}</td>
                                <td>{{ \Carbon\Carbon::parse($furniture->tgl_selesai)->format('d/m/Y') }}</td>
                                <td>
                                    <div class="button-container">
                                        <a href="{{ route('furniture.edit', $furniture->id) }}" class="btn btn-edit">
                                            <i class="bx bx-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('furniture.destroy', $furniture->id) }}" method="POST" class="d-inline">
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
                                <td colspan="8" class="text-center">Data tidak ditemukan.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination section with responsive classes -->
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
                                        href="{{ $currentPage > 1 ? route('tables.furniture', array_merge(request()->all(), ['page' => $currentPage - 1])) : '#' }}">
                                            &#x276E;
                                        </a>
                                    </li>

                                    {{-- Loop Halaman --}}
                                    @for ($i = 1; $i <= ceil($total / $perPage); $i++)
                                        <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                                            <a class="page-link"
                                            href="{{ route('tables.furniture', array_merge(request()->all(), ['page' => $i])) }}">
                                                {{ $i }}
                                            </a>
                                        </li>
                                    @endfor

                                    {{-- Tombol "Next" --}}
                                    <li class="page-item {{ $currentPage == ceil($total / $perPage) ? 'disabled' : '' }}">
                                        <a class="page-link arrow" 
                                        href="{{ $currentPage < ceil($total / $perPage) ? route('tables.furniture', array_merge(request()->all(), ['page' => $currentPage + 1])) : '#' }}">
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
function handleSearch(event) {
    event.preventDefault(); // Menghindari submit otomatis
    let searchQuery = event.target.value;
    let url = new URL(window.location.href);
    url.searchParams.set('search', searchQuery);
    history.pushState({}, '', url); // Memperbarui URL tanpa reload

    // Panggil AJAX untuk mengambil hasil pencarian tanpa refresh
    fetch(url)
        .then(response => response.text())
        .then(html => {
            let parser = new DOMParser();
            let doc = parser.parseFromString(html, 'text/html');
            let newTable = doc.querySelector('table');
            document.querySelector('table').replaceWith(newTable);
        });
}
</script>
