@extends('layouts.app')

@section('title', 'Managemen Klien')

@section('content')
<!-- Section utama untuk menampilan data klien -->
<section id="main-content" class="col-md-12 ms-md-7">
    <div class="pencatatan-klien-content">
        <div class="row">
            <div class="card shadow-sm rounded-0 py-4 px-3">
                <h4 class="mb-4 fw-bold">Data Klien</h4>
                
                <!-- Tombol Tambah dan Search -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <form method="GET" id="entriesForm">
                        <div class="d-flex align-items-center">
                            <select class="form-select-entries entries-dropdown me-3" name="entries" onchange="document.getElementById('entriesForm').submit()">
                                <option value="10" {{ request('entries') == 10 ? 'selected' : '' }}>10</option>
                                <option value="20" {{ request('entries') == 20 ? 'selected' : '' }}>20</option>
                                <option value="50" {{ request('entries') == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('entries') == 100 ? 'selected' : '' }}>100</option>
                            </select>
                            <span class="entries-label text-secondary">entries per page</span>
                        </div>

                        <!-- Menjaga query string lain -->
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                        <input type="hidden" name="direction" value="{{ request('direction') }}">
                    </form>

                    <div class="form-add d-flex">
                        <!-- Form pencarian -->
                        <form method="GET" action="{{ route('tables.klien') }}" class="d-flex search-form">
                            <div class="input-group me-2">
                                <span class="input-group-text">
                                    <i class="bx bx-search"></i>
                                </span>
                                <input type="text" name="search" class="form-control search-input" placeholder="Search..." value="{{ request('search') }}" />
                            </div>
                        </form>

                        <!-- Tombol tambah -->
                        <a href="/Tambah-Data-Klien" class="btn-add fw-bold py-3 px-4">+ Tambah</a>
                    </div>
                </div>

                <!-- Tabel Data -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="py-3 px-3" style="width: 10%;">
                                <a href="{{ route('tables.klien', array_merge(request()->query(), ['sort' => 'id_klien', 'direction' => $sortField === 'id_klien' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Id Klien
                                    <div class="sort-icons">    
                                        <i class="bx bxs-up-arrow {{ $sortField === 'id_klien' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'id_klien' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="py-3 px-3" style="width:15%">
                                <a href="{{ route('tables.klien', array_merge(request()->query(), ['sort' => 'jenis_order', 'direction' => $sortField === 'jenis_order' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Jenis Order
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'jenis_order' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'jenis_order' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="py-3 px-3" style="width:10%">
                                <a href="{{ route('tables.klien', array_merge(request()->query(), ['sort' => 'id_order', 'direction' => $sortField === 'id_order' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Id Order
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'id_order' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'id_order' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="py-3 px-3">
                                <a href="{{ route('tables.klien', array_merge(request()->query(), ['sort' => 'nama_klien', 'direction' => $sortField === 'nama_klien' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Nama Klien
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'nama_klien' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'nama_klien' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="py-3 px-3">
                                <a href="{{ route('tables.klien', array_merge(request()->query(), ['sort' => 'alamat_klien', 'direction' => $sortField === 'alamat_klien' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Alamat Klien
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'alamat_klien' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'alamat_klien' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="py-3 px-3" style="width: 13%;">
                                <a href="{{ route('tables.klien', array_merge(request()->query(), ['sort' => 'no_whatsapp', 'direction' => $sortField === 'no_whatsapp' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    No WhatsApp
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'no_whatsapp' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'no_whatsapp' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="py-3 px-3" style="width:10%">
                            <a href="{{ route('tables.klien', array_merge(request()->query(), ['sort' => 'aksi', 'direction' => $sortField === 'aksi' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Aksi
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'aksi' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'aksi' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <!-- Loop untuk menampilkan data proyek -->
                        @forelse($projects as $klien)
                            <tr>
                                <td>{{ $klien['id_klien'] }}</td>
                                <td>{{ $klien['jenis_order'] }}</td>
                                <td>{{ $klien['id_order'] }}</td>
                                <td>{{ $klien['nama_klien'] }}</td>
                                <td>{{ $klien['alamat_klien'] }}</td>
                                <td>{{ $klien['no_whatsapp'] }}</td>
                                <td>
                                <div class="button-container">
                                        <button class="btn btn-edit">
                                            <i class="bx bx-edit"></i> Edit
                                        </button>
                                        <button class="btn btn-delete" data-id="{{ $klien['id_klien'] }}">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                </td>
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
                                    <a class="page-link" href="{{ route('tables.klien', array_merge(request()->all(), ['page' => $i])) }}">
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
