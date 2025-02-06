@extends('layouts.app')

@section('title', 'laporan Pengeluaran')

@section('content')
<section id="main-content" class="col-md-12 ms-md-7">
    <div class="pencatatan-pengeluaran-content">
        <div class="row">
            <div class="card shadow-sm rounded-0 py-4 px-3">
                <h4 class="mb-5 fw-bold">Laporan Keuangan</h4>

                <div class="input-form-Pengeluaran mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <select class="form-select" style="max-width: 200px;">
                            <option selected class="text-secondary" disabled>Pilih Jenis</option>
                            <option value="1">Pemasukan</option>
                            <option value="2">Pengeluaran</option>
                        </select>
                        
                        <div class="input-group" style="max-width: 150px;"> 
                            <input type="text" class="form-control" placeholder="Tgl awal" onfocus="(this.type='date')" onblur="(this.type='text')">
                            <span class="input-group-text"><i class='bx bx-calendar'></i></span>
                        </div>
            
                        <div class="input-group" style="max-width: 150px;">
                            <input type="text" class="form-control" placeholder="Tgl akhir" onfocus="(this.type='date')" onblur="(this.type='text')">
                            <span class="input-group-text"><i class='bx bx-calendar'></i></span>
                        </div>
                        
                        <button class="btn-export d-flex align-items-center gap-1">
                            <i class='bx bx-export'></i>
                            Export
                        </button>
                    </div>
                </div>

                <table class="table table-bordered">
                <thead>
                <tr>
                    <th class="py-3 px-3" style="width: 7%;">
                        <a href="{{ route('tables.laporanPengeluaran', array_merge(request()->query(), ['sort' => 'no', 'direction' => $sortField === 'no' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                            No
                            <div class="sort-icons">
                                <i class="bx bxs-up-arrow {{ $sortField === 'no' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                <i class="bx bxs-down-arrow {{ $sortField === 'no' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                            </div>
                        </a>
                    </th>
                    <th class="py-3 px-3" style="width: 12%;">
                        <a href="{{ route('tables.laporanPengeluaran', array_merge(request()->query(), ['sort' => 'tanggal_transaksi', 'direction' => $sortField === 'tanggal_transaksi' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                            Tgl Transaksi
                            <div class="sort-icons">
                                <i class="bx bxs-up-arrow {{ $sortField === 'tanggal_transaksi' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                <i class="bx bxs-down-arrow {{ $sortField === 'tanggal_transaksi' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                            </div>
                        </a>
                    </th>
                    <th class="py-3 px-3">
                        <a href="{{ route('tables.laporanPengeluaran', array_merge(request()->query(), ['sort' => 'nama_barang', 'direction' => $sortField === 'nama_barang' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                            Nama Barang
                            <div class="sort-icons">
                                <i class="bx bxs-up-arrow {{ $sortField === 'nama_barang' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                <i class="bx bxs-down-arrow {{ $sortField === 'nama_barang' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                            </div>
                        </a>
                    </th>
                    <th class="py-3 px-3" style="width: 10%;">
                        <a href="{{ route('tables.laporanPengeluaran', array_merge(request()->query(), ['sort' => 'jumlah', 'direction' => $sortField === 'jumlah' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                            Jumlah
                            <div class="sort-icons">
                                <i class="bx bxs-up-arrow {{ $sortField === 'jumlah' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                <i class="bx bxs-down-arrow {{ $sortField === 'jumlah' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                            </div>
                        </a>
                    </th>
                    <th class="py-3 px-3" style="width: 14%;">
                        <a href="{{ route('tables.laporanPengeluaran', array_merge(request()->query(), ['sort' => 'harga_satuan', 'direction' => $sortField === 'harga_satuan' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                            Harga Satuan
                            <div class="sort-icons">
                                <i class="bx bxs-up-arrow {{ $sortField === 'harga_satuan' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                <i class="bx bxs-down-arrow {{ $sortField === 'harga_satuan' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                            </div>
                        </a>
                    </th>
                    <th class="py-3 px-3">
                        <a href="{{ route('tables.laporanPengeluaran', array_merge(request()->query(), ['sort' => 'total_harga', 'direction' => $sortField === 'total_harga' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                            Total Harga
                            <div class="sort-icons">
                                <i class="bx bxs-up-arrow {{ $sortField === 'total_harga' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                <i class="bx bxs-down-arrow {{ $sortField === 'total_harga' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                            </div>
                        </a>
                    </th>
                    <th class="py-3 px-3">
                        <a href="{{ route('tables.laporanPengeluaran', array_merge(request()->query(), ['sort' => 'keterangan', 'direction' => $sortField === 'keterangan' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
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
                    @forelse($projects as $laporanPengeluaran)
                        <tr>
                            <td>{{ $laporanPengeluaran['no'] }}</td>
                            <td>{{ $laporanPengeluaran['tanggal_transaksi'] }}</td>
                            <td>{{ $laporanPengeluaran['nama_barang'] }}</td>
                            <td>{{ $laporanPengeluaran['jumlah'] }}</td>
                            <td>{{ $laporanPengeluaran['harga_satuan'] }}</td>
                            <td>{{ $laporanPengeluaran['total_harga'] }}</td>
                            <td>{{ $laporanPengeluaran['keterangan'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Data tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
                </table>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center text-secondary">
                    <div>
                        Showing {{ $projects->count() }} of {{ $total }} entries
                    </div>
                    <nav>
                        <ul class="pagination">
                            @for ($i = 1; $i <= ceil($total / $perPage); $i++)
                                <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                                    <a class="page-link" href="{{ route('tables.laporanPengeluaran', array_merge(request()->query(), ['page' => $i])) }}">{{ $i }}</a>
                                </li>
                            @endfor
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
