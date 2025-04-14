<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LaporanExport implements FromCollection, WithHeadings, WithMapping
{
    protected $data;
    protected $reportType;
    protected $rowNumber = 0;

    public function __construct($data, $reportType)
    {
        $this->data = $data;
        $this->reportType = $reportType;
    }

    public function collection()
    {
        return $this->data;
    }

    public function map($row): array
    {
        $this->rowNumber++;
        
        switch($this->reportType) {
            case 'pemasukan':
                return [
                    $this->rowNumber,
                    $row->jenis_order,
                    $row->id_order,
                    $row->tgl_transaksi,
                    $row->jumlah,
                    $row->termin,
                    $row->keterangan,
                ];
            case 'pengeluaran':
                return [
                    $this->rowNumber,
                    $row->tanggal_transaksi,
                    $row->nama_barang,
                    $row->jumlah,
                    $row->harga_satuan,
                    $row->total_harga,
                    $row->keterangan,
                ];
            case '1': // Proyek
                return [
                    $row->id_proyek,
                    $row->kategori == '1' ? 'Proyek Arsitektur' : ($row->kategori == '2' ? 'Jasa' : $row->kategori),
                    $row->tgl_proyek,
                    $row->nama_proyek,
                    $row->lokasi,
                    $row->luas,
                    $row->jumlah_lantai,
                    $row->tgl_deadline,
                    $row->id_drafter
                ];
            case '2': // Furniture
                return [
                    $row->id_furniture,
                    'Furniture',
                    $row->tgl_pembuatan,
                    $row->nama_furniture,
                    $row->lokasi,
                    $row->luas ?? '-',
                    $row->jumlah_unit,
                    $row->harga_unit,
                    $row->tgl_selesai,
                ];
            default:
                return [];
        }
    }

    public function headings(): array
    {
        switch($this->reportType) {
            case 'pemasukan':
                return [
                    'No',
                    'Jenis Order',
                    'ID Order',
                    'Tanggal Transaksi',
                    'Jumlah',
                    'Termin',
                    'Keterangan'
                ];
            case 'pengeluaran':
                return [
                    'No',
                    'Tanggal Transaksi',
                    'Nama Barang',
                    'Jumlah',
                    'Harga Satuan',
                    'Total Harga',
                    'Keterangan'
                ];
            case '1': // Proyek
                return [
                    'ID Proyek',
                    'Kategori',
                    'Tanggal Proyek',
                    'Nama Proyek',
                    'Lokasi',
                    'Luas (m²)',
                    'Jumlah Lantai',
                    'Deadline',
                    'ID Drafter'
                ];
            case '2': // Furniture
                return [
                    'ID Furniture',
                    'Kategori',
                    'Tanggal Pembuatan',
                    'Nama Furniture',
                    'Lokasi',
                    'Luas (m²)',
                    'Jumlah Unit',
                    'Harga Unit',
                    'Tanggal Selesai',
                    'ID Drafter'
                ];
            default:
                return [];
        }
    }
}