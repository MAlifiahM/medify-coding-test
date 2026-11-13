<?php

namespace App\Exports;

use App\Models\MasterItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class MasterItemExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithDrawings,
    WithCustomStartCell,
    WithColumnWidths,
    WithEvents
{
    private $items;

    public function __construct()
    {
        $this->items = MasterItem::with('kategori')->get();
    }

    public function collection()
    {
        return $this->items;
    }

    public function startCell(): string
    {
        return 'A1';
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode',
            'Nama',
            'Harga Beli',
            'Laba (%)',
            'Harga Jual',
            'Supplier',
            'Jenis',
            'Kategori',
            'Foto',
        ];
    }

    public function map($item): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $item->kode,
            $item->nama,
            $item->harga_beli,
            $item->laba,
            $item->harga_beli + ($item->harga_beli * $item->laba / 100),
            $item->supplier,
            $item->jenis,
            $item->kategori->pluck('name')->implode(', '),
            '',
        ];
    }

    public function drawings()
    {
        $drawings = [];

        foreach ($this->items as $index => $item) {
            if (!$item->foto) {
                continue;
            }

            $path = storage_path('app/public/' . $item->foto);

            if (!file_exists($path)) {
                continue;
            }

            $drawing = new Drawing();
            $drawing->setName($item->nama);
            $drawing->setDescription($item->nama);
            $drawing->setPath($path);
            $drawing->setHeight(70);
            $drawing->setCoordinates('J' . ($index + 2));

            // Gambar mengikuti cell ketika dipindahkan atau diubah ukurannya
            $drawing->setEditAs('oneCell');

            $drawings[] = $drawing;
        }

        return $drawings;
    }

    public function columnWidths(): array
    {
        return [
            'J' => 18,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                foreach ($this->items as $index => $item) {
                    $event->sheet->getRowDimension($index + 2)
                        ->setRowHeight(60);
                }
            },
        ];
    }
}
