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
                        <div class="d-flex align-items-center gap-4">
                            <select name="reportType" class="form-select" style="max-width: 200px;" id="reportType" onchange="this.form.submit()">
                                <option value="pemasukan" {{ $reportType === 'pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                                <option value="pengeluaran" {{ $reportType === 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                            </select>

                            <div class="d-flex align-items-center gap-3" style="width: 22%;">
                                <label for="tgl_awal" class="form-label mb-0" style="white-space: nowrap;">Tanggal Awal</label>
                                <div class="input-group" style="flex: 1;">
                                    <input name="tgl_awal" 
                                        type="date" 
                                        class="form-control" 
                                        id="tglAwal"
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
                                        id="tglAkhir"
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

                <div id="pemasukanTable" class="{{ $reportType === 'pengeluaran' ? 'd-none' : '' }}">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="py-3 px-3" style="width: 7%;">
                                    <a href="{{ route('tables.laporanPemasukan', array_merge(request()->query(), ['sort' => 'id', 'direction' => $sortField === 'id' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                        No
                                        <div class="sort-icons">
                                            <i class="bx bxs-up-arrow {{ $sortField === 'id' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'id' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
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
                                <th class="py-3 px-3">
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
                                <th class="py-3 px-3">
                                    <a href="{{ route('tables.laporanPemasukan', array_merge(request()->query(), ['sort' => 'jumlah', 'direction' => $sortField === 'jumlah' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                        Jumlah
                                        <div class="sort-icons">
                                            <i class="bx bxs-up-arrow {{ $sortField === 'jumlah' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'jumlah' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                        </div>
                                    </a>
                                </th>
                                <th class="py-3 px-3">
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
                            @forelse($projects as $pemasukan)
                                <tr>
                                    <td class="pt-3">{{ $pemasukan->id }}</td>
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

                <div id="pengeluaranTable" class="{{ $reportType === 'pemasukan' ? 'd-none' : '' }}">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="py-3 px-3" style="width: 7%;">
                                    <a href="{{ route('tables.laporanPemasukan', array_merge(request()->query(), ['sort' => 'id', 'direction' => $sortField === 'id' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                        No
                                        <div class="sort-icons">
                                            <i class="bx bxs-up-arrow {{ $sortField === 'id' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'id' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                        </div>
                                    </a>
                                </th>
                                <th class="py-3 px-3">
                                    <a href="{{ route('tables.laporanPemasukan', array_merge(request()->query(), ['sort' => 'tanggal_transaksi', 'direction' => $sortField === 'tanggal_transaksi' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                        Tanggal Transaksi
                                        <div class="sort-icons">
                                            <i class="bx bxs-up-arrow {{ $sortField === 'tanggal_transaksi' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'tanggal_transaksi' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                        </div>
                                    </a>
                                </th>
                                <th class="py-3 px-3">
                                    <a href="{{ route('tables.laporanPemasukan', array_merge(request()->query(), ['sort' => 'nama_barang', 'direction' => $sortField === 'nama_barang' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                        Nama Barang
                                        <div class="sort-icons">
                                            <i class="bx bxs-up-arrow {{ $sortField === 'nama_barang' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'nama_barang' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                        </div>
                                    </a>
                                </th>
                                <th class="py-3 px-3">
                                    <a href="{{ route('tables.laporanPemasukan', array_merge(request()->query(), ['sort' => 'jumlah', 'direction' => $sortField === 'jumlah' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                        Jumlah
                                        <div class="sort-icons">
                                            <i class="bx bxs-up-arrow {{ $sortField === 'jumlah' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'jumlah' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                        </div>
                                    </a>
                                </th>
                                <th class="py-3 px-3">
                                    <a href="{{ route('tables.laporanPemasukan', array_merge(request()->query(), ['sort' => 'harga_satuan', 'direction' => $sortField === 'harga_satuan' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                        Harga Satuan
                                        <div class="sort-icons">
                                            <i class="bx bxs-up-arrow {{ $sortField === 'harga_satuan' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'harga_satuan' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                        </div>
                                    </a>
                                </th>
                                <th class="py-3 px-3">
                                    <a href="{{ route('tables.laporanPemasukan', array_merge(request()->query(), ['sort' => 'total_harga', 'direction' => $sortField === 'total_harga' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                        Total Harga
                                        <div class="sort-icons">
                                            <i class="bx bxs-up-arrow {{ $sortField === 'total_harga' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'total_harga' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
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
                            @forelse($projects as $pengeluaran)
                                <tr>
                                    <td class="pt-3">{{ $pengeluaran->id }}</td>
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

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <span class="text-muted">
                        Showing {{ ($currentPage - 1) * $perPage + 1 }} to 
                        {{ min($currentPage * $perPage, $total) }} from {{ $total }} entries
                    </span>
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
