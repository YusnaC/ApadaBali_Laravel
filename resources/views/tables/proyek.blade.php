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
                            <form method="GET" action="{{ route('tables.proyek') }}" id="search-form" class="d-flex search-form">
                                <div class="input-group me-2">
                                    <span class="input-group-text"><i class="bx bx-search"></i></span>
                                    <input type="text" name="search" id="search-input" class="form-control search-input" placeholder="Search..." value="{{ request('search') }}" onkeyup="handleSearch(event)"/>
                                </div>
                            </form>

                            <!-- Tombol untuk menambah data proyek -->
                            <a href="/Tambah-Data-Proyek" class="btn-add fw-bold py-3 px-4">+ Tambah</a>
                        </div>
                    </div>

                    <!-- Tabel Data Proyek -->
                    <table class="table table-bordered ">
                    <thead>
                    <tr>
                        <th>
                            <a href="{{ route('tables.proyek', array_merge(request()->query(), ['sort' => 'id_proyek', 'direction' => $sortField === 'id_proyek' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                Id Proyek
                                <div class="sort-icons">
                                    <i class="bx bxs-up-arrow {{ $sortField === 'id_proyek' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                    <i class="bx bxs-down-arrow {{ $sortField === 'id_proyek' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                </div>
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('tables.proyek', array_merge(request()->query(), ['sort' => 'kategori', 'direction' => $sortField === 'kategori' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                Kategori
                                <div class="sort-icons">
                                    <i class="bx bxs-up-arrow {{ $sortField === 'kategori' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                    <i class="bx bxs-down-arrow {{ $sortField === 'kategori' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                </div>
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('tables.proyek', array_merge(request()->query(), ['sort' => 'tgl_proyek', 'direction' => $sortField === 'tgl_proyek' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                Tgl Proyek
                                <div class="sort-icons">
                                    <i class="bx bxs-up-arrow {{ $sortField === 'tgl_proyek' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                    <i class="bx bxs-down-arrow {{ $sortField === 'tgl_proyek' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                </div>
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('tables.proyek', array_merge(request()->query(), ['sort' => 'nama_proyek', 'direction' => $sortField === 'nama_proyek' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                Nama Proyek
                                <div class="sort-icons">
                                    <i class="bx bxs-up-arrow {{ $sortField === 'nama_proyek' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                    <i class="bx bxs-down-arrow {{ $sortField === 'nama_proyek' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                </div>
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('tables.proyek', array_merge(request()->query(), ['sort' => 'lokasi', 'direction' => $sortField === 'lokasi' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                Lokasi
                                <div class="sort-icons">
                                    <i class="bx bxs-up-arrow {{ $sortField === 'lokasi' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                    <i class="bx bxs-down-arrow {{ $sortField === 'lokasi' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                </div>
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('tables.proyek', array_merge(request()->query(), ['sort' => 'luas', 'direction' => $sortField === 'luas' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                Luas (m²)
                                <div class="sort-icons">
                                    <i class="bx bxs-up-arrow {{ $sortField === 'luas' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                    <i class="bx bxs-down-arrow {{ $sortField === 'luas' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                </div>
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('tables.proyek', array_merge(request()->query(), ['sort' => 'jumlah_lantai', 'direction' => $sortField === 'jumlah_lantai' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                Jumlah Lantai
                                <div class="sort-icons">
                                    <i class="bx bxs-up-arrow {{ $sortField === 'jumlah_lantai' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                    <i class="bx bxs-down-arrow {{ $sortField === 'jumlah_lantai' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                </div>
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('tables.proyek', array_merge(request()->query(), ['sort' => 'tgl_deadline', 'direction' => $sortField === 'tgl_deadline' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                Tgl Deadline
                                <div class="sort-icons">
                                    <i class="bx bxs-up-arrow {{ $sortField === 'tgl_deadline' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                    <i class="bx bxs-down-arrow {{ $sortField === 'tgl_deadline' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                </div>
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('tables.proyek', array_merge(request()->query(), ['sort' => 'id_drafter', 'direction' => $sortField === 'id_drafter' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                Id Drafter
                                <div class="sort-icons">
                                    <i class="bx bxs-up-arrow {{ $sortField === 'id_drafter' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                    <i class="bx bxs-down-arrow {{ $sortField === 'id_drafter' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                </div>
                            </a>
                        </th>
                        <th>
                        <a href="{{ route('tables.proyek', array_merge(request()->query(), ['sort' => 'aksi', 'direction' => $sortField === 'aksi' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
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
                    @if($projects->isEmpty())
                        <tr>
                            <td colspan="10" class="text-center text-muted">Tidak ada data proyek tersedia.</td>
                        </tr>
                    @else
                    @php
                        $kategoriList = [
                            1 => 'Proyek Arsitektur',
                            2 => 'Jasa'
                        ];
                    @endphp
                        @forelse($projects as $proyek)
                            <tr> 
                                    <td>{{ $proyek['id_proyek'] }}</td>
                                    <td class="text-start">{{ $kategoriList[$proyek['kategori']] }}</td>
                                    <td>{{ \Carbon\Carbon::parse($proyek->tgl_proyek)->format('d/m/Y')  }}</td>
                                    <td>{{ $proyek['nama_proyek'] }}</td>
                                    <td class="text-start">{{ $proyek['lokasi'] }}</td>
                                    <td>{{ fmod($proyek['luas'], 1) == 0 ? number_format($proyek['luas'], 0) : rtrim(rtrim(number_format($proyek['luas'], 2, '.', ''), '0'), '.') }}</td>
                                    <td>{{ $proyek['jumlah_lantai'] }}</td>
                                    <td>{{ \Carbon\Carbon::parse($proyek->tgl_deadline)->format('d/m/Y')  }}</td>
                                    <td>{{ $proyek->drafter->id_drafter ?? 'Tidak Ada Drafter' }}</td>
                                    <td>
                                        <div class="button-container">
                                        <a href="{{ route('proyek.edit', $proyek->id_proyek) }}" class="btn btn-edit">
                                            <i class="bx bx-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('proyek.destroy', $proyek->id_proyek) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus proyek ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-delete">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </form>
                                        </div>
                                    </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>

                    </table>

                    <!-- Pagination untuk navigasi antar halaman -->
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
        
@endsection

<script>
function handleSearch(event) {
    event.preventDefault(); // Menghindari submit otomatis
    let searchQuery = event.target.value;
    let url = new URL(window.location.href);
    url.searchParams.set('search', searchQuery);
    history.pushState({}, '', url); // Memperbarui URL tanpa reload

    // Panggil AJAX untuk mengambil hasil pencarian tanpa refresh
    fetch(url)
        .then(response => response.text())
        .then(html => {
            let parser = new DOMParser();
            let doc = parser.parseFromString(html, 'text/html');
            let newTable = doc.querySelector('table');
            document.querySelector('table').replaceWith(newTable);
        });
}
</script>
