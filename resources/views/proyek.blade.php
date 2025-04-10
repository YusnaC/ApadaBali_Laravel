@extends('layouts.app')

@section('title', isset($proyek) ? 'Edit Data Proyek' : 'Tambah Data Proyek')

@section('content')

    <!-- Back Button -->
    <div class="mb-4 ms-5">
        <a href="/Pencatatan-Proyek" class="text-decoration-none text-dark d-inline-flex align-items-center">
            <i class='bx bx-arrow-back fs-2'></i>
        </a>
    </div>

    <!-- Main Content -->
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <div class="card shadow-sm rounded-0 p-md-5">
                <div class="card-body mb-16">
                    <h4 class="text-center mb-5 fw-bold mt-4">{{ isset($proyek) ? 'Edit Data Proyek' : 'Tambah Data Proyek' }}</h4>
                    
                    <form method="POST" id="projectForm" action="{{ isset($proyek) ? route('proyek.update', $proyek->id_proyek) : route('proyek.store') }}">
                        @csrf
                        @if(isset($proyek))
                            @method('PUT') <!-- Tambahkan jika edit -->
                        @endif

                        <div class="row g-3">
                            <!-- Row 1 -->
                            <div class="col-md-4 mb-3">
                                <label for="idProyek" class="form-label">Id Proyek</label>
                                <input name="id_proyek" 
                                       type="text" 
                                       class="form-control text-secondary bg-light text-muted" 
                                       id="idProyek" 
                                       value="{{ old('id_proyek', isset($proyek) ? $proyek->id_proyek : $newId) }}" 
                                       readonly>                            
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="kategori" class="form-label">Kategori</label>
                                <select name="kategori" class="form-select @error('ketegori') is-invalid @enderror" id="kategori">
                                    <option disabled>Pilih Kategori</option>
                                    <option value="1" data-prefix="ASB" {{ (old('kategori', isset($proyek) ? $proyek->kategori : '') == 1) ? 'selected' : '' }}>Proyek Arsitektur</option>
                                    <option value="2" data-prefix="AJB" {{ (old('kategori', isset($proyek) ? $proyek->kategori : '') == 2) ? 'selected' : '' }}>Jasa</option>
                                </select>
                                @error('ketegori')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="tglProyek" class="form-label">Tgl Proyek</label>
                                <input name="tgl_proyek" 
                                       type="date" 
                                       class="form-control form-control @error('tgl_proyek') is-invalid @enderror" 
                                       id="tglProyek"
                                       onfocus="this.showPicker()"
                                       pattern="\d{2}/\d{2}/\d{4}"
                                       data-date-format="DD/MM/YYYY"
                                       value="{{ old('tgl_proyek', isset($proyek) ? date('Y-m-d', strtotime($proyek->tgl_proyek)) : '') }}">
                                       @error('tgl proyek')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                            </div>

                            <!-- Row 2 -->
                            <div class="col-md-4 mb-3">
                                <label for="namaProyek" class="form-label">Nama Proyek</label>
                                <input name="nama_proyek" 
                                       type="text" 
                                       class="form-control @error('nama_proyek') is-invalid @enderror" 
                                       id="namaProyek"
                                       value="{{ old('nama_proyek', isset($proyek) ? $proyek->nama_proyek : '') }}">
                                @error('nama_proyek')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="lokasi" class="form-label">Lokasi</label>
                                <input name="lokasi" type="text" class="form-control" id="lokasi"
                                       value="{{ old('lokasi', isset($proyek) ? $proyek->lokasi : '') }}" >
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="luas" class="form-label">Luas</label>
                                <input name="luas" type="number" class="form-control" id="luas" step="any"
                                value="{{ old('luas', isset($proyek) ? floor($proyek->luas) : '') }}" />
                                </div>

                            <!-- Row 3 -->
                            <div class="col-md-4 mb-3">
                                <label for="jumlahLantai" class="form-label">Jumlah Lantai</label>
                                <input name="jumlah_lantai" type="number" class="form-control" id="jumlahLantai"
                                       value="{{ old('jumlah_lantai', isset($proyek) ? $proyek->jumlah_lantai : '') }}" >
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="tglDeadline" class="form-label">Tgl Deadline</label>
                                <input name="tgl_deadline" type="date" class="form-control" id="tglDeadline" onfocus="this.showPicker()"
                                       value="{{ old('tgl_deadline', isset($proyek) ? $proyek->tgl_deadline : '') }}" >
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="idDrafter" class="form-label">Id Drafter</label>
                                <select name="id_drafter" class="form-select" id="idDrafter">
                                    <option disabled>Pilih Drafter</option>
                                    <option value="0" {{ isset($proyek) && $proyek->id_drafter == 0 ? 'selected' : '' }}>-</option>
                                    @foreach($drafters as $drafter)
                                        <option value="{{ $drafter->id_drafter }}" 
                                            {{ isset($proyek) && $proyek->id_drafter == $drafter->id_drafter ? 'selected' : '' }}>
                                            {{ $drafter->id_drafter }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                        </div>

                        <!-- Save Button -->
                        <div class="d-flex justify-content-center mt-5 mb-5">
                            <button type="submit" class="btn-save pb-3" id="submitBtn">{{ isset($proyek) ? 'Update' : 'Simpan' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const kategoriSelect = document.getElementById('kategori');
    const idProyekInput = document.getElementById('idProyek');
    const projectForm = document.getElementById('projectForm');
    
    // Add form validation
    projectForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Remove any existing validation messages
        document.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        
        let hasError = false;
        
        // Validate kategori
        const kategori = document.getElementById('kategori');
        if (!kategori.value) {
            showError(kategori, 'Kategori harus dipilih');
            hasError = true;
        }

        // Validate tgl_proyek
        const tglProyek = document.getElementById('tglProyek');
        if (!tglProyek.value) {
            showError(tglProyek, 'Tanggal proyek harus diisi');
            hasError = true;
        }

        // Validate nama_proyek
        const namaProyek = document.getElementById('namaProyek');
        if (!namaProyek.value.trim()) {
            showError(namaProyek, 'Nama proyek harus diisi');
            hasError = true;
        }

        // Validate lokasi
        const lokasi = document.getElementById('lokasi');
        if (!lokasi.value.trim()) {
            showError(lokasi, 'Lokasi harus diisi');
            hasError = true;
        }

        // Validate luas
        const luas = document.getElementById('luas');
        if (!luas.value) {
            showError(luas, 'Luas harus diisi');
            hasError = true;
        }

        // Validate jumlah_lantai
        const jumlahLantai = document.getElementById('jumlahLantai');
        if (!jumlahLantai.value) {
            showError(jumlahLantai, 'Jumlah lantai harus diisi');
            hasError = true;
        }

        // Validate tgl_deadline
        const tglDeadline = document.getElementById('tglDeadline');
        if (!tglDeadline.value) {
            showError(tglDeadline, 'Tanggal deadline harus diisi');
            hasError = true;
        }

        // Validate id_drafter
        const idDrafter = document.getElementById('idDrafter');
        if (!idDrafter.value) {
            showError(idDrafter, 'Drafter harus dipilih');
            hasError = true;
        }
        
        // If no errors, submit the form
        if (!hasError) {
            projectForm.submit();
        }
    });

    function showError(element, message) {
        element.classList.add('is-invalid');
        const feedback = document.createElement('div');
        feedback.className = 'invalid-feedback';
        feedback.textContent = message;
        element.parentNode.appendChild(feedback);
    }

    // Existing kategori change handler
    kategoriSelect.addEventListener('change', async function () {
        let selectedOption = this.options[this.selectedIndex];
        let prefix = selectedOption.getAttribute('data-prefix'); 

        console.log("Kategori dipilih:", selectedOption.value); // Debug kategori yang dipilih
        console.log("Prefix yang dikirim ke API:", prefix); // Debug prefix

        if (!prefix) {
            console.warn("Prefix tidak ditemukan!");
            return;
        }

        try {
            let response = await fetch(`/api/get-latest-project-id?prefix=${prefix}`);
            let data = await response.json();

            console.log("Response dari API:", data); // Debug response dari API

            if (data.success) {
                idProyekInput.value = data.new_id;
            } else {
                console.error("Gagal mendapatkan ID proyek terbaru");
            }
        } catch (error) {
            console.error("Error saat mengambil data:", error);
        }
    });
});
</script>
@endpush

<!-- Add this CSS to your styles -->
@push('styles')
<style>
.invalid-feedback {
    display: block;
    color: #dc3545;
    font-size: 0.875em;
    margin-top: 0.25rem;
}

.is-invalid {
    border-color: #dc3545;
}

.form-label {
    color: #7F7F7F;
}

</style>
@endpush

