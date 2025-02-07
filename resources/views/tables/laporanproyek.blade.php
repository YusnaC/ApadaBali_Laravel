@extends('layouts.app')

@section('title', 'Laporan Proyek')

@section('content')
<!-- Section utama untuk menampilkan laporan proyek -->
<section id="main-content" class="col-md-12 ms-md-7">
    <div class="pencatatan-proyek-content">
        <div class="row">
            <div class="card shadow-sm rounded-0 py-4 px-3">
            <h4 class="mb-4 fw-bold">Laporan Proyek</h4>
    
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

                <!-- Table data -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="py-3 px-3" style="width: 8%;">
                                <a href="{{ route('tables.laporanproyek', array_merge(request()->query(), ['sort' => 'id_proyek', 'direction' => $sortField === 'id_laporanproyek' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Id Proyek
                                    <div class="sort-icons">    
                                        <i class="bx bxs-up-arrow {{ $sortField === 'id_proyek' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'id_proyek' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="py-3 px-3">
                                <a href="{{ route('tables.laporanproyek', array_merge(request()->query(), ['sort' => 'kategori', 'direction' => $sortField === 'kategori' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Kategori
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'kategori' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'kategori' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="py-3 px-3">
                                <a href="{{ route('tables.laporanproyek', array_merge(request()->query(), ['sort' => 'tgl_proyek', 'direction' => $sortField === 'tgl_laporanproyek' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Tgl Proyek
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'tgl_proyek' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'tgl_proyek' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="py-3 px-3">
                                <a href="{{ route('tables.laporanproyek', array_merge(request()->query(), ['sort' => 'nama_proyek', 'direction' => $sortField === 'nama_laporanproyek' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Nama Proyek
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'nama_proyek' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'nama_proyek' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="py-3 px-3">
                                <a href="{{ route('tables.laporanproyek', array_merge(request()->query(), ['sort' => 'lokasi', 'direction' => $sortField === 'lokasi' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Lokasi
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'lokasi' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'lokasi' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="py-3 px-3" style="width: 8%;">
                                <a href="{{ route('tables.laporanproyek', array_merge(request()->query(), ['sort' => 'luas', 'direction' => $sortField === 'luas' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Luas (m²)
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'luas' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'luas' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="py-3 px-3" style="width: 8%;">
                                <a href="{{ route('tables.laporanproyek', array_merge(request()->query(), ['sort' => 'jumlah_lantai', 'direction' => $sortField === 'jumlah_lantai' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Jumlah Lantai
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'jumlah_lantai' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'jumlah_lantai' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="py-3 px-3">
                                <a href="{{ route('tables.laporanproyek', array_merge(request()->query(), ['sort' => 'tgl_deadline', 'direction' => $sortField === 'tgl_deadline' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Tgl Deadline
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'tgl_deadline' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'tgl_deadline' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="py-3 px-3" style="width: 8%;">
                                <a href="{{ route('tables.laporanproyek', array_merge(request()->query(), ['sort' => 'id_drafter', 'direction' => $sortField === 'id_drafter' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Id Drafter
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'id_drafter' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'id_drafter' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <!-- Loop untuk menampilkan data laporan proyek -->
                        @forelse($projects as $project)
                            <tr>
                                <td>{{ $project['id_proyek'] }}</td>
                                <td>{{ $project['kategori'] }}</td>
                                <td>{{ $project['tgl_proyek'] }}</td>
                                <td>{{ $project['nama_proyek'] }}</td>
                                <td>{{ $project['lokasi'] }}</td>
                                <td>{{ $project['luas'] }}</td>
                                <td>{{ $project['jumlah_lantai'] }}</td>
                                <td>{{ $project['tgl_deadline'] }}</td>
                                <td>{{ $project['id_drafter'] }}</td>
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
                                        <a class="page-link" href="{{ route('tables.laporanproyek', array_merge(request()->all(), ['page' => $i])) }}">
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
    </div>
</section>

        
@endsection