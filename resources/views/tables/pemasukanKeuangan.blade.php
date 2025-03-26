@extends('layouts.app')

@section('title', 'Data Pemasukan Keuangan')

@section('content')
<!-- Section utama untuk tampilan data pemasukan keuangan -->
<section id="main-content" class="col-md-12 ms-md-7">
    <div class="pencatatan-keuangan-content">
        <div class="row">
            <div class="card shadow-sm rounded-0 py-4 px-3">
                <h4 class="mb-3 fw-bold">Data Pemasukan Keuangan</h4>
                <hr style="background-color:#c4c4c4; height: 1px; border: none;">
                <div class="container mt-2 mb-3 p-0">
                    <div class="row">
                        <!-- Card 1: Menampilkan Sisa Kas -->
                        <div class="col-md-4 mb-3">
                            <div class="card rounded-2 text-white" style="background-color: #496FDE;">
                                <div class="card-body p-4">
                                    <h3 class="card-title fw-bold">Rp {{ number_format($sisaKas, 0, ',', '.') }}</h3>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="mb-0">Sisa Kas</p>
                                        <img src="./icon/sisa kas.svg" alt="icon" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card 2: Menampilkan Total Pemasukan -->
                        <div class="col-md-4 mb-3">
                            <div class="card rounded-2 text-white" style="background-color: #1CC588;">
                                <div class="card-body p-4">
                                    <h3 class="card-title fw-bold">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h3>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="mb-0">Total Pemasukan</p>
                                        <img src="./icon/total pemasukan.svg" alt="icon" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card 3: Menampilkan Total Pengeluaran -->
                        <div class="col-md-4 mb-3">
                            <div class="card rounded-2 text-white" style="background-color: #E74A3B;">
                                <div class="card-body p-4">
                                    <h3 class="card-title fw-bold">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h3>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="mb-0">Total Pengeluaran</p>
                                        <img src="./icon/total pengeluaran.svg" alt="icon" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Pencarian dan Filter Entires per page -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <form method="GET" id="entriesForm">
                        <div class="d-flex align-items-center">
                            <!-- Dropdown untuk memilih jumlah entri per halaman -->
                            <select class="form-select-entries entries-dropdown me-3" name="entries" onchange="document.getElementById('entriesForm').submit()">
                                <option value="10" {{ request('entries') == 10 ? 'selected' : '' }}>10</option>
                                <option value="20" {{ request('entries') == 20 ? 'selected' : '' }}>20</option>
                                <option value="50" {{ request('entries') == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('entries') == 100 ? 'selected' : '' }}>100</option>
                            </select>
                            <span class="entries-label text-secondary">entries per page</span>
                        </div>
                        <!-- Hidden Inputs untuk menjaga query parameter search dan sorting -->
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                        <input type="hidden" name="direction" value="{{ request('direction') }}">
                    </form>

                    <!-- Form untuk Pencarian -->
                    <div class="form-add d-flex">
                        <form method="GET" action="{{ route('tables.pemasukanKeuangan') }}" class="d-flex search-form" id="searchForm">
                            <div class="input-group me-2">
                                <span class="input-group-text">
                                    <i class="bx bx-search"></i>
                                </span>
                                <input 
                                    type="text" 
                                    name="search" 
                                    class="form-control search-input" 
                                    placeholder="Search..." 
                                    value="{{ request('search') }}"
                                    oninput="handleSearch(this.value)"
                                    autocomplete="off"
                                />
                            </div>
                        </form>
                        <!-- Tombol untuk menambah data pemasukan -->
                        <a href="/Tambah-Data-Pemasukan" class="btn-add fw-bold py-3 px-4">+ Tambah</a>
                    </div>
                </div>

                <!-- Tabel Data Pemasukan Keuangan -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <!-- Kolom Header untuk No (dengan fungsi sorting) -->
                            <th class="py-3 px-3" style="width: 7%;">
                                <a href="{{ route('tables.pemasukanKeuangan', array_merge(request()->query(), ['sort' => 'no', 'direction' => $sortField === 'no' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    No
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'no' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'no' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <!-- Kolom Header untuk Jenis Order -->
                            <th class="py-3 px-3">
                                <a href="{{ route('tables.pemasukanKeuangan', array_merge(request()->query(), ['sort' => 'jenis_order', 'direction' => $sortField === 'jenis_order' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Jenis Order
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'jenis_order' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'jenis_order' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <!-- Kolom Header untuk ID Order -->
                            <th class="py-3 px-3" style="width: 10%;">
                                <a href="{{ route('tables.pemasukanKeuangan', array_merge(request()->query(), ['sort' => 'id_order', 'direction' => $sortField === 'id_order' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    ID Order
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'id_order' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'id_order' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <!-- Kolom Header untuk Tanggal Transaksi -->
                            <th class="py-3 px-3">
                                <a href="{{ route('tables.pemasukanKeuangan', array_merge(request()->query(), ['sort' => 'tgl_transaksi', 'direction' => $sortField === 'tgl_transaksi' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Tgl Transaksi
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'tgl_transaksi' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'tgl_transaksi' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <!-- Kolom Header untuk Jumlah -->
                            <th class="py-3 px-3" style="width: 10%;">
                                <a href="{{ route('tables.pemasukanKeuangan', array_merge(request()->query(), ['sort' => 'jumlah', 'direction' => $sortField === 'jumlah' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Jumlah
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'jumlah' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'jumlah' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <!-- Kolom Header untuk Termin -->
                            <th class="py-3 px-3" style="width: 10%;">
                                <a href="{{ route('tables.pemasukanKeuangan', array_merge(request()->query(), ['sort' => 'termin', 'direction' => $sortField === 'termin' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Termin
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'termin' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'termin' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <!-- Kolom Header untuk Keterangan -->
                            <th class="py-3 px-3">
                                <a href="{{ route('tables.pemasukanKeuangan', array_merge(request()->query(), ['sort' => 'keterangan', 'direction' => $sortField === 'keterangan' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Keterangan
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'keterangan' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'keterangan' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <!-- Kolom Header untuk Aksi -->
                            <th class="py-3 px-3" style="width: 10%;">
                                <a href="{{ route('tables.pemasukanKeuangan', array_merge(request()->query(), ['sort' => 'aksi', 'direction' => $sortField === 'aksi' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
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
                        <!-- Loop untuk menampilkan setiap data pemasukan keuangan -->
                        @forelse($pemasukan as $pemasukanKeuangan)
                            <tr>
                                <td>{{ $pemasukanKeuangan['id'] }}</td>
                                <td class="text-start">{{ $pemasukanKeuangan['jenis_order'] }}</td>
                                <td>{{ $pemasukanKeuangan['id_order'] }}</td>
                                <td>{{ \Carbon\Carbon::parse($pemasukanKeuangan->tgl_transaksi)->format('d/m/Y') }}</td>
                                <td class="text-start">Rp {{ number_format($pemasukanKeuangan['jumlah'], 0, ',', '.') }}</td>
                                <td>{{ $pemasukanKeuangan['termin'] }}</td>
                                <td class="text-start">{{ $pemasukanKeuangan['keterangan'] }}</td>
                                <td>
                                <div class="button-container">
                                        <!-- Tombol Edit -->
                                        <a href="{{ route('pemasukan.edit', $pemasukanKeuangan['id']) }}" class="btn btn-edit">
                                            <i class="bx bx-edit"></i> Edit
                                        </a>
                                        <!-- Tombol Hapus -->
                                        <button class="btn btn-delete" data-id="{{ $pemasukanKeuangan['id'] }}">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <!-- Menampilkan pesan jika data tidak ditemukan -->
                            <tr>
                                <td colspan="8" class="text-center">Data tidak ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Navigasi Halaman (Pagination) -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="text-muted">
                            Showing {{ ($currentPage - 1) * $perPage + 1 }} to 
                            {{ min($currentPage * $perPage, $total) }} from {{ $total }} entries
                        </span>
                        <nav>
                            <ul class="pagination">
                                {{-- Tombol "Previous" --}}
                                <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
                                    <a class="page-link arrow" 
                                    href="{{ $currentPage > 1 ? route('tables.proyek', array_merge(request()->all(), ['page' => $currentPage - 1])) : '#' }}">
                                        &#x276E;
                                    </a>
                                </li>

                                {{-- Loop Halaman --}}
                                @for ($i = 1; $i <= ceil($total / $perPage); $i++)
                                    <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                                        <a class="page-link"
                                        href="{{ route('tables.proyek', array_merge(request()->all(), ['page' => $i])) }}">
                                            {{ $i }}
                                        </a>
                                    </li>
                                @endfor

                                {{-- Tombol "Next" --}}
                                <li class="page-item {{ $currentPage == ceil($total / $perPage) ? 'disabled' : '' }}">
                                    <a class="page-link arrow" 
                                    href="{{ $currentPage < ceil($total / $perPage) ? route('tables.proyek', array_merge(request()->all(), ['page' => $currentPage + 1])) : '#' }}">
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

@push('scripts')
<script>
let searchTimeout;

function handleSearch(value) {
    clearTimeout(searchTimeout);
    
    searchTimeout = setTimeout(() => {
        const currentUrl = new URL(window.location.href);
        currentUrl.searchParams.set('search', value);
        
        fetch(currentUrl.toString(), {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newTbody = doc.querySelector('tbody');
            
            if (newTbody) {
                document.querySelector('tbody').innerHTML = newTbody.innerHTML;
            }
        })
        .catch(error => console.error('Search error:', error));
    }, 300);
}
</script>
@endpush
