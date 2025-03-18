@extends('layouts.app')

@section('title', 'Laporan Pemasukan')

@section('content')
<!-- Section utama untuk menampilkan laporan keuangan -->
<section id="main-content" class="col-md-12 ms-md-7">
    <div class="pencatatan-pemasukan-content">
        <div class="row">
            <div class="card shadow-sm rounded-0 py-4 px-3">
                <h4 class="mb-5 fw-bold">Laporan Keuangan</h4>

                <div class="input-form-keuangan mb-3">
                    <form action="{{ route('tables.laporanPemasukan') }}" method="GET" id="filterForm">
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <select name="jenis" class="form-select" style="width: 200px;" id="jenisSelect" onchange="this.form.submit()">
                                <option value="" class="text-secondary">Pilih Jenis</option>
                                <option value="1" {{ request('jenis') == '1' ? 'selected' : '' }}>Pemasukan</option>
                                <option value="2" {{ request('jenis') == '2' ? 'selected' : '' }}>Pengeluaran</option>
                            </select>
                            
                            <div class="input-group" style="width: 150px;"> 
                                <input type="text" name="tgl_awal" class="form-control" 
                                    placeholder="Tgl awal" onfocus="(this.type='date')" 
                                    onblur="(this.type='text')" value="{{ request('tgl_awal') }}">
                                <span class="input-group-text"><i class='bx bx-calendar'></i></span>
                            </div>

                            <div class="input-group" style="width: 150px;">
                                <input type="text" name="tgl_akhir" class="form-control" 
                                    placeholder="Tgl akhir" onfocus="(this.type='date')" 
                                    onblur="(this.type='text')" value="{{ request('tgl_akhir') }}">
                                <span class="input-group-text"><i class='bx bx-calendar'></i></span>
                            </div>

                            <div class="dropdown">
                                <button class="btn-export dropdown-toggle d-flex align-items-center gap-1" type="button" data-bs-toggle="dropdown">
                                    <i class='bx bx-export'></i>
                                    Export
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('pemasukan.export', request()->all()) }}">Excel</a></li>
                                    <li><a class="dropdown-item" href="{{ route('pemasukan.export.pdf', request()->all()) }}">PDF</a></li>
                                </ul>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Tabel Data -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="py-3 px-3" style="width: 7%;">
                                <a href="{{ route('tables.laporanPemasukan', array_merge(request()->query(), ['sort' => 'no', 'direction' => $sortField === 'no' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    No
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'no' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'no' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="py-3 px-3">
                                <a href="{{ route('tables.laporanPemasukan', array_merge(request()->query(), ['sort' => 'jenis_order', 'direction' => $sortField === 'jenis_order' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Jenis Order
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'jenis_order' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'jenis_order' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="py-3 px-3" style="width: 10%;">
                                <a href="{{ route('tables.laporanPemasukan', array_merge(request()->query(), ['sort' => 'id_order', 'direction' => $sortField === 'id_order' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    ID Order
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'id_order' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'id_order' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="py-3 px-3">
                                <a href="{{ route('tables.laporanPemasukan', array_merge(request()->query(), ['sort' => 'tgl_transaksi', 'direction' => $sortField === 'tgl_transaksi' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Tgl Transaksi
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'tgl_transaksi' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'tgl_transaksi' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="py-3 px-3" style="width: 10%;">
                                <a href="{{ route('tables.laporanPemasukan', array_merge(request()->query(), ['sort' => 'jumlah', 'direction' => $sortField === 'jumlah' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Jumlah
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'jumlah' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'jumlah' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="py-3 px-3" style="width: 10%;">
                                <a href="{{ route('tables.laporanPemasukan', array_merge(request()->query(), ['sort' => 'termin', 'direction' => $sortField === 'termin' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Termin
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'termin' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'termin' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="py-3 px-3">
                                <a href="{{ route('tables.laporanPemasukan', array_merge(request()->query(), ['sort' => 'keterangan', 'direction' => $sortField === 'keterangan' && $sortDirection === 'asc' ? 'desc' : 'asc'])) }}" class="text-white header-link">
                                    Keterangan
                                    <div class="sort-icons">
                                        <i class="bx bxs-up-arrow {{ $sortField === 'keterangan' && $sortDirection === 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bx bxs-down-arrow {{ $sortField === 'keterangan' && $sortDirection === 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($projects as $laporanPemasukan)
                            <tr>
                                <td>{{ $laporanPemasukan->id }}</td>
                                <td>{{ $laporanPemasukan->jenis_order }}</td>
                                <td>{{ $laporanPemasukan->id_order }}</td>
                                <td>{{ $laporanPemasukan->tgl_transaksi ? $laporanPemasukan->tgl_transaksi : $laporanPemasukan->tanggal_transaksi  }}</td>
                                <td>{{ $laporanPemasukan->jumlah }}</td>
                                <td>{{ $laporanPemasukan->termin }}</td>
                                <td>{{ $laporanPemasukan->keterangan }}</td>
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
                                    <a class="page-link" href="{{ route('tables.laporanPemasukan', array_merge(request()->query(), ['page' => $i])) }}">{{ $i }}</a>
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

<script>
document.getElementById('jenisSelect').addEventListener('change', function() {
    document.getElementById('filterForm').submit();
});
</script>

<style>
.input-form-keuangan form {
    width: 100%;
}
.input-form-keuangan .form-select,
.input-form-keuangan .input-group {
    min-width: 150px;
}
.btn-export {
    white-space: nowrap;
    padding: 6px 12px;
    background-color: #4285f4;
    color: white;
    border-radius: 4px;
    text-decoration: none;
}
.btn-export:hover {
    background-color: #357abd;
    color: white;
}
</style>
