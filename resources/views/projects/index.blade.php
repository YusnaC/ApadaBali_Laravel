@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Pencatatan Proyek</h1>

    <!-- Tombol Tambah dan Search -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <form method="GET" action="{{ route('projects.index') }}" class="d-flex">
            <input 
                type="text" 
                name="search" 
                class="form-control me-2" 
                placeholder="Search..." 
                value="{{ request('search') }}"
            />
            <button class="btn btn-primary" type="submit">Search</button>
        </form>
        <button class="btn btn-primary">+ Tambah</button>
    </div>

    <!-- Tabel Data -->
    <table class="table table-striped table-bordered">
        <thead class="bg-primary text-white">
            <tr>
                <!-- Header dengan Sorting -->
                <th>
                    <a href="{{ route('projects.index', array_merge(request()->all(), ['sort' => 'id_proyek', 'direction' => $sortField === 'id_proyek' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}">
                        Id Proyek
                        @if ($sortField === 'id_proyek')
                            <span>{{ $sortDirection === 'asc' ? '🔼' : '🔽' }}</span>
                        @endif
                    </a>
                </th>
                <th>
                    <a href="{{ route('projects.index', array_merge(request()->all(), ['sort' => 'kategori', 'direction' => $sortField === 'kategori' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}">
                        Kategori
                        @if ($sortField === 'kategori')
                            <span>{{ $sortDirection === 'asc' ? '🔼' : '🔽' }}</span>
                        @endif
                    </a>
                </th>
                <th>
                    <a href="{{ route('projects.index', array_merge(request()->all(), ['sort' => 'tgl_proyek', 'direction' => $sortField === 'tgl_proyek' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}">
                        Tgl Proyek
                        @if ($sortField === 'tgl_proyek')
                            <span>{{ $sortDirection === 'asc' ? '🔼' : '🔽' }}</span>
                        @endif
                    </a>
                </th>
                <th>Nama Proyek</th>
                <th>Lokasi</th>
                <th>Jenis</th>
                <th>Luas (m²)</th>
                <th>Jumlah Lantai</th>
                <th>Tgl Deadline</th>
                <th>Id Drafter</th>
                <th>Aksi</th>
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
                    <button class="btn btn-primary btn-sm">Edit</button>
                    <button class="btn btn-danger btn-sm">Hapus</button>
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
                        <a class="page-link" href="{{ route('projects.index', array_merge(request()->all(), ['page' => $i])) }}">
                            {{ $i }}
                        </a>
                    </li>
                @endfor
            </ul>
        </nav>
    </div>
</div>
@endsection
