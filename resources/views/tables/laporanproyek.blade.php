@extends('layouts.app')

@section('title', 'Laporan Proyek')

@section('content')
<!-- Section utama untuk menampilkan laporan proyek -->
<section id="main-content" class="col-md-12 ms-md-7">
    <div class="pencatatan-proyek-content">
        <div class="row">
            <div class="card shadow-sm rounded-0 py-4 px-3">
                <h4 class="mb-4 fw-bold">Laporan {{ request('jenis') == '2' ? 'Furniture' : 'Proyek' }}</h4>
    
                <div class="input-form-keuangan mb-3">
                    <form action="{{ route('tables.laporanproyek') }}" method="GET" id="filterForm">
                        <div class="d-flex align-items-center gap-4">
                            <select name="jenis" class="form-select" style="max-width: 200px;" id="jenisSelect" onchange="this.form.submit()">
                                <option value="1" {{ !request('jenis') || request('jenis') == '1' ? 'selected' : '' }}>Proyek</option>
                                <option value="2" {{ request('jenis') == '2' ? 'selected' : '' }}>Furniture</option>
                            </select>
                            
                            <div class="d-flex align-items-center gap-3" style="width: 22%;">
                            <label for="tgl_awal" class="form-label mb-0" style="white-space: nowrap;">Tanggal Awal</label>
                            <div class="input-group" style="flex: 1;">
                            <!-- <label for="tglAwal" class="form-label me-2" style="width: 100px;">Tgl Awal</label> -->
                                <input name="tgl_awal" 
                                    type="date" 
                                    class="form-control" 
                                    id="tglAwal"
                                    onfocus="this.showPicker()"
                                    value="{{ old('tgl_awal', isset($proyek) ? $proyek->tgl_awal : '') }}"
                                    style="max-width: 200px;">
                                <!-- <input type="text" id="tgl_awal" name="tgl_awal" class="form-control" 
                                    placeholder="Tgl awal" onfocus="(this.type='date'); this.showPicker()"
                                    onblur="(this.type='text')" value="{{ request('tgl_awal') }}"> -->
                                <!-- <span class="input-group-text bg-white">
                                    <i class='bx bx-calendar'></i>
                                </span> -->
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-3" style="width: 22%;">
                            <label for="tgl_akhir" class="form-label mb-0" style="white-space: nowrap;">Tanggal Akhir</label>
                            <div class="input-group" style="flex: 1;">
                            <input name="tgl_awal" 
                                    type="date" 
                                    class="form-control" 
                                    id="tglAwal"
                                    onfocus="this.showPicker()"
                                    value="{{ old('tgl_awal', isset($proyek) ? $proyek->tgl_awal : '') }}"
                                    style="max-width: 200px;">
                                
                            </div>
                        </div>
                        
                        <div class="dropdown">
                            <button class="btn-export d-flex align-items-center gap-1" type="button" data-bs-toggle="dropdown">
                                <i class='bx bx-export'></i>
                                Export
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('proyek.export', request()->all()) }}">Excel</a></li>
                                <li><a class="dropdown-item" href="{{ route('proyek.export.pdf', request()->all()) }}">PDF</a></li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>

            <div id="proyekView" class="{{ request('jenis') == '2' ? 'd-none' : '' }}">
                <!-- Table data -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="py-3 px-3" style="width: 8%;">
                                <a href="{{ route('tables.laporanproyek', array_merge(request()->query(), ['sort' => 'id_proyek', 'direction' => $sortField === 'id_proyek' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
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
                            <tr class="text-center">
                                <td class="pt-4 pb-4">{{ $project['id_proyek'] }}</td>
                                <td class="pt-4 pb-4 text-start">{{ $project['kategori'] }}</td>
                                <td class="pt-4 pb-4">{{ $project['tgl_proyek'] }}</td>
                                <td class="pt-4 pb-4 text-start">{{ $project['nama_proyek'] }}</td>
                                <td class="pt-4 pb-4 text-start">{{ $project['lokasi'] }}</td>
                                <td class="pt-4 pb-4">{{ is_numeric($project['luas']) ? (fmod((float)$project['luas'], 1) == 0 ? number_format($project['luas'], 0) : rtrim(rtrim(number_format($project['luas'], 2, '.', ''), '0'), '.')) : $project['luas'] }}</td>                                <td>{{ $project['jumlah_lantai'] }}</td>
                                <td class="pt-4 pb-4">{{ $project['tgl_deadline'] }}</td>
                                <td class="pt-4 pb-4">{{ $project['id_drafter'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center">Data tidak ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div id="furnitureView" class="{{ request('jenis') != '2' ? 'd-none' : '' }}">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="py-3 px-3" style="width: 8%;">
                                <a href="{{ route('tables.laporanproyek', array_merge(request()->query(), ['sort' => 'id_furniture', 'direction' => $sortField === 'id_furniture' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    ID Furniture
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'id_furniture' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'id_furniture' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="py-3 px-3">
                                <a href="{{ route('tables.laporanproyek', array_merge(request()->query(), ['sort' => 'tgl_pembuatan', 'direction' => $sortField === 'tgl_pembuatan' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Tanggal Pembuatan
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'tgl_pembuatan' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'tgl_pembuatan' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="py-3 px-3">
                                <a href="{{ route('tables.laporanproyek', array_merge(request()->query(), ['sort' => 'nama_furniture', 'direction' => $sortField === 'nama_furniture' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Nama Furniture
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'nama_furniture' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'nama_furniture' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="py-3 px-3">
                                <a href="{{ route('tables.laporanproyek', array_merge(request()->query(), ['sort' => 'jumlah_unit', 'direction' => $sortField === 'jumlah_unit' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Jumlah Unit
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'jumlah_unit' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'jumlah_unit' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="py-3 px-3">
                                <a href="{{ route('tables.laporanproyek', array_merge(request()->query(), ['sort' => 'harga_unit', 'direction' => $sortField === 'harga_unit' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Harga Unit
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'harga_unit' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'harga_unit' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
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
                            <th class="py-3 px-3">
                                <a href="{{ route('tables.laporanproyek', array_merge(request()->query(), ['sort' => 'tgl_selesai', 'direction' => $sortField === 'tgl_selesai' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Tanggal Selesai
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'tgl_selesai' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'tgl_selesai' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($projects as $project)
                            <tr>
                                <td>{{ $project['id_proyek'] }}</td>
                                <td>{{ $project['tgl_proyek'] }}</td>
                                <td class="text-start">{{ $project['nama_proyek'] }}</td>
                                <td>{{ $project['jumlah'] ?? '-' }}</td>
                                <td>{{ isset($project['harga']) && !is_null($project['harga']) ? number_format($project['harga'], 0, ',', '.') : '-' }}</td>
                                <td class="text-start">{{ $project['lokasi'] ?? '-' }}</td>
                                <td>{{ $project['tgl_deadline'] }}</td>
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
    </div>
</section>

<!-- Remove this script at the bottom of the file -->
<script>
// Remove the handleViewChange function since we're not redirecting anymore
</script>
@endsection