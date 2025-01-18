@extends('layouts.app')

@section('title', 'Pencatatan Proyek')

@section('content')
<section id="main-content" class="col-md-12 ms-md-7">
    <div class="pencatatan-proyek-content">
        <div class="row">
            <div class="col-lg-20">
                <div class="card shadow-sm rounded-0 py-4 ">
                    <div class="card-body">
                        <h4 class="mb-4 fw-bold">Pencatatan Furniture</h4>
                            <!-- Tombol Tambah dan Search -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <!-- Dropdown dan label -->
                                <form method="GET" id="entriesForm">
                                <div class="d-flex align-items-center">
                                    <select class="form-select-entries entries-dropdown me-3" name="entries" onchange="document.getElementById('entriesForm').submit()">
                                        <option value="5" {{ request('entries') == 5 ? 'selected' : '' }}>5</option>
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
                                <form method="GET" action="{{ route('tables.furniture') }}" class="d-flex search-form">
                                <div class="input-group me-2">
                                    <span class="input-group-text">
                                    <i class="bx bx-search"></i>
                                    </span>
                                    <input 
                                    type="text" 
                                    name="search" 
                                    class="form-control search-input" 
                                    placeholder="Search..." 
                                    value="{{ request('search') }}"
                                    />
                                </div>
                                </form>
                                <!-- Tombol tambah -->
                                <button class="btn-add fw-bold py-3 px-4">+ Tambah</button>
                                </div>
                                </div>
                                <!-- Tabel Data -->
                                <table class="table table-bordered">
                                <thead>
                                <tr>
                                <th>
                                    <a href="{{ route('tables.furniture', array_merge(request()->query(), ['sort' => 'id_furniture', 'direction' => $sortField === 'id_furniture' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white  header-link">
                                        Id Furniture
                                        <span class="sort-icons">
                                            <i class="bx bxs-up-arrow {{ $sortField === 'id_furniture' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'id_furniture' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                        </span>
                                    </a>
                                </th>
                                    <th>
                                        <a href="{{ route('tables.furniture', array_merge(request()->query(), ['sort' => 'tgl_pembuatan', 'direction' => $sortField === 'tgl_pembuatan' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                            Tgl Pembuatan
                                            <div>
                                            <i class="bx bxs-up-arrow {{ $sortField === 'tgl_pembuatan' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'tgl_pembuatan' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                            </div>
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ route('tables.furniture', array_merge(request()->query(), ['sort' => 'nama_furniture', 'direction' => $sortField === 'nama_furniture' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                            Nama Furniture
                                            <div>
                                            <i class="bx bxs-up-arrow {{ $sortField === 'nama_furniture' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'nama_furniture' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                            </div>
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ route('tables.furniture', array_merge(request()->query(), ['sort' => 'jumlah_unit', 'direction' => $sortField === 'jumlah_unit' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                            Jumlah Unit
                                            <div>
                                            <i class="bx bxs-up-arrow {{ $sortField === 'jumlah_unit' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'jumlah_unit' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                            </div>
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ route('tables.furniture', array_merge(request()->query(), ['sort' => 'harga_unit', 'direction' => $sortField === 'harga_unit' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                            Harga Unit
                                            <div>
                                            <i class="bx bxs-up-arrow {{ $sortField === 'harga_unit' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'harga_unit' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                            </div>
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ route('tables.furniture', array_merge(request()->query(), ['sort' => 'lokasi', 'direction' => $sortField === 'lokasi' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                            Lokasi
                                            <div>
                                            <i class="bx bxs-up-arrow {{ $sortField === 'lokasi' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                            <i class="bx bxs-down-arrow {{ $sortField === 'lokasi' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                            </div>
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ route('tables.furniture', array_merge(request()->query(), ['sort' => 'tgl_selesai', 'direction' => $sortField === 'tgl_selesai' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                            Tgl Selesai
                                            <div class="sort-icons">
                                                <i class="bx bxs-up-arrow {{ $sortField === 'tgl_selesai' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                                <i class="bx bxs-down-arrow {{ $sortField === 'tgl_selesai' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                            </div>
                                        </a>
                                    </th>
                                    <th>
                                        <a class="text-white header-link">Aksi</a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($projects as $furniture)
                            <tr>
                                <td>{{ $furniture['id_furniture'] }}</td>
                                <td>{{ $furniture['tgl_pembuatan'] }}</td>
                                <td>{{ $furniture['nama_furniture'] }}</td>
                                <td>{{ $furniture['jumlah_unit'] }}</td>
                                <td>{{ $furniture['harga_unit'] }}</td>
                                <td>{{ $furniture['lokasi'] }}</td>
                                <td>{{ $furniture['tgl_selesai'] }}</td>
                                <td>
                                <div class="button-container">
                                    <button class="btn btn-edit">
                                        <i class="bx bx-edit"></i> Edit
                                    </button>
                                    <button class="btn btn-delete" data-id="{{ $furniture['id_furniture'] }}">
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
                                            <a class="page-link" href="{{ route('tables.furniture', array_merge(request()->all(), ['page' => $i])) }}">
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
    </div>
</section>
@endsection


