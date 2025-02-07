@extends('layouts.app')

@section('title', 'Laporan Furniture')

@section('content')
<!-- Section utama untuk menampilkan laporan furniture -->
<section id="main-content" class="col-md-12 ms-md-7">
    <div class="pencatatan-furniture-content">
        <div class="row">
            <div class="card shadow-sm rounded-0 py-4 px-3">
                <!-- Judul halaman -->
                <h4 class="mb-4 fw-bold">Laporan Furniture</h4>

                <div class="input-form-keuangan mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <select class="form-select" style="max-width: 200px;">
                            <option selected class="text-secondary" disabled>Pilih Jenis</option>
                            <option value="1">Proyek</option>
                            <option value="2">Furniture</option>
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
                            <!-- Kolom untuk ID laporanfurniture dengan pengurutan -->
                            <th class="py-3 px-3" style="width: 10%;">
                                <a href="{{ route('tables.laporanfurniture', array_merge(request()->query(), ['sort' => 'id_laporanfurniture', 'direction' => $sortField === 'id_laporanfurniture' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Id Furniture
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'id_laporanfurniture' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'id_laporanfurniture' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <!-- Kolom untuk Tanggal Pembuatan dengan pengurutan -->
                            <th class="py-3 px-3">
                                <a href="{{ route('tables.laporanfurniture', array_merge(request()->query(), ['sort' => 'tgl_pembuatan', 'direction' => $sortField === 'tgl_pembuatan' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Tgl Pembuatan
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'tgl_pembuatan' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'tgl_pembuatan' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <!-- Kolom untuk Nama laporanfurniture dengan pengurutan -->
                            <th class="py-3 px-3">
                                <a href="{{ route('tables.laporanfurniture', array_merge(request()->query(), ['sort' => 'nama_laporanfurniture', 'direction' => $sortField === 'nama_laporanfurniture' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Nama Furniture
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'nama_laporanfurniture' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'nama_laporanfurniture' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <!-- Kolom untuk Jumlah Unit dengan pengurutan -->
                            <th class="py-3 px-3" style="width: 10%;">
                                <a href="{{ route('tables.laporanfurniture', array_merge(request()->query(), ['sort' => 'jumlah_unit', 'direction' => $sortField === 'jumlah_unit' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Jumlah Unit
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'jumlah_unit' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'jumlah_unit' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <!-- Kolom untuk Harga Unit dengan pengurutan -->
                            <th class="py-3 px-3" style="width: 12%;">
                                <a href="{{ route('tables.laporanfurniture', array_merge(request()->query(), ['sort' => 'harga_unit', 'direction' => $sortField === 'harga_unit' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Harga Unit
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'harga_unit' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'harga_unit' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <!-- Kolom untuk Lokasi dengan pengurutan -->
                            <th class="py-3 px-3">
                                <a href="{{ route('tables.laporanfurniture', array_merge(request()->query(), ['sort' => 'lokasi', 'direction' => $sortField === 'lokasi' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Lokasi
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'lokasi' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'lokasi' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <!-- Kolom untuk Tanggal Selesai dengan pengurutan -->
                            <th class="py-3 px-3" style="width: 12%;">
                                <a href="{{ route('tables.laporanfurniture', array_merge(request()->query(), ['sort' => 'tgl_selesai', 'direction' => $sortField === 'tgl_selesai' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Tgl Selesai
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'tgl_selesai' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'tgl_selesai' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <!-- Kolom untuk Aksi -->
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($projects as $laporanfurniture)
                            <tr>
                                <td>{{ $laporanfurniture['id_furniture'] }}</td>
                                <td>{{ $laporanfurniture['tgl_pembuatan'] }}</td>
                                <td>{{ $laporanfurniture['nama_furniture'] }}</td>
                                <td>{{ $laporanfurniture['jumlah_unit'] }}</td>
                                <td>{{ $laporanfurniture['harga_unit'] }}</td>
                                <td>{{ $laporanfurniture['lokasi'] }}</td>
                                <td>{{ $laporanfurniture['tgl_selesai'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center">Data tidak ditemukan.</td>
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
                                    <a class="page-link" href="{{ route('tables.laporanfurniture', array_merge(request()->all(), ['page' => $i])) }}">
                                        {{ $i }}
                                    </a>
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
