@extends('layouts.app')

@section('title', 'Data Drafter')

@section('content')
<!-- Section utama untuk menampilkan data drafter -->
<section id="main-content" class="col-md-12 ms-md-7">
    <div class="pencatatan-drafter-content">
        <div class="row">
            <div class="card shadow-sm rounded-0 py-4 px-3">
            <h4 class="mb-4 fw-bold">Data Drafter</h4>
            
            <!-- Tombol Tambah dan Search  -->
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
                        <span class="entries-label text-secondary">entries per page</span>
                    </div>

                    <!-- Menjaga query string lain -->
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                    <input type="hidden" name="direction" value="{{ request('direction') }}">
                </form>

                <div class="form-add d-flex">
                    <!-- Form pencarian -->
                    <form method="GET" action="{{ route('tables.drafter') }}" class="d-flex search-form">
                        <div class="input-group me-2">
                            <span class="input-group-text">
                                <i class="bx bx-search"></i>
                            </span>
                            <input type="text" name="search" class="form-control search-input" placeholder="Search..." value="{{ request('search') }}" />
                        </div>
                    </form>

                    <!-- Tombol tambah -->
                    <a href="/Tambah-Data-Drafter" class="btn-add fw-bold py-3 px-4">+ Tambah</a>
                </div>
            </div>

            <!-- Tabel Data -->
            <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="py-3 px-3" style="width: 10%;">
                        <a href="{{ route('tables.drafter', array_merge(request()->query(), ['sort' => 'id_drafter', 'direction' => $sortField === 'id_drafter' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                            Id Drafter
                            <div class="sort-icons">    
                                <i class="bx bxs-up-arrow {{ $sortField === 'id_drafter' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                <i class="bx bxs-down-arrow {{ $sortField === 'id_drafter' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                            </div>
                        </a>
                    </th>
                    <th class="py-3 px-3" style="width: 25%;">
                        <a href="{{ route('tables.drafter', array_merge(request()->query(), ['sort' => 'nama_drafter', 'direction' => $sortField === 'nama_drafter' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                            Nama Drafter
                            <div class="sort-icons">
                                <i class="bx bxs-up-arrow {{ $sortField === 'nama_drafter' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                <i class="bx bxs-down-arrow {{ $sortField === 'nama_drafter' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                            </div>
                        </a>
                    </th>
                    <th class="py-3 px-3">
                    <a href="{{ route('tables.furniture', array_merge(request()->query(), ['sort' => 'alamat_drafter', 'direction' => $sortField === 'alamat_drafter' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                            Alamat Drafter
                            <div class="sort-icons">
                                <i class="bx bxs-up-arrow {{ $sortField === 'alamat_drafter' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                <i class="bx bxs-down-arrow {{ $sortField === 'alamat_drafter' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                            </div>
                        </a>
                    </th>
                    <th class="py-3 px-3" style="width: 20%;">
                    <a href="{{ route('tables.drafter', array_merge(request()->query(), ['sort' => 'no_whatsapp', 'direction' => $sortField === 'no_whatsapp' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                            No WhatsApp
                            <div class="sort-icons">
                                <i class="bx bxs-up-arrow {{ $sortField === 'no_whatsapp' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                <i class="bx bxs-down-arrow {{ $sortField === 'no_whatsapp' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                            </div>
                        </a>
                    </th>
                    <th class="py-3 px-3" style="width: 8%;">
                    <a href="{{ route('tables.drafter', array_merge(request()->query(), ['sort' => 'aksi', 'direction' => $sortField === 'aksi' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
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
                @forelse($projects as $drafter)
                    <tr>
                        <td>{{ $drafter['id_drafter'] }}</td>
                        <td>{{ $drafter['nama_drafter'] }}</td>
                        <td>{{ $drafter['alamat_drafter'] }}</td>
                        <td>{{ $drafter['no_whatsapp'] }}</td>
                        <td>
                            <div class="button-container">
                                <button class="btn btn-delete" data-id="{{ $drafter['id_drafter'] }}">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="text-center">Data tidak ditemukan.</td>
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
                                <a class="page-link" href="{{ route('tables.drafter', array_merge(request()->all(), ['page' => $i])) }}">
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