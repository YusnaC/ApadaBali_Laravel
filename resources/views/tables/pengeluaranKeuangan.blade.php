@extends('layouts.app')

@section('title', 'Data Pengeluaran Keuangan')

@section('content')
<!-- Bagian utama konten -->
<section id="main-content" class="col-md-12 ms-md-7">
    <div class="pencatatan-keuangan-content">
        <div class="row">
            <!-- Card untuk menampilkan data keuangan (Sisa Kas, Total Pemasukan, dan Total Pengeluaran) -->
            <div class="card shadow-sm rounded-0 py-4 px-3">
                <h4 class="mb-3 fw-bold">Data Pengeluaran Keuangan</h4>
                <hr style="background-color:#c4c4c4; height: 1px; border: none;">
                <div class="container mt-2 mb-3 p-0">
                    <div class="row">
                        <!-- Card Sisa Kas -->
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
                        <!-- Card Total Pemasukan -->
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
                        <!-- Card Total Pengeluaran -->
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

                <style>
                    @media (min-width: 992px) {
                        .sidebar-hidden .container {
                            max-width: 1551px !important;
                        }
                    }
                </style>

                <!-- Dropdown untuk memilih jumlah entries per page dan form pencarian -->
                    

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
                        <form method="GET" action="{{ route('tables.pengeluaranKeuangan') }}" class="d-flex search-form flex-grow-1 me-md-2 mb-2 mb-md-0">
                            <div class="input-group">
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
                                    style="margin:5px;"
                                />
                            </div>
                        </form>
                        <a href="/Tambah-Data-Pengeluaran" class="btn-add fw-bold px-3" style="padding-top:12px; ">+ Tambah</a>
                    </div>
                </div>

                <!-- Tabel untuk menampilkan data pengeluaran -->
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <!-- Header tabel dengan fungsionalitas sorting -->
                                <th class="py-3 px-3" style="width: 7%;">
                                    <a href="{{ route('tables.pengeluaranKeuangan', array_merge(request()->query(), ['sort' => 'no', 'direction' => $sortField === 'no' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                        No
                                        <div class="sort-icons">
                                            <i class="bx bxs-up-arrow {{ $sortField === 'no' && $sortDirection === 'asc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'no' && $sortDirection === 'desc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                        </div>
                                    </a>
                                </th>
                                <th class="py-3 px-3" style="width: 12%;">
                                    <a href="{{ route('tables.pengeluaranKeuangan', array_merge(request()->query(), ['sort' => 'tanggal_transaksi', 'direction' => $sortField === 'tanggal_transaksi' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                        Tgl Transaksi
                                        <div class="sort-icons">
                                            <i class="bx bxs-up-arrow {{ $sortField === 'tanggal_transaksi' && $sortDirection === 'asc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'tanggal_transaksi' && $sortDirection === 'desc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                        </div>
                                    </a>
                                </th>
                                <th class="py-3 px-3">
                                    <a href="{{ route('tables.pengeluaranKeuangan', array_merge(request()->query(), ['sort' => 'nama_barang', 'direction' => $sortField === 'nama_barang' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                        Nama Barang
                                        <div class="sort-icons">
                                            <i class="bx bxs-up-arrow {{ $sortField === 'nama_barang' && $sortDirection === 'asc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'nama_barang' && $sortDirection === 'desc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                        </div>
                                    </a>
                                </th>
                                <th class="py-3 px-3" style="width: 10%;">
                                    <a href="{{ route('tables.pengeluaranKeuangan', array_merge(request()->query(), ['sort' => 'jumlah', 'direction' => $sortField === 'jumlah' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                        Jumlah
                                        <div class="sort-icons">
                                            <i class="bx bxs-up-arrow {{ $sortField === 'jumlah' && $sortDirection === 'asc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'jumlah' && $sortDirection === 'desc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                        </div>
                                    </a>
                                </th>
                                <th class="py-3 px-3">
                                    <a href="{{ route('tables.pengeluaranKeuangan', array_merge(request()->query(), ['sort' => 'harga_satuan', 'direction' => $sortField === 'harga_satuan' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                        Harga Satuan
                                        <div class="sort-icons">
                                            <i class="bx bxs-up-arrow {{ $sortField === 'harga_satuan' && $sortDirection === 'asc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'harga_satuan' && $sortDirection === 'desc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                        </div>
                                    </a>
                                </th>
                                <th class="py-3 px-3">
                                    <a href="{{ route('tables.pengeluaranKeuangan', array_merge(request()->query(), ['sort' => 'total_harga', 'direction' => $sortField === 'total_harga' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                        Total Harga
                                        <div class="sort-icons">
                                            <i class="bx bxs-up-arrow {{ $sortField === 'total_harga' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"  style="font-size: 9px;"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'total_harga' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"  style="font-size: 9px;"></i>
                                        </div>
                                    </a>
                                </th>
                                <th class="py-3 px-3">
                                    <a href="{{ route('tables.pengeluaranKeuangan', array_merge(request()->query(), ['sort' => 'keterangan', 'direction' => $sortField === 'keterangan' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                        Keterangan
                                        <div class="sort-icons">
                                            <i class="bx bxs-up-arrow {{ $sortField === 'keterangan' && $sortDirection === 'asc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'keterangan' && $sortDirection === 'desc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
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

                        <!-- Bagian tubuh tabel yang menampilkan data -->
                        <tbody>
                            <!-- Loop untuk menampilkan data pengeluaran -->
                            @forelse($projects as $index => $pengeluaranKeuangan)
                                <tr class="p-2">
                                    <td class=" p-2">{{ ($currentPage - 1) * $perPage + $index + 1 }}</td>
                                    <td>{{ \Carbon\Carbon::parse($pengeluaranKeuangan['tanggal_transaksi'])->format('d/m/Y') }}</td>
                                    <td class="text-start">{{ $pengeluaranKeuangan['nama_barang'] }}</td>
                                    <td>{{ $pengeluaranKeuangan['jumlah'] }}</td>
                                    <td class="text-start">Rp {{ number_format($pengeluaranKeuangan['harga_satuan'], 0, ',', '.') }}</td>
                                    <td class="text-start">Rp {{ number_format($pengeluaranKeuangan['total_harga'], 0, ',', '.') }}</td>
                                    <td class="text-start">{{ $pengeluaranKeuangan['keterangan'] }}</td>
                                    <!-- Tombol aksi (Edit/Hapus) untuk setiap entri -->
                                    <td>
                                        <div class="button-container">
                                            <a href="{{ route('pengeluaran.edit', $pengeluaranKeuangan['id']) }}" 
                                               class="btn btn-edit">
                                                <i class="bx bx-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('pengeluaran.destroy', $pengeluaranKeuangan['id']) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
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
                                <!-- Jika tidak ada data ditemukan, tampilkan pesan -->
                                <tr>
                                    <td colspan="8" class="text-center">Data tidak ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Kontrol pagination -->
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
                                {{-- Previous Button --}}
                                <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
                                    <a class="page-link arrow" 
                                    href="{{ $currentPage > 1 ? route('tables.pengeluaranKeuangan', array_merge(request()->all(), ['page' => $currentPage - 1])) : '#' }}">
                                        &#x276E;
                                    </a>
                                </li>

                                {{-- Page Numbers --}}
                                @for ($i = 1; $i <= ceil($total / $perPage); $i++)
                                    <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                                        <a class="page-link"
                                        href="{{ route('tables.pengeluaranKeuangan', array_merge(request()->all(), ['page' => $i])) }}">
                                            {{ $i }}
                                        </a>
                                    </li>
                                @endfor

                                {{-- Next Button --}}
                                <li class="page-item {{ $currentPage == ceil($total / $perPage) ? 'disabled' : '' }}">
                                    <a class="page-link arrow" 
                                    href="{{ $currentPage < ceil($total / $perPage) ? route('tables.pengeluaranKeuangan', array_merge(request()->all(), ['page' => $currentPage + 1])) : '#' }}">
                                        &#x276F;
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
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
            const paginationInfo = doc.querySelector('.d-flex.justify-content-between.align-items-center.mt-3');
            
            if (newTbody) {
                document.querySelector('tbody').innerHTML = newTbody.innerHTML;
                // Update pagination info if it exists
                if (paginationInfo) {
                    document.querySelector('.d-flex.justify-content-between.align-items-center.mt-3').innerHTML = paginationInfo.innerHTML;
                }
            }
        })
        .catch(error => console.error('Search error:', error));
    }, 300);
}
</script>
@endpush