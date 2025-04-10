@extends('layouts.app')

@section('title', 'Laporan Keuangan')

@section('content')
<section id="main-content" class="col-md-12 ms-md-7">
    <div class="pencatatan-proyek-content">
        <div class="row">
            <div class="card shadow-sm rounded-0 py-4 px-3">
                <h4 class="mb-4 fw-bold">Laporan {{ $reportType === 'pengeluaran' ? 'Pengeluaran' : 'Pemasukan' }}</h4>

                <div class="input-form-keuangan mb-3">
                    <form action="{{ route('tables.laporanPemasukan') }}" method="GET" id="filterForm">
                        <div class="d-flex align-items-center gap-4 flex-wrap">
                            <select name="reportType" class="form-select" style="min-width: 150px; max-width: 200px;" id="reportType" onchange="this.form.submit()">
                                <option value="pemasukan" {{ $reportType === 'pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                                <option value="pengeluaran" {{ $reportType === 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                            </select>

                            <div class="d-flex align-items-center gap-2" style="min-width: 250px;">
                                <label for="tgl_awal" class="form-label mb-0 me-2" style="white-space: nowrap;">Tanggal Awal</label>
                                <div class="input-group" style="width: auto;">
                                    <input name="tgl_awal" 
                                        type="date" 
                                        class="form-control" 
                                        id="tglAwal"
                                        onfocus="this.showPicker()"
                                        value="{{ request('tgl_awal') }}"
                                        style="">
                                </div>
                            </div>

                            <div class="d-flex align-items-center gap-2" style="min-width: 250px;">
                                <label for="tgl_akhir" class="form-label mb-0 me-2" style="white-space: nowrap;">Tanggal Akhir</label>
                                <div class="input-group" style="width: auto;">
                                    <input name="tgl_akhir" 
                                        type="date" 
                                        class="form-control" 
                                        id="tglAkhir"
                                        onfocus="this.showPicker()"
                                        value="{{ request('tgl_akhir') }}"
                                        style="">
                                </div>
                            </div>

                            <div class="dropdown">
                                <button class="btn-add fw-bold d-flex align-items-center gap-1" type="button" data-bs-toggle="dropdown" style="font-size: 14px; height: 38px; padding: 0.375rem 0.75rem;">
                                    <i class='bx bx-export' style="font-size: 16px;"></i>
                                    Export
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" onclick="exportData('excel')">Excel</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="exportData('pdf')">PDF</a></li>
                                </ul>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Add table-responsive wrapper around both tables -->
                <div id="pemasukanTable" class="{{ $reportType === 'pengeluaran' ? 'd-none' : '' }}">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="py-3 px-3" style="width: 7%;">
                                        <a href="{{ route('tables.laporanPemasukan', array_merge(request()->query(), ['sort' => 'no', 'direction' => $sortField === 'no' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                            No
                                            <div class="sort-icons">
                                                <i class="bx bxs-up-arrow {{ $sortField === 'no' && $sortDirection === 'asc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                                <i class="bx bxs-down-arrow {{ $sortField === 'no' && $sortDirection === 'desc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                            </div>
                                        </a>
                                    </th>
                                    <th class="py-3 px-3">
                                        <a href="{{ route('tables.laporanPemasukan', array_merge(request()->query(), ['sort' => 'jenis_order', 'direction' => $sortField === 'jenis_order' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                            Jenis Order
                                            <div class="sort-icons">
                                                <i class="bx bxs-up-arrow {{ $sortField === 'jenis_order' && $sortDirection === 'asc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                                <i class="bx bxs-down-arrow {{ $sortField === 'jenis_order' && $sortDirection === 'desc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                            </div>
                                        </a>
                                    </th>
                                    <th class="py-3 px-3" style="width: 120px">
                                        <a href="{{ route('tables.laporanPemasukan', array_merge(request()->query(), ['sort' => 'id_order', 'direction' => $sortField === 'id_order' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                            ID Order
                                            <div class="sort-icons">
                                                <i class="bx bxs-up-arrow {{ $sortField === 'id_order' && $sortDirection === 'asc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                                <i class="bx bxs-down-arrow {{ $sortField === 'id_order' && $sortDirection === 'desc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                            </div>
                                        </a>
                                    </th>
                                    <th class="py-3 px-3">
                                        <a href="{{ route('tables.laporanPemasukan', array_merge(request()->query(), ['sort' => 'tgl_transaksi', 'direction' => $sortField === 'tgl_transaksi' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                            Tgl Transaksi
                                            <div class="sort-icons">
                                                <i class="bx bxs-up-arrow {{ $sortField === 'tgl_transaksi' && $sortDirection === 'asc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                                <i class="bx bxs-down-arrow {{ $sortField === 'tgl_transaksi' && $sortDirection === 'desc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                            </div>
                                        </a>
                                    </th>
                                    <th class="py-3 px-3">
                                        <a href="{{ route('tables.laporanPemasukan', array_merge(request()->query(), ['sort' => 'jumlah', 'direction' => $sortField === 'jumlah' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                            Jumlah
                                            <div class="sort-icons">
                                                <i class="bx bxs-up-arrow {{ $sortField === 'jumlah' && $sortDirection === 'asc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                                <i class="bx bxs-down-arrow {{ $sortField === 'jumlah' && $sortDirection === 'desc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                            </div>
                                        </a>
                                    </th>
                                    <th class="py-3 px-3" style="width: 120px">
                                        <a href="{{ route('tables.laporanPemasukan', array_merge(request()->query(), ['sort' => 'termin', 'direction' => $sortField === 'termin' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                            Termin
                                            <div class="sort-icons">
                                                <i class="bx bxs-up-arrow {{ $sortField === 'termin' && $sortDirection === 'asc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                                <i class="bx bxs-down-arrow {{ $sortField === 'termin' && $sortDirection === 'desc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                            </div>
                                        </a>
                                    </th>
                                    <th class="py-3 px-3">
                                        <a href="{{ route('tables.laporanPemasukan', array_merge(request()->query(), ['sort' => 'keterangan', 'direction' => $sortField === 'keterangan' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                            Keterangan
                                            <div class="sort-icons">
                                                <i class="bx bxs-up-arrow {{ $sortField === 'keterangan' && $sortDirection === 'asc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                                <i class="bx bxs-down-arrow {{ $sortField === 'keterangan' && $sortDirection === 'desc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                            </div>
                                        </a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($projects as $index => $pemasukan)
                                    <tr>
                                        <td class="pt-3">{{ ($currentPage - 1) * $perPage + $index + 1 }}</td>
                                        <td class="text-start">{{ $pemasukan->jenis_order }}</td>
                                        <td>{{ $pemasukan->id_order }}</td>
                                        <td>{{ $pemasukan->tanggal_transaksi }}</td>
                                        <td class="text-start">Rp {{ number_format($pemasukan->jumlah, 0, ',', '.') }}</td>
                                        <td>{{ $pemasukan->termin }}</td>
                                        <td class="text-start">{{ $pemasukan->keterangan }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Data tidak ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="pengeluaranTable" class="{{ $reportType === 'pemasukan' ? 'd-none' : '' }}">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="py-3 px-3" style="width: 7%;">
                                        <a href="{{ route('tables.laporanPemasukan', array_merge(request()->query(), ['sort' => 'no', 'direction' => $sortField === 'no' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                            No
                                            <div class="sort-icons">
                                                <i class="bx bxs-up-arrow {{ $sortField === 'no' && $sortDirection === 'asc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                                <i class="bx bxs-down-arrow {{ $sortField === 'no' && $sortDirection === 'desc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                            </div>
                                        </a>
                                    </th>
                                    <th class="py-3 px-3">
                                        <a href="{{ route('tables.laporanPemasukan', array_merge(request()->query(), ['sort' => 'tanggal_transaksi', 'direction' => $sortField === 'tanggal_transaksi' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                            Tanggal Transaksi
                                            <div class="sort-icons">
                                                <i class="bx bxs-up-arrow {{ $sortField === 'tanggal_transaksi' && $sortDirection === 'asc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                                <i class="bx bxs-down-arrow {{ $sortField === 'tanggal_transaksi' && $sortDirection === 'desc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                            </div>
                                        </a>
                                    </th>
                                    <th class="py-3 px-3">
                                        <a href="{{ route('tables.laporanPemasukan', array_merge(request()->query(), ['sort' => 'nama_barang', 'direction' => $sortField === 'nama_barang' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                            Nama Barang
                                            <div class="sort-icons">
                                                <i class="bx bxs-up-arrow {{ $sortField === 'nama_barang' && $sortDirection === 'asc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                                <i class="bx bxs-down-arrow {{ $sortField === 'nama_barang' && $sortDirection === 'desc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                            </div>
                                        </a>
                                    </th>
                                    <th class="py-3 px-3">
                                        <a href="{{ route('tables.laporanPemasukan', array_merge(request()->query(), ['sort' => 'jumlah', 'direction' => $sortField === 'jumlah' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                            Jumlah
                                            <div class="sort-icons">
                                                <i class="bx bxs-up-arrow {{ $sortField === 'jumlah' && $sortDirection === 'asc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                                <i class="bx bxs-down-arrow {{ $sortField === 'jumlah' && $sortDirection === 'desc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                            </div>
                                        </a>
                                    </th>
                                    <th class="py-3 px-3">
                                        <a href="{{ route('tables.laporanPemasukan', array_merge(request()->query(), ['sort' => 'harga_satuan', 'direction' => $sortField === 'harga_satuan' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                            Harga Satuan
                                            <div class="sort-icons">
                                                <i class="bx bxs-up-arrow {{ $sortField === 'harga_satuan' && $sortDirection === 'asc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                                <i class="bx bxs-down-arrow {{ $sortField === 'harga_satuan' && $sortDirection === 'desc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                            </div>
                                        </a>
                                    </th>
                                    <th class="py-3 px-3">
                                        <a href="{{ route('tables.laporanPemasukan', array_merge(request()->query(), ['sort' => 'total_harga', 'direction' => $sortField === 'total_harga' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                            Total Harga
                                            <div class="sort-icons">
                                                <i class="bx bxs-up-arrow {{ $sortField === 'total_harga' && $sortDirection === 'asc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                                <i class="bx bxs-down-arrow {{ $sortField === 'total_harga' && $sortDirection === 'desc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                            </div>
                                        </a>
                                    </th>
                                    <th class="py-3 px-3">
                                        <a href="{{ route('tables.laporanPemasukan', array_merge(request()->query(), ['sort' => 'keterangan', 'direction' => $sortField === 'keterangan' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                            Keterangan
                                            <div class="sort-icons">
                                                <i class="bx bxs-up-arrow {{ $sortField === 'keterangan' && $sortDirection === 'asc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                                <i class="bx bxs-down-arrow {{ $sortField === 'keterangan' && $sortDirection === 'desc' ? 'active' : 'inactive' }}" style="font-size: 9px;"></i>
                                            </div>
                                        </a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($projects as $index => $pengeluaran)
                                    <tr>
                                        <td class="pt-3">{{ ($currentPage - 1) * $perPage + $index + 1 }}</td>
                                        <td>{{ $pengeluaran->tanggal_transaksi }}</td>
                                        <td class="text-start">{{ $pengeluaran->nama_barang }}</td>
                                        <td>{{ $pengeluaran->jumlah }}</td>
                                        <td class="text-start">Rp {{ $pengeluaran->harga_satuan }}</td>
                                        <td class="text-start">Rp {{ $pengeluaran->total_harga }}</td>
                                        <td class="text-start">{{ $pengeluaran->keterangan }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Data tidak ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Add these styles -->
                @push('styles')
                <style>
                    .header-link {
                        text-decoration: none;
                    }
                    .sort-icons {
                        display: inline-flex;
                        flex-direction: column;
                        margin-left: 5px;
                        line-height: 0.5;
                    }
                    .sort-icons i.active {
                        color: #fff;
                    }
                    .sort-icons i.inactive {
                        color: rgba(255, 255, 255, 0.5);
                    }
                    /* Add these new styles */
                    .table-responsive {
                        overflow-x: auto;
                        -webkit-overflow-scrolling: touch;
                    }
                    .table {
                        min-width: 800px; /* Ensures table maintains minimum width on mobile */
                    }
                </style>
                @endpush

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
                            <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
                                <a class="page-link arrow" 
                                href="{{ $currentPage > 1 ? route('tables.laporanPemasukan', array_merge(request()->all(), ['page' => $currentPage - 1])) : '#' }}">
                                    &#x276E;
                                </a>
                            </li>

                            @for ($i = 1; $i <= ceil($total / $perPage); $i++)
                                <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                                    <a class="page-link"
                                    href="{{ route('tables.laporanPemasukan', array_merge(request()->all(), ['page' => $i])) }}">
                                        {{ $i }}
                                    </a>
                                </li>
                            @endfor

                            <li class="page-item {{ $currentPage == ceil($total / $perPage) ? 'disabled' : '' }}">
                                <a class="page-link arrow" 
                                href="{{ $currentPage < ceil($total / $perPage) ? route('tables.laporanPemasukan', array_merge(request()->all(), ['page' => $currentPage + 1])) : '#' }}">
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

@push('styles')
<style>
    .header-link {
        text-decoration: none;
    }
    .sort-icons {
        display: inline-flex;
        flex-direction: column;
        margin-left: 5px;
        line-height: 0.5;
    }
    .sort-icons i.active {
        color: #fff;
    }
    .sort-icons i.inactive {
        color: rgba(255, 255, 255, 0.5);
    }
</style>
@endpush

@push('scripts')
<script>
    function exportData(type) {
        const tglAwal = document.getElementById('tglAwal').value;
        const tglAkhir = document.getElementById('tglAkhir').value;
        const reportType = document.getElementById('reportType').value;
        
        if (type === 'pdf') {
            // Open PDF preview in new tab
            window.open(`{{ route('pemasukan.export.pdf') }}?type=${type}&reportType=${reportType}&tgl_awal=${tglAwal}&tgl_akhir=${tglAkhir}&preview=true`, '_blank');
        } else {
            // Direct download for Excel
            window.location.href = `{{ route('pemasukan.export.pdf') }}?type=${type}&reportType=${reportType}&tgl_awal=${tglAwal}&tgl_akhir=${tglAkhir}`;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const filterForm = document.getElementById('filterForm');
        const tglAwal = document.getElementById('tglAwal');
        const tglAkhir = document.getElementById('tglAkhir');
        
        tglAwal.addEventListener('input', function() {
            if (tglAkhir.value) {
                filterForm.submit();
            }
        });
        
        tglAkhir.addEventListener('input', function() {
            if (tglAwal.value) {
                filterForm.submit();
            }
        });
    });
</script>
@endpush
