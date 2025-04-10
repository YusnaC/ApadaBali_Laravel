@extends('layouts.app')

@section('title', 'Tambah Data Furniture')

@section('content')
    <!-- Back Button -->
    <div class="mb-4 ms-5">
        <a href="{{ route('furniture.index') }}" class="text-decoration-none text-dark d-inline-flex align-items-center">
            <i class='bx bx-arrow-back fs-2'></i>
        </a>
    </div>

    <!-- Main Content -->
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <div class="card shadow-sm rounded-0 p-md-5">
                <div class="card-body">
                    <h4 class="text-center mb-5 mt-5 fw-bold">{{ isset($furniture) ? 'Edit' : 'Tambah' }} Data Furniture</h4>

                    <!-- Form Section -->
                    <form action="{{ isset($furniture) ? route('furniture.update', $furniture->id) : route('furniture.store') }}" method="POST">
                        @csrf
                        @if(isset($furniture))
                            @method('PUT')
                        @endif

                        <div class="row">
                                <!-- ID Furniture -->
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label class="mb-2">ID Furniture</label>
                                        <input type="text" name="id_furniture" class="form-control bg-light text-muted"
                                            value="{{ old('id_furniture', isset($furniture) ? $furniture->id_furniture : $newId) }}" readonly>
                                    </div>
                                </div>

                                <!-- Tgl Pembuatan -->
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label for="tgl_pembuatan" class="form-label">Tgl Pembuatan</label>
                                        <input type="date" onfocus="this.showPicker()" class="form-control @error('tgl_pembuatan') is-invalid @enderror" 
                                            name="tgl_pembuatan" id="tgl_pembuatan" 
                                            value="{{ isset($furniture) ? $furniture->tgl_pembuatan->format('Y-m-d') : old('tgl_pembuatan') }}">
                                        @error('tgl_pembuatan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Row 2 -->
                            <div class="row">
                            <!-- Nama Furniture -->
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label for="nama_furniture" class="form-label">Nama Furniture</label>
                                    <input type="text" class="form-control @error('nama_furniture') is-invalid @enderror" 
                                        name="nama_furniture" id="nama_furniture" 
                                        value="{{ isset($furniture) ? $furniture->nama_furniture : old('nama_furniture') }}">
                                    @error('nama_furniture')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Jumlah Unit -->
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label for="jumlah_unit" class="form-label">Jumlah Unit</label>
                                    <input type="number" class="form-control @error('jumlah_unit') is-invalid @enderror" 
                                        name="jumlah_unit" id="jumlah_unit" 
                                        value="{{ isset($furniture) ? $furniture->jumlah_unit : old('jumlah_unit') }}">
                                    @error('jumlah_unit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>


                            <!-- Row 3 -->
                            <div class="row">
                                <!-- Harga Unit -->
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label for="harga_unit" class="form-label">Harga Unit</label>
                                        <input type="number" class="form-control @error('harga_unit') is-invalid @enderror" 
                                            name="harga_unit" id="harga_unit"
                                            value="{{ isset($furniture) ? (int)$furniture->harga_unit : old('harga_unit') }}">
                                        @error('harga_unit')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Lokasi -->
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label for="lokasi" class="form-label">Lokasi</label>
                                        <input type="text" class="form-control @error('lokasi') is-invalid @enderror" 
                                            name="lokasi" id="lokasi" 
                                            value="{{ isset($furniture) ? $furniture->lokasi : old('lokasi') }}">
                                        @error('lokasi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>


                            <!-- Row 4 -->
                             <div class="row">
                                 <div class="col-md-6">
                                     <label for="tgl_selesai" class="form-label">Tgl Selesai</label>
                                     <input type="date" class="form-control @error('tgl_selesai') is-invalid @enderror"
                                        onfocus="this.showPicker()" 
                                         name="tgl_selesai" id="tgl_selesai" 
                                         value="{{ isset($furniture) ? $furniture->tgl_selesai->format('Y-m-d') : old('tgl_selesai') }}">
                                     @error('tgl_selesai')
                                         <div class="invalid-feedback">{{ $message }}</div>
                                     @enderror
                                 </div>
                             </div>
                        </div>

                        <!-- Save Button -->
                        <div class="d-flex justify-content-center mt-3 mb-5">
                            <button type="submit" class="btn-save">{{ isset($furniture) ? 'Update' : 'Simpan' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const furnitureForm = document.querySelector('form');
        
        function showError(element, message) {
            const feedback = document.createElement('div');
            feedback.className = 'invalid-feedback';
            feedback.textContent = message;
            element.classList.add('is-invalid');
            element.parentNode.appendChild(feedback);
        }

        furnitureForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Hapus pesan validasi yang ada
            document.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
            document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            
            let hasError = false;
            
            // Validasi ID Furniture
            const idFurniture = document.getElementById('id_furniture');
            if (!idFurniture.value.trim()) {
                showError(idFurniture, 'ID Furniture tidak boleh kosong');
                hasError = true;
            }

            // Validasi Tanggal Pembuatan
            const tglPembuatan = document.getElementById('tgl_pembuatan');
            if (!tglPembuatan.value) {
                showError(tglPembuatan, 'Tanggal pembuatan tidak boleh kosong');
                hasError = true;
            }

            // Validasi Nama Furniture
            const namaFurniture = document.getElementById('nama_furniture');
            if (!namaFurniture.value.trim()) {
                showError(namaFurniture, 'Nama furniture tidak boleh kosong');
                hasError = true;
            }

            // Validasi Jumlah Unit
            const jumlahUnit = document.getElementById('jumlah_unit');
            if (!jumlahUnit.value || jumlahUnit.value < 1) {
                showError(jumlahUnit, 'Jumlah unit harus lebih dari 0');
                hasError = true;
            }

            // Validasi Harga Unit
            const hargaUnit = document.getElementById('harga_unit');
            if (!hargaUnit.value || hargaUnit.value < 0) {
                showError(hargaUnit, 'Harga unit tidak boleh kosong atau kurang dari 0');
                hasError = true;
            }

            // Validasi Lokasi
            const lokasi = document.getElementById('lokasi');
            if (!lokasi.value.trim()) {
                showError(lokasi, 'Lokasi tidak boleh kosong');
                hasError = true;
            }

            // Validasi Tanggal Selesai
            const tglSelesai = document.getElementById('tgl_selesai');
            if (!tglSelesai.value) {
                showError(tglSelesai, 'Tanggal selesai tidak boleh kosong');
                hasError = true;
            } else if (tglPembuatan.value && tglSelesai.value <= tglPembuatan.value) {
                showError(tglSelesai, 'Tanggal selesai harus lebih besar dari tanggal pembuatan');
                hasError = true;
            }
            
            // Submit form jika tidak ada error
            if (!hasError) {
                furnitureForm.submit();
            }
        });
    });
</script>