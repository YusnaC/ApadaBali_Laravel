@extends('layouts.app')

@section('title', isset($progres) ? 'Edit Data Progress' : 'Tambah Data Progress')

@section('content')
<div class="mb-4 ms-5">
    <a href="{{ route('tables.progresproyek') }}" class="text-decoration-none text-dark d-inline-flex align-items-center">
        <i class='bx bx-arrow-back fs-2'></i>
    </a>
</div>
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body p-5">
                    <h4 class="mb-5">{{ isset($progres) ? 'Edit Data Progress' : 'Tambah Data Progress' }}</h4>
                    
                    @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ isset($progres) ? route('proyek.progress.update', ['id' => $progres->id_progres]) : route('progres.store') }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf
                        @if(isset($progres))
                            @method('PUT')
                        @endif

                        <div class="row mb-4">
                            <div class="col-md-6 pe-5">
                                <div class="form-group">
                                    <label class="mb-2">Id Proyek</label>
                                    <select name="id_proyek" class="form-select @error('id_proyek') is-invalid @enderror" {{ isset($progres) ? 'disabled' : 'required' }}>
                                        <option value="">Pilih ID Proyek</option>
                                        @foreach($projects as $project)
                                            <option value="{{ $project->id_proyek }}" 
                                                {{ (old('id_proyek', isset($progres) ? $progres->id_proyek : '')) == $project->id_proyek ? 'selected' : '' }}>
                                                {{ $project->id_proyek }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if(isset($progres))
                                        <input type="hidden" name="id_proyek" value="{{ $progres->id_proyek }}">
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="mb-2">Tgl Progress</label>
                                    <input type="date" name="tgl_progres" class="form-control @error('tgl_progres') is-invalid @enderror" 
                                           value="{{ old('tgl_progres', isset($progres) ? $progres->tgl_progres : '') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label class="mb-2">Status Progress</label>
                            <select name="status_progres" class="form-select @error('status_progres') is-invalid @enderror" required>
                                <option value="">Pilih Status</option>
                                <option value="Proses" {{ old('status_progres', isset($progres) ? $progres->status_progres : '') == 'Proses' ? 'selected' : '' }}>Proses</option>
                                <option value="Selesai" {{ old('status_progres', isset($progres) ? $progres->status_progres : '') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </div>

                        <div class="form-group mb-4">
                            <label class="mb-2">Progres (%)</label>
                            <input type="number" name="progres" class="form-control @error('progres') is-invalid @enderror" 
                                   min="0" max="100" value="{{ old('progres', isset($progres) ? $progres->progres : '') }}" required>
                        </div>

                        <div class="form-group mb-4">
                            <label class="mb-2">Keterangan</label>
                            <input type="text" name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" 
                                   value="{{ old('keterangan', isset($progres) ? $progres->keterangan : '') }}">
                        </div>

                        <div class="form-group mb-5">
                            <label class="mb-2">Upload Dokumen (PDF, DOC, DOCX, ZIP max 2MB)</label>
                            <div class="d-flex">
                                <button type="button" class="btn btn-light me-2" onclick="document.getElementById('dokumen').click()">
                                    Choose Files
                                </button>
                                <span class="form-control border-0">
                                    {{ isset($progres) && $progres->dokumen ? basename($progres->dokumen) : 'No file chosen' }}
                                </span>
                                <input type="file" id="dokumen" name="dokumen" 
                                       class="d-none @error('dokumen') is-invalid @enderror" 
                                       accept=".pdf,.doc,.docx,.zip"
                                       onchange="updateFileName(this)" 
                                       {{ isset($progres) ? '' : 'required' }}>
                            </div>
                            @error('dokumen')
                                <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                            @enderror
                            <small class="text-muted mt-2 d-block">Allowed file types: PDF, DOC, DOCX, ZIP, maximum size: 2MB</small>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary px-5">
                                {{ isset($progres) ? 'Update' : 'Simpan' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border: none;
    box-shadow: 0 0 15px rgba(0,0,0,0.05);
}

.form-control, .form-select {
    border: 1px solid #E5E5E5;
    padding: 12px 16px;
    border-radius: 4px;
    height: 45px;
}

.btn-light {
    background: #F3F3F3;
    border: 1px solid #E5E5E5;
    padding: 8px 16px;
}

.btn-primary {
    background-color: #FF6B35;
    border: none;
    padding: 12px 40px;
    border-radius: 4px;
}

.btn-primary:hover {
    background-color: #e65e2f;
}

label {
    color: #555;
}
</style>

<script>
function updateFileName(input) {
    const fileName = input.files[0] ? input.files[0].name : 'No file chosen';
    input.parentElement.querySelector('span').textContent = fileName;
}
</script>
@endsection