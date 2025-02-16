@extends('layouts.app')

@section('title', 'Pencatatan Proyek')

@section('content')
    <div class="mb-5">
        <div class="card shadow-sm rounded-0 p-4">
            <h4 class="mb-4 fw-bold">Pencatatan Proyek</h4>
            
            <!-- Tombol Tambah dan Search -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <!-- Dropdown dan label -->
                <form method="GET" id="entriesForm">
                    <div class="d-flex align-items-center">
                        <select class="form-select-entries entries-dropdown me-3" name="entries" onchange="document.getElementById('entriesForm').submit()">
                            <option value="10" {{ request('entries') == 10 ? 'selected' : '' }}>10</option>
                            <option value="20" {{ request('entries') == 20 ? 'selected' : '' }}>20</option>
                            <option value="50" {{ request('entries') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('entries') == 100 ? 'selected' : '' }}>100</option>
                        </select>
                        <span class="entries-label">entries per page</span>
                    </div>

                    <!-- Menjaga query string lain -->
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                    <input type="hidden" name="direction" value="{{ request('direction') }}">
                </form>

                <div class="form-add d-flex">
                    <!-- Form pencarian -->
                    <form method="GET" action="{{ route('tables.index') }}" class="d-flex search-form">
                        <div class="input-group me-2">
                            <span class="input-group-text">
                                <i class="bx bx-search"></i>
                            </span>
                            <input type="text" name="search" class="form-control search-input" placeholder="Search..." value="{{ request('search') }}" />
                        </div>
                    </form>

                    <!-- Tombol tambah -->
                    <button class="btn-add fw-bold py-3 px-4" onclick="location.href='{{ route('projects.create') }}'">+ Tambah</button>
                </div>
            </div>

            <!-- Tabel Data -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>
                            <a href="{{ route('tables.index', array_merge(request()->query(), ['sort' => 'id_proyek', 'direction' => $sortField === 'id_proyek' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                Id Proyek
                                <span class="sort-icons">
                                    <i class="bx bxs-up-arrow {{ $sortField === 'id_proyek' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                    <i class="bx bxs-down-arrow {{ $sortField === 'id_proyek' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                </span>
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('tables.index', array_merge(request()->query(), ['sort' => 'kategori', 'direction' => $sortField === 'kategori' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                Kategori
                                <div>
                                    <i class="bx bxs-up-arrow {{ $sortField === 'kategori' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                    <i class="bx bxs-down-arrow {{ $sortField === 'kategori' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                </div>
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('tables.index', array_merge(request()->query(), ['sort' => 'tgl_proyek', 'direction' => $sortField === 'tgl_proyek' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                Tgl Proyek
                                <div>
                                    <i class="bx bxs-up-arrow {{ $sortField === 'tgl_proyek' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                    <i class="bx bxs-down-arrow {{ $sortField === 'tgl_proyek' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                </div>
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('tables.index', array_merge(request()->query(), ['sort' => 'nama_proyek', 'direction' => $sortField === 'nama_proyek' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                Nama Proyek
                                <div>
                                    <i class="bx bxs-up-arrow {{ $sortField === 'nama_proyek' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                    <i class="bx bxs-down-arrow {{ $sortField === 'nama_proyek' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                </div>
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('tables.index', array_merge(request()->query(), ['sort' => 'lokasi', 'direction' => $sortField === 'lokasi' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                Lokasi
                                <div>
                                    <i class="bx bxs-up-arrow {{ $sortField === 'lokasi' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                    <i class="bx bxs-down-arrow {{ $sortField === 'lokasi' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                </div>
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('tables.index', array_merge(request()->query(), ['sort' => 'jenis', 'direction' => $sortField === 'jenis' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                Jenis
                                <div>
                                    <i class="bx bxs-up-arrow {{ $sortField === 'jenis' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                    <i class="bx bxs-down-arrow {{ $sortField === 'jenis' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                </div>
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('tables.index', array_merge(request()->query(), ['sort' => 'luas', 'direction' => $sortField === 'luas' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                Luas (m²)
                                <div class="sort-icons">
                                    <i class="bx bxs-up-arrow {{ $sortField === 'luas' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                    <i class="bx bxs-down-arrow {{ $sortField === 'luas' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                </div>
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('tables.index', array_merge(request()->query(), ['sort' => 'jumlah_lantai', 'direction' => $sortField === 'jumlah_lantai' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                Jumlah Lantai
                                <div class="sort-icons">
                                    <i class="bx bxs-up-arrow {{ $sortField === 'jumlah_lantai' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                    <i class="bx bxs-down-arrow {{ $sortField === 'jumlah_lantai' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                </div>
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('tables.index', array_merge(request()->query(), ['sort' => 'tgl_deadline', 'direction' => $sortField === 'tgl_deadline' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                Tgl Deadline
                                <div>
                                    <i class="bx bxs-up-arrow {{ $sortField === 'tgl_deadline' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                    <i class="bx bxs-down-arrow {{ $sortField === 'tgl_deadline' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                </div>
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('tables.index', array_merge(request()->query(), ['sort' => 'id_drafter', 'direction' => $sortField === 'id_drafter' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                Id Drafter
                                <div>
                                    <i class="bx bxs-up-arrow {{ $sortField === 'id_drafter' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                    <i class="bx bxs-down-arrow {{ $sortField === 'id_drafter' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                </div>
                            </a>
                        </th>
                        <th>
                            <a class="text-white header-link">Aksi</a>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($projects as $project)
                        <tr>
                            <td>{{ $project['id_proyek'] }}</td>
                            <td>{{ $project['kategori'] }}</td>
                            <td>{{ $project['tgl_proyek'] }}</td>
                            <td>{{ $project['nama_proyek'] }}</td>
                            <td>{{ $project['lokasi'] }}</td>
                            <td>{{ $project['jenis'] }}</td>
                            <td>{{ $project['luas'] }}</td>
                            <td>{{ $project['jumlah_lantai'] }}</td>
                            <td>{{ $project['tgl_deadline'] }}</td>
                            <td>{{ $project['id_drafter'] }}</td>
                            <td>
                                <div class="button-container">
                                    <button class="btn btn-edit">
                                        <i class="bx bx-edit"></i> Edit
                                    </button>
                                    <button class="btn btn-delete" data-id="{{ $project['id_proyek'] }}">
                                        <i class="bx bx-trash"></i>
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

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    Showing {{ $projects->count() }} of {{ $total }} entries
                </div>
                <nav>
                    <ul class="pagination">
                        @for ($i = 1; $i <= ceil($total / $perPage); $i++)
                            <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                                <a class="page-link" href="{{ route('tables.index', array_merge(request()->all(), ['page' => $i])) }}">
                                    {{ $i }}
                                </a>
                            </li>
                        @endfor
                    </ul>
                </nav>
            </div>
        </div>
    </div>
@endsection
