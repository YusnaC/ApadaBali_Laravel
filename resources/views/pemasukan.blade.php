@extends('layouts.app')

@section('title', 'Tambah Data Pemasukan')

@push('styles')
<style>
    /* Base styles */
    .card {
        border: none;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .card {
            padding: 1rem !important;
        }
        
        .card-body {
            padding: 1rem !important;
        }
        
        h4 {
            font-size: 1.2rem;
            margin: 1.5rem 0 !important;
        }
        
        .form-label {
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }
        
        .form-control, .form-select {
            font-size: 0.9rem;
            padding: 0.5rem 0.75rem;
            margin-bottom: 0.5rem;
        }
        
        .row.mb-4 {
            margin-bottom: 0 !important;
        }
        
        .row.mb-4 > div {
            margin-bottom: 2rem !important;
            padding: 0 1rem !important;
        }
        
        .row.mb-4 > div:last-child {
            margin-bottom: 1rem !important;
        }
        
        .mb-4 {
            margin-bottom: 1.5rem !important;
        }
        
        .invalid-feedback {
            margin-bottom: 0.5rem;
        }
    }
    
    @media (max-width: 576px) {
        .card {
            padding: 0.75rem !important;
        }
        
        .card-body {
            padding: 0.75rem !important;
        }
        
        .row.mb-4 > div {
            margin-bottom: 1.25rem;
        }
        
        .mb-4 {
            margin-bottom: 1.25rem !important;
        }
        
        .form-control, .form-select {
            margin-bottom: 0.75rem;
        }
    }
    
    @media (max-width: 768px) {
        .row.mb-4 > div {
            margin-bottom: 2rem !important;
        }
        
        .row.mb-4 > div:last-child {
            margin-bottom: 2rem !important;
        }
        
        .form-label {
            margin-bottom: 0.75rem !important;
        }
        
        .form-control, .form-select {
            height: 45px;
            margin-bottom: 1rem !important;
        }
        
        .invalid-feedback {
            display: block;
            margin-top: -0.75rem;
            margin-bottom: 1rem;
        }
        
        /* Adjust specific row spacing */
        .row.mb-4:first-of-type {
            margin-bottom: 1rem !important;
        }
        
        .row.mb-4:not(:first-of-type) {
            margin-top: 1rem !important;
        }
    }
    
    @media (max-width: 768px) {
        .card {
            padding: 0.5rem !important;
        }
        
        .card-body {
            padding: 0.5rem !important;
        }
        
        .form-label {
            font-size: 0.9rem;
            margin-bottom: 0.5rem !important;
            display: block;
        }
        
        .form-control, .form-select {
            height: 45px;
            margin-bottom: 1.5rem !important;
        }
        
        .row.mb-4 > div {
            padding: 0 0.5rem !important;
            margin-bottom: 0 !important;
        }
        
        .mb-4 {
            margin-bottom: 1.5rem !important;
        }
        
        .custom-textarea {
            height: auto !important;
        }
        
        /* Remove extra margins from rows */
        .row {
            margin-left: 0 !important;
            margin-right: 0 !important;
        }
    }
    
    @media (max-width: 768px) {
        /* Clean up existing styles first */
        .row.mb-4 {
            margin: 0 !important;
        }
        
        .row.mb-4 > div {
            margin-bottom: 1.5rem !important;
            padding: 0 !important;
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.5rem !important;
        }
        
        .form-select, .form-control {
            height: 45px !important;
            margin-bottom: 0 !important;
        }
        
        .invalid-feedback {
            margin-top: 0.25rem !important;
            margin-bottom: 0 !important;
        }
        
        /* Specific spacing for the first row */
        .row.mb-4:first-of-type > div:first-child {
            margin-bottom: 1.5rem !important;
        }
    }
    
    @media (max-width: 768px) {
        /* Form spacing adjustments */
        .form-label {
            margin-bottom: 0.5rem !important;
        }
        
        .form-control, .form-select {
            height: 45px !important;
            margin-bottom: 1.5rem !important;
        }
        
        .row.mb-4 > div {
            margin-bottom: 1rem !important;
        }
        
        /* Single column inputs */
        .mb-4 {
            margin-bottom: 1.5rem !important;
        }
        
        /* Textarea specific */
        .custom-textarea {
            height: auto !important;
            margin-bottom: 1.5rem !important;
        }
        
        /* Error message spacing */
        .invalid-feedback {
            margin-top: -1.25rem !important;
            margin-bottom: 1.5rem !important;
            display: block;
        }
    }
    
    @media (max-width: 768px) {
        /* Form group spacing */
        .row.mb-4 > div {
            margin-bottom: 2.5rem !important;
        }
        
        /* Form label spacing */
        .form-label {
            margin-bottom: 0.75rem !important;
            font-weight: 500;
        }
        
        /* Form control spacing */
        .form-select, .form-control {
            height: 45px !important;
            margin-bottom: 0.5rem !important;
        }
        
        /* Error message positioning */
        .invalid-feedback {
            margin-top: 0.25rem !important;
        }
        
        /* First row specific spacing */
        .row.mb-4:first-of-type {
            margin-bottom: 1rem !important;
        }
        
        /* Add padding to card for better spacing */
        .card-body {
            padding: 1.5rem !important;
        }
    }
</style>
@endpush

@section('content')

     <!-- Back Button -->
     <div class="mb-4 ms-5">
        <a href="{{ route('tables.pemasukanKeuangan') }}" class="text-decoration-none text-dark d-inline-flex align-items-center">
            <i class='bx bx-arrow-back fs-2'></i>
        </a>
    </div>

    <!-- Main Content -->
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <div class="card shadow-sm rounded-0 p-md-5">
                <div class="card-body px-md-5">
                    <h4 class="text-center mb-5 mt-5 fw-bold">
                        {{ isset($pemasukan) ? 'Edit Data Pemasukan' : 'Tambah Data Pemasukan' }}
                    </h4>

                    <!-- Form Section -->
                    <form action="{{ isset($pemasukan) ? route('pemasukan.update', $pemasukan->id) : route('pemasukan.store') }}" method="POST">
                        @csrf
                        @if(isset($pemasukan))
                            @method('PUT')
                        @endif

                        <!-- Row 1 -->
                        <div class="row mb-4">
                            <div class="col-md-6 pb-md-0 pb-4">
                                <label for="jenis_order" class="form-label">Jenis Order</label>
                                <select name="jenis_order" class="form-select @error('id_order') is-invalid @enderror" id="jenis_order">
                                    <option disabled selected>Pilih Jenis Order</option>
                                    <option value="Proyek Arsitektur" {{ old('jenis_order', isset($pemasukan) ? $pemasukan->jenis_order : '') == 'Proyek Arsitektur' ? 'selected' : '' }}>Proyek Arsitektur</option>
                                    <option value="Furniture" {{ old('jenis_order', isset($pemasukan) ? $pemasukan->jenis_order : '') == 'Furniture' ? 'selected' : '' }}>Furniture</option>
                                    <option value="Jasa" {{ old('jenis_order', isset($pemasukan) ? $pemasukan->jenis_order : '') == 'Jasa' ? 'selected' : '' }}>Jasa</option>

                                </select>
                                @error('jenis_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="id_order" class="form-label">Id Order</label>
                                <select name="id_order" class="form-select @error('id_order') is-invalid @enderror" id="id_order">
                                    <option value="" disabled selected>Pilih ID Order</option>
                                </select>
                                @error('id_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Row 2 -->
                        <div class="row mb-4">
                            <div class="col-md-6 pb-md-0 pb-4">
                                <label for="tgl_transaksi" class="form-label">Tgl Transaksi</label>
                                <input type="date" name="tgl_transaksi" id="tgl_transaksi" onfocus="this.showPicker()"
                                       class="form-control @error('tgl_transaksi') is-invalid @enderror"
                                       value="{{ isset($pemasukan) ? date('Y-m-d', strtotime($pemasukan->tgl_transaksi)) : old('tgl_transaksi') }}">
                                @error('tgl_transaksi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="jumlah" class="form-label">Jumlah</label>
                                <input type="number" name="jumlah" id="jumlah" 
                                       class="form-control @error('jumlah') is-invalid @enderror"
                                       value="{{ isset($pemasukan) ? (int)$pemasukan->jumlah : old('jumlah') }}">
                                @error('jumlah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Row 3 -->
                        <div class="mb-4">
                            <label for="termin" class="form-label">Termin</label>
                            <input type="number" name="termin" id="termin" 
                                   class="form-control @error('termin') is-invalid @enderror"
                                   value="{{ isset($pemasukan) ? $pemasukan->termin : old('termin') }}">
                            @error('termin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Row 4 -->
                        <div class="mb-4">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" 
                                      class="form-control custom-textarea @error('keterangan') is-invalid @enderror" 
                                      rows="3">{{ isset($pemasukan) ? $pemasukan->keterangan : old('keterangan') }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Save Button -->
                        <div class="d-flex justify-content-center mt-5 mb-5">
                            <button type="submit" class="btn-save">
                                {{ isset($pemasukan) ? 'Update' : 'Simpan' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const jenisOrderSelect = document.getElementById('jenis_order');
    const idOrderSelect = document.getElementById('id_order');
    
    const proyekOrders = @json($proyekOrders);
    const furnitureOrders = @json($furnitureOrders);
    
    function populateIdOrder(selectedValue = null) {
        const currentSelection = idOrderSelect.value;
        idOrderSelect.innerHTML = '<option disabled selected>Pilih ID Order</option>';
        
        if (jenisOrderSelect.value === 'Proyek Arsitektur') {
            proyekOrders.forEach(order => {
                const orderId = order.id_proyek.startsWith('ASB') ? order.id_proyek : null;
                if (orderId) {
                    addOption(orderId, selectedValue, currentSelection);
                }
            });
        } else if (jenisOrderSelect.value === 'Furniture') {
            furnitureOrders.forEach(order => {
                const orderId = order.id_furniture.startsWith('AFB') ? order.id_furniture : null;
                if (orderId) {
                    addOption(orderId, selectedValue, currentSelection);
                }
            });
        } else if (jenisOrderSelect.value === 'Jasa') {
            proyekOrders.forEach(order => {
                const orderId = order.id_proyek.startsWith('AJB') ? order.id_proyek : null;
                if (orderId) {
                    addOption(orderId, selectedValue, currentSelection);
                }
            });
        }
    }

    function addOption(orderId, selectedValue, currentSelection) {
        const option = new Option(orderId, orderId);
        if ((selectedValue && selectedValue === orderId) || 
            (currentSelection && currentSelection === orderId)) {
            option.selected = true;
        }
        idOrderSelect.add(option);
    }
    
    jenisOrderSelect.addEventListener('change', function() {
        populateIdOrder();
    });
    
    // Initialize the form with old input values if they exist
    const oldJenisOrder = "{{ old('jenis_order', isset($pemasukan) ? $pemasukan->jenis_order : '') }}";
    const oldIdOrder = "{{ old('id_order', isset($pemasukan) ? $pemasukan->id_order : '') }}";
    
    if (oldJenisOrder) {
        jenisOrderSelect.value = oldJenisOrder;
        populateIdOrder(oldIdOrder);
    }
    
    // Auto-select values when editing
    @if(isset($pemasukan))
        if (!oldJenisOrder) {
            jenisOrderSelect.value = '{{ $pemasukan->jenis_order }}';
            populateIdOrder('{{ $pemasukan->id_order }}');
        }
    @endif
});
</script>
@endpush

