@extends('layouts.app')

@section('title', isset($progres) ? 'Edit Data Progres' : 'Tambah Data Progres')

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
                <div class="card-body p-md-5">
                  
                    <h4 class="mb-5 text-center fw-bold font-weight-bold mt-5" style="font-weight: 900 !important;">{{ isset($progres) ? 'Edit Data Progres' : 'Tambah Data Progres' }}</h4>

                    <form action="{{ isset($progres) ? route('progres.update', ['id' => $progres->id_progres]) : route('progres.store') }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf
                        @if(isset($progres))
                            @method('PUT')
                        @endif

                        <div class="row g-3 mb-4">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class="mb-2">Id Proyek</label>
                                    <select name="id_proyek" class="form-select @error('id_proyek') is-invalid border-danger @enderror {{ isset($progres) ? 'bg-light text-secondary' : '' }}" {{ isset($progres) ? 'disabled' : '' }}>
                                    @foreach($projects as $project)
                                        @php
                                            $drafter = DB::table('drafter')
                                                ->where('nama_drafter', auth()->user()->name)
                                                ->first();
                                        @endphp
                                        @if($project->id_drafter == ($drafter ? $drafter->id_drafter : '0'))
                                            <option value="{{ $project->id_proyek }}" 
                                                {{ (old('id_proyek', isset($progres) ? $progres->id_proyek : '')) == $project->id_proyek ? 'selected' : '' }}>
                                                {{ $project->id_proyek }}
                                            </option>
                                        @endif
                                    @endforeach
                                    </select>
                                    @error('id_proyek')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class="mb-2">Tgl Progres</label>
                                    <input type="date" 
                                        name="tgl_progres" 
                                        class="form-control @error('tgl_progres') is-invalid border-danger @enderror"
                                        value="{{ old('tgl_progres', isset($progres) ? \Carbon\Carbon::parse($progres->tgl_progres)->format('Y-m-d') : '') }}"
                                        onfocus="this.showPicker()">
                                    @error('tgl_progres')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label class="mb-2">Progres (%)</label>
                            <input type="number" name="progres" class="form-control @error('progres') is-invalid border-danger @enderror" 
                                   min="0" max="100" value="{{ old('progres', isset($progres) ? $progres->progres : '') }}" >
                            @error('progres')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label class="mb-2">Keterangan</label>
                            <input type="text" name="keterangan" class="form-control @error('keterangan') is-invalid border-danger @enderror" 
                                   value="{{ old('keterangan', isset($progres) ? $progres->keterangan : '') }}">
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <style>
                            @media (max-width: 768px) {
                                .upload-box {
                                    flex-direction: column;
                                    align-items: stretch;
                                    padding: 1rem;
                                    gap: 0.5rem;
                                }
                                
                                .btn-upload {
                                    width: 100%;
                                    margin: 0;
                                }
                                
                                .file-name {
                                    margin: 0;
                                    word-break: break-all;
                                    text-align: center;
                                    padding: 0.5rem;
                                }
                            }
                        </style>
                        
                        <div class="form-group mb-5">
                            <label class="mb-2">Upload Dokumen</label>
                            <div class="upload-box @error('dokumen') border-danger @enderror">
                                <button type="button" class="btn btn-upload" onclick="document.getElementById('dokumen').click()">
                                    Choose Files
                                </button>
                                <span class="file-name" id="fileNameDisplay">
                                    {{ isset($progres) && $progres->dokumen ? basename($progres->dokumen) : 'No file chosen' }}
                                </span>
                                <input type="file" id="dokumen" name="dokumen" 
                                       class="d-none @error('dokumen') is-invalid @enderror" 
                                       accept=".zip,.rar,.pdf"
                                       onchange="updateFileName(this)">
                            </div>
                            @error('dokumen')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted mt-2 d-block">Allowed file types: ZIP, RAR, PDF maximum size: 30MB</small>
                        </div>

                        <div class="text-center mb-5">
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary px-5">
                                    {{ isset($progres) ? 'Update' : 'Simpan' }}
                                </button>
                            </div>
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
    border-radius: 0; /* Remove rounded corners */
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
    color: #000000;
}

.upload-box {
    background-color: #F8F9FA;
    border: 1px solid #E5E5E5;
    border-radius: 8px;
    display: flex;
    align-items: center;
}

.btn-upload {
    background: #F3F3F3;
    border: 1px solid #E5E5E5;
    border-radius: 6px;
    padding: 8px 16px;
    color: #555;
}

.file-name {
    color: #666;
    margin-left: 10px;
}
</style>

<script>
function updateFileName(input) {
    const fileName = input.files[0] ? input.files[0].name : 'No file chosen';
    document.getElementById('fileNameDisplay').textContent = fileName;
}
</script>
@endsection