@extends('layouts.app')

@section('title', 'Laporan Pemasukan')

@section('content')
<!-- Section utama untuk menampilkan laporan keuangan -->
<section id="main-content" class="col-md-12 ms-md-7">
    <div class="pencatatan-pemasukan-content">
        <div class="row">
            <div class="card shadow-sm rounded-0 py-4 px-3">
                <h4 class="mb-5 fw-bold">Laporan {{ request('jenis') == '2' ? 'Pengeluaran' : 'Pemasukan' }}</h4>

                <div class="input-form-keuangan mb-3">
                    <form action="{{ route('tables.laporanPemasukan') }}" method="GET" id="filterForm">
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <select name="jenis" class="form-select" style="width: 200px;" id="jenisSelect" onchange="this.form.submit()">
                                <option value="" class="text-secondary">Pilih Jenis</option>
                                <option value="1" {{ request('jenis') == '1' ? 'selected' : '' }}>Pemasukan</option>
                                <option value="2" {{ request('jenis') == '2' ? 'selected' : '' }}>Pengeluaran</option>
                            </select>
                            
                            <div class="d-flex align-items-center gap-3" style="width: 22%;">
    <label for="tgl_awal" class="form-label mb-0" style="white-space: nowrap;">Tanggal Awal</label>
    <div class="input-group" style="flex: 1;">
        <input name="tgl_awal" 
            type="date" 
            class="form-control" 
            id="tgl_awal"
            onfocus="this.showPicker()"
            value="{{ request('tgl_awal') }}"
            style="max-width: 200px;">
    </div>
</div>

<div class="d-flex align-items-center gap-3" style="width: 22%;">
    <label for="tgl_akhir" class="form-label mb-0" style="white-space: nowrap;">Tanggal Akhir</label>
    <div class="input-group" style="flex: 1;">
        <input name="tgl_akhir" 
            type="date" 
            class="form-control" 
            id="tgl_akhir"
            onfocus="this.showPicker()"
            value="{{ request('tgl_akhir') }}"
            style="max-width: 200px;">
    </div>
</div>

                        
                            <div class="dropdown">
                                <button class="btn-export  d-flex align-items-center gap-1" type="button" data-bs-toggle="dropdown">
                                    <i class='bx bx-export'></i>
                                    Export
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('pemasukan.export', request()->all()) }}">Excel</a></li>
                                    <li><a class="dropdown-item" href="{{ route('pemasukan.export.pdf', request()->all()) }}">PDF</a></li>
                                </ul>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Tabel Data -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="py-3 px-3" style="width: 7%;">
                                <a href="{{ route('tables.laporanPemasukan', array_merge(request()->query(), ['sort' => 'no', 'direction' => $sortField === 'no' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    No
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'no' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'no' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="py-3 px-3">
                                <a href="{{ route('tables.laporanPemasukan', array_merge(request()->query(), ['sort' => 'jenis_order', 'direction' => $sortField === 'jenis_order' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Jenis Order
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'jenis_order' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'jenis_order' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="py-3 px-3" style="width: 10%;">
                                <a href="{{ route('tables.laporanPemasukan', array_merge(request()->query(), ['sort' => 'id_order', 'direction' => $sortField === 'id_order' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    ID Order
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'id_order' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'id_order' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="py-3 px-3">
                                <a href="{{ route('tables.laporanPemasukan', array_merge(request()->query(), ['sort' => 'tgl_transaksi', 'direction' => $sortField === 'tgl_transaksi' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Tgl Transaksi
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'tgl_transaksi' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'tgl_transaksi' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="py-3 px-3" style="width: 10%;">
                                <a href="{{ route('tables.laporanPemasukan', array_merge(request()->query(), ['sort' => 'jumlah', 'direction' => $sortField === 'jumlah' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Jumlah
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'jumlah' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'jumlah' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="py-3 px-3" style="width: 10%;">
                                <a href="{{ route('tables.laporanPemasukan', array_merge(request()->query(), ['sort' => 'termin', 'direction' => $sortField === 'termin' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Termin
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'termin' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'termin' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="py-3 px-3">
                                <a href="{{ route('tables.laporanPemasukan', array_merge(request()->query(), ['sort' => 'keterangan', 'direction' => $sortField === 'keterangan' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Keterangan
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'keterangan' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'keterangan' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($projects as $laporanPemasukan)
                            <tr>
                                <td class="pt-3">{{ $laporanPemasukan->id }}</td>
                                <td class="text-start">{{ $laporanPemasukan->jenis_order }}</td>
                                <td>{{ $laporanPemasukan->id_order }}</td>
                                <td>{{ \Carbon\Carbon::parse($laporanPemasukan->tgl_transaksi ?? $laporanPemasukan->tanggal_transaksi)->format('d/m/y') }}</td>
                                <td class="text-start">Rp {{ number_format($laporanPemasukan->jumlah, 0, ',', '.') }}</td>
                                <td>{{ $laporanPemasukan->termin }}</td>
                                <td class="text-start">{{ $laporanPemasukan->keterangan }}</td>
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

<script>
document.getElementById('jenisSelect').addEventListener('change', function() {
    document.getElementById('filterForm').submit();
});
</script>

<style>
.input-form-keuangan form {
    width: 100%;
}
.input-form-keuangan .form-select,
.input-form-keuangan .input-group {
    min-width: 150px;
}
.btn-export {
    white-space: nowrap;
    padding: 6px 12px;
    background-color: #4285f4;
    color: white;
    border-radius: 4px;
    text-decoration: none;
}

</style>
