@extends('layouts.app')

@section('title', 'Pencatatan Proyek')

@section('content')
<!-- Section utama untuk menampilkan pencatatan furniture -->
<section id="main-content" class="col-md-12 ms-md-7">
    <div class="pencatatan-furniture-content">
    <div class="mb-3">
        <a href="{{ route('proyek.progress') }}" class="text-decoration-none text-dark">
            <i class='bx bx-arrow-back fs-2'></i>
        </a>
    </div>
    <div class="card p-md-5 p-3 mb-5 shadow-sm border-0 wider-card rounded-0">
        <h3 class="text-center mb-5 mt-5 fw-bold">Detail Progres Proyek</h3>
        <div class="row g-4">
            <div class="col-md-4">
                <small class="text-muted d-block">Id Proyek</small>
                <input type="text" class="form-control bg-light text-secondary py-3" 
                    value="{{ $progres->id_proyek ?? 'ASB0001' }}" readonly>
            </div>
            <div class="col-md-4">
                <small class="text-muted d-block">Nama Proyek</small>
                <input type="text" class="form-control bg-light text-secondary py-3" 
                    value="{{ $progres->proyek->nama_proyek ?? 'Proyek1' }}" readonly>
            </div>
            <div class="col-md-4">
                <small class="text-muted d-block">Id Drafter</small>
                <input type="text" class="form-control bg-light text-secondary py-3" 
                    value="{{ $progres->proyek->drafter_id ?? 'D0001' }}" readonly>
            </div>
        </div>


        <!-- Progress Files Table -->
        <div class="table-responsive mt-md-4 mb-5">
            <table class="table align-middle no-striping  table-bordered">
                <thead class="table-light">
                    <tr>
                        <th class=" py-4">Nama File</th>
                        <th class=" py-4">Tgl Progres</th>
                        <th class=" py-4">Keterangan</th>
                        <th class="text-center py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($progres_files ?? [] as $file)
                    <tr>
                        <td class="text-start">
                            <!-- <div class="d-flex align-items-center"> -->
                                <i class='bx bx-file-blank text-primary fs-5 me-2'></i>
                                {{ basename($file->dokumen) }}
                            <!-- </div> -->
                        </td>
                        <td>{{ \Carbon\Carbon::parse($file->tgl_progres)->format('d/m/Y') }}</td>
                        <td class="text-start">{{ $file->keterangan }}</td>
                        <td class="text-center">
                            <a href="{{ route('progres.download', ['id_proyek' => $file->id_proyek]) }}" 
                               class="btn btn-success btn-sm d-flex align-items-center gap-1">
                                <i class='bx bx-download'></i> DOWNLOAD
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada file progres</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    </div>
</section>
@endsection


