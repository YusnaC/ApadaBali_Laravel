@extends('layouts.app')

@section('title', 'Progres Proyek')

@section('content')
<section id="main-content" class="col-md-12 ms-md-7">
    <div class="Progres-Proyek-content">
        <div class="row">
            <div class="card shadow-sm rounded-0 py-4 px-3">
            <h4 class="mb-4 fw-bold">Progres Proyek</h4>
            
                <!-- Tombol Tambah dan Pencarian -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <!-- Dropdown untuk memilih jumlah entri per halaman dan label -->
                    <form method="GET" id="entriesForm">
                        <div class="d-flex align-items-center">
                            <select class="form-select-entries entries-dropdown me-3" name="entries" onchange="document.getElementById('entriesForm').submit()">
                                <option value="10" {{ request('entries') == 10 ? 'selected' : '' }}>10</option>
                                <option value="20" {{ request('entries') == 20 ? 'selected' : '' }}>20</option>
                                <option value="50" {{ request('entries') == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('entries') == 100 ? 'selected' : '' }}>100</option>
                            </select>
                            <span class="entries-label text-secondary">entri per halaman</span>
                        </div>

                        <!-- Menjaga query string lainnya tetap terjaga -->
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                        <input type="hidden" name="direction" value="{{ request('direction') }}">
                    </form>

                    <div class="form-add d-flex">
                        <!-- Form untuk pencarian data -->
                        <form method="GET" action="{{ route('tables.progresproyek') }}" class="d-flex search-form">
                            <div class="input-group me-2">
                                <span class="input-group-text">
                                    <i class="bx bx-search"></i>
                                </span>
                                <input type="text" name="search" class="form-control search-input" placeholder="Cari..." value="{{ request('search') }}" />
                            </div>
                        </form>
                         <!-- Tombol untuk menambah data -->
                         <a href="/Tambah-Data-Progres" class="btn-add fw-bold py-3 px-4">+ Tambah</a>
                    </div>
                </div>

                <!-- Tabel Data Progres Proyek -->
                <table class="table table-bordered">
                    <thead style="background-color: #800000;">
                        <tr>
                            <th class="py-3 px-3" style="width: 10%;">
                                <a href="{{ route('tables.progresproyek', array_merge(request()->query(), ['sort' => 'id_proyek', 'direction' => $sortField === 'id_progresproyek' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Id Proyek
                                    <div class="sort-icons">    
                                        <i class="bx bxs-up-arrow {{ $sortField === 'id_proyek' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'id_proyek' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="py-3 px-3" style="width: 14%;">
                                <a href="{{ route('tables.progresproyek', array_merge(request()->query(), ['sort' => 'tgl_proyek', 'direction' => $sortField === 'tgl_progresproyek' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Tgl Progres
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'tgl_proyek' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'tgl_proyek' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="py-3 px-3" style="width: 10%;">
                                <a href="{{ route('tables.progresproyek', array_merge(request()->query(), ['sort' => 'Progres', 'direction' => $sortField === 'nama_progresproyek' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Progres %
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'Progres' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'Progres' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="py-3 px-3">
                                <a href="{{ route('tables.progresproyek', array_merge(request()->query(), ['sort' => 'keterangan', 'direction' => $sortField === 'keterangan' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Keterangan
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'keterangan' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'keterangan' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="py-3 px-3">
                                <a href="{{ route('tables.progresproyek', array_merge(request()->query(), ['sort' => 'dokumen', 'direction' => $sortField === 'keterangan' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Dokumen
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'dokumen' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'dokumen' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="py-3 px-3" style="width: 10%;">
                                <a href="{{ route('tables.progresproyek', array_merge(request()->query(), ['sort' => 'aksi', 'direction' => $sortField === 'aksi' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Aksi
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'aksi' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'aksi' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                        </tr>
                    </thead>

                    <tbody class="drafter-table">
                        @forelse($projects as $progresproyek)
                            <tr>
                                <td>{{ $progresproyek->id_proyek }}</td>
                                <td>{{ \Carbon\Carbon::parse($progresproyek->tgl_proyek)->format('d/m/Y') }}</td>
                                <td>{{ $progresproyek->progres }}%</td>
                                <td>{{ $progresproyek->keterangan }}</td>
                                <td>
                                    @if($progresproyek->dokumen)
                                        <a href="{{ Storage::url($progresproyek->dokumen) }}" target="_blank" class="text-primary">
                                            <i class="bx bx-file"></i> {{$progresproyek->dokumen}}
                                        </a>
                                    @else
                                        <span class="text-muted">Tidak ada dokumen</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="button-container">
                                        <a href="{{ route('proyek.progress.edit', $progresproyek->id_progres) }}" class="btn btn-edit">
                                            <i class="bx bx-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('proyek.progress.destroy', $progresproyek->id_progres) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-delete">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Data tidak ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                    <!-- Navigasi Halaman -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-secondary">
                            @if($projects->count() > 0)
                                Showing {{ $projects->firstItem() ?? 1 }} to {{ $projects->lastItem() ?? $projects->count() }} of {{ $projects->total() }} entries
                            @else
                                Showing 0 entries
                            @endif
                        </div>
                        <nav aria-label="Page navigation">
                            <ul class="pagination pagination-sm mb-0">
                                <!-- Previous Page Link -->
                                @if ($projects->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link">&lsaquo;</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $projects->previousPageUrl() }}">&lsaquo;</a></li>
                                @endif

                                <!-- Pagination Elements -->
                                @foreach ($projects->getUrlRange(1, $projects->lastPage()) as $page => $url)
                                    @if ($page == $projects->currentPage())
                                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                    @else
                                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                    @endif
                                @endforeach

                                <!-- Next Page Link -->
                                @if ($projects->hasMorePages())
                                    <li class="page-item"><a class="page-link" href="{{ $projects->nextPageUrl() }}">&rsaquo;</a></li>
                                @else
                                    <li class="page-item disabled"><span class="page-link">&rsaquo;</span></li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

        
@endsection
