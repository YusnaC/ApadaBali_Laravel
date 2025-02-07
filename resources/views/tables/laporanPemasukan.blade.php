@extends('layouts.app')

@section('title', 'Laporan Pemasukan')

@section('content')
<!-- Section utama untuk menampilkan laporan keuangan -->
<section id="main-content" class="col-md-12 ms-md-7">
    <div class="pencatatan-pemasukan-content">
        <div class="row">
            <div class="card shadow-sm rounded-0 py-4 px-3">
                <h4 class="mb-5 fw-bold">Laporan Keuangan</h4>

                <div class="input-form-keuangan mb-3">
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
                                <td>{{ $laporanPemasukan['no'] }}</td>
                                <td>{{ $laporanPemasukan['jenis_order'] }}</td>
                                <td>{{ $laporanPemasukan['id_order'] }}</td>
                                <td>{{ $laporanPemasukan['tgl_transaksi'] }}</td>
                                <td>{{ $laporanPemasukan['jumlah'] }}</td>
                                <td>{{ $laporanPemasukan['termin'] }}</td>
                                <td>{{ $laporanPemasukan['keterangan'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Data tidak ditemukan.</td>
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
                                    <a class="page-link" href="{{ route('tables.laporanPemasukan', array_merge(request()->query(), ['page' => $i])) }}">{{ $i }}</a>
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
