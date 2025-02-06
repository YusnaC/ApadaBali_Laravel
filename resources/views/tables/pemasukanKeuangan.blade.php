@extends('layouts.app')

@section('title', 'Data Pemasukan Keuangan')

@section('content')
<section id="main-content" class="col-md-12 ms-md-7">
    <div class="pencatatan-keuangan-content">
        <div class="row">
            <div class="card shadow-sm rounded-0 py-4 px-3">
                <h4 class="mb-3 fw-bold">Data Pemasukan Keuangan</h4>
                <hr style="background-color:#c4c4c4; height: 1px; border: none;">
                <div class="container mt-2 mb-3 p-0">
                    <div class="row">
                        <!-- Card 1 -->
                        <div class="col-md-4 mb-3">
                            <div class="card rounded-2 text-white" style="background-color: #496FDE;">
                                <div class="card-body p-4">
                                    <h3 class="card-title fw-bold">Rp. 150.000.000</h3>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="mb-0">Sisa Kas</p>
                                        <img src="./icon/sisa kas.svg" alt="icon" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card 2 -->
                        <div class="col-md-4 mb-3">
                            <div class="card rounded-2 text-white" style="background-color: #1CC588;">
                                <div class="card-body p-4">
                                    <h3 class="card-title fw-bold">Rp. 200.000.000</h3>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="mb-0">Total Pemasukan</p>
                                        <img src="./icon/total pemasukan.svg" alt="icon" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card 3 -->
                        <div class="col-md-4 mb-3">
                            <div class="card rounded-2 text-white" style="background-color: #E74A3B;">
                                <div class="card-body p-4">
                                    <h3 class="card-title fw-bold">Rp. 50.000.000</h3>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="mb-0">Total Pengeluaran</p>
                                        <img src="./icon/total pengeluaran.svg" alt="icon" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                        <input type="hidden" name="direction" value="{{ request('direction') }}">
                    </form>

                    <div class="form-add d-flex">
                        <form method="GET" action="{{ route('tables.pemasukanKeuangan') }}" class="d-flex search-form">
                            <div class="input-group me-2">
                                <span class="input-group-text">
                                    <i class="bx bx-search"></i>
                                </span>
                                <input type="text" name="search" class="form-control search-input" placeholder="Search..." value="{{ request('search') }}" />
                            </div>
                        </form>
                        <a href="/Tambah-Data-Pemasukan" class="btn-add fw-bold py-3 px-4">+ Tambah</a>
                    </div>
                </div>

                <!-- Tabel Data -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="py-3 px-3" style="width: 7%;">
                                <a href="{{ route('tables.pemasukanKeuangan', array_merge(request()->query(), ['sort' => 'no', 'direction' => $sortField === 'no' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    No
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'no' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'no' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="py-3 px-3">
                                <a href="{{ route('tables.pemasukanKeuangan', array_merge(request()->query(), ['sort' => 'jenis_order', 'direction' => $sortField === 'jenis_order' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Jenis Order
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'jenis_order' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'jenis_order' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="py-3 px-3" style="width: 10%;">
                                <a href="{{ route('tables.pemasukanKeuangan', array_merge(request()->query(), ['sort' => 'id_order', 'direction' => $sortField === 'id_order' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    ID Order
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'id_order' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'id_order' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="py-3 px-3">
                                <a href="{{ route('tables.pemasukanKeuangan', array_merge(request()->query(), ['sort' => 'tgl_transaksi', 'direction' => $sortField === 'tgl_transaksi' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Tgl Transaksi
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'tgl_transaksi' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'tgl_transaksi' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="py-3 px-3" style="width: 10%;">
                                <a href="{{ route('tables.pemasukanKeuangan', array_merge(request()->query(), ['sort' => 'jumlah', 'direction' => $sortField === 'jumlah' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Jumlah
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'jumlah' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'jumlah' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="py-3 px-3" style="width: 10%;">
                                <a href="{{ route('tables.pemasukanKeuangan', array_merge(request()->query(), ['sort' => 'termin', 'direction' => $sortField === 'termin' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Termin
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'termin' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'termin' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="py-3 px-3">
                                <a href="{{ route('tables.pemasukanKeuangan', array_merge(request()->query(), ['sort' => 'keterangan', 'direction' => $sortField === 'keterangan' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Keterangan
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'keterangan' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'keterangan' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="py-3 px-3" style="width: 10%;">
                                <a href="{{ route('tables.pemasukanKeuangan', array_merge(request()->query(), ['sort' => 'aksi', 'direction' => $sortField === 'aksi' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
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
                        @forelse($projects as $pemasukanKeuangan)
                            <tr>
                                <td>{{ $pemasukanKeuangan['no'] }}</td>
                                <td>{{ $pemasukanKeuangan['jenis_order'] }}</td>
                                <td>{{ $pemasukanKeuangan['id_order'] }}</td>
                                <td>{{ $pemasukanKeuangan['tgl_transaksi'] }}</td>
                                <td>{{ $pemasukanKeuangan['jumlah'] }}</td>
                                <td>{{ $pemasukanKeuangan['termin'] }}</td>
                                <td>{{ $pemasukanKeuangan['keterangan'] }}</td>
                                <td>
                                    <div class="button-container">
                                        <button class="btn btn-edit">
                                            <i class="bx bx-edit"></i> Edit
                                        </button>
                                        <button class="btn btn-delete" data-id="{{ $pemasukanKeuangan['id_order'] }}">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                </td>
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
                                    <a class="page-link" href="{{ route('tables.pemasukanKeuangan', array_merge(request()->query(), ['page' => $i])) }}">{{ $i }}</a>
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
