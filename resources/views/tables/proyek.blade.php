@extends('layouts.app')  <!-- Menyertakan layout 'app' untuk tampilan halaman -->

@section('title', 'Pencatatan Proyek')  <!-- Menetapkan judul halaman -->

@section('content')  <!-- Menandai bagian konten halaman -->

<section id="main-content" class="col-md-12 ms-md-7">  <!-- Bagian utama konten halaman -->
    <div class="pencatatan-proyek-content">
        <div class="row">
            <div class="card shadow-sm rounded-0 py-4 px-3">  <!-- Membuat kartu untuk menampilkan data -->
                <h4 class="mb-4 fw-bold">Pencatatan Proyek</h4>
                
                    <!-- Tombol Tambah dan Search -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <!-- Form untuk memilih jumlah entries per page -->
                        <form method="GET" id="entriesForm">
                            <div class="d-flex align-items-center">
                                <select class="form-select-entries entries-dropdown me-3" name="entries" onchange="document.getElementById('entriesForm').submit()">
                                    <!-- Pilihan jumlah entri per halaman -->
                                    <option value="10" {{ request('entries') == 10 ? 'selected' : '' }}>10</option>
                                    <option value="20" {{ request('entries') == 20 ? 'selected' : '' }}>20</option>
                                    <option value="50" {{ request('entries') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('entries') == 100 ? 'selected' : '' }}>100</option>
                                </select>
                                <span class="entries-label text-secondary">entries per page</span>
                            </div>

                            <!-- Menjaga query string lainnya seperti search, sort, direction -->
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                            <input type="hidden" name="direction" value="{{ request('direction') }}">
                        </form>

                        <div class="form-add d-flex">
                            <!-- Form pencarian -->
                            <form method="GET" action="{{ route('tables.proyek') }}" class="d-flex search-form">
                                <div class="input-group me-2">
                                    <span class="input-group-text">
                                        <i class="bx bx-search"></i> <!-- Ikon pencarian -->
                                    </span>
                                    <input type="text" name="search" class="form-control search-input" placeholder="Search..." value="{{ request('search') }}" />
                                </div>
                            </form>

                            <!-- Tombol untuk menambah data proyek -->
                            <a href="/Tambah-Data-Proyek" class="btn-add fw-bold py-3 px-4">+ Tambah</a>
                        </div>
                    </div>

                    <!-- Tabel Data Proyek -->
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <!-- Kolom dengan fitur sorting untuk setiap atribut proyek -->
                                <th class="py-3 px-3">
                                    <a href="{{ route('tables.proyek', array_merge(request()->query(), ['sort' => 'id_proyek', 'direction' => $sortField === 'id_proyek' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                        Id Proyek
                                        <!-- Ikon untuk menunjukkan urutan sorting -->
                                        <div class="sort-icons">    
                                            <i class="bx bxs-up-arrow {{ $sortField === 'id_proyek' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'id_proyek' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                        </div>
                                    </a>
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            <!-- Loop untuk menampilkan data proyek -->
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
                                    <td>
                                        <div class="button-container">
                                            <button class="btn btn-edit">
                                                <i class="bx bx-edit"></i> Edit  <!-- Tombol Edit -->
                                            </button>
                                            <button class="btn btn-delete" data-id="{{ $project['id_proyek'] }}">
                                                <i class="bx bx-trash"></i> <!-- Tombol Delete -->
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center">Data tidak ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination untuk navigasi antar halaman -->
                    <div class="d-flex justify-content-between align-items-center text-secondary">
                        <div>
                            Showing {{ $projects->count() }} of {{ $total }} entries
                        </div>
                        <nav>
                            <ul class="pagination">
                                @for ($i = 1; $i <= ceil($total / $perPage); $i++)
                                    <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                                        <a class="page-link" href="{{ route('tables.proyek', array_merge(request()->all(), ['page' => $i])) }}">
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
