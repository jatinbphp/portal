<?php

namespace App\Exports;

use App\Models\StockOrder;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;

class OrderExport implements FromCollection, WithHeadings, WithCustomCsvSettings, WithStyles
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function collection(): Collection
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        return [
            "Ref#",
            "Date Ordered",
            "Supplier",
            "Brand",
            "Practice",
            "Comments",
            "Status",
            "Date Received",
            "Invoice Number",
            "GRV Number",
            "Additional Notes",
        ];
    }

    public function getCsvSettings(): array
    {
        return [
            'encoding' => 'UTF-8',
        ];
    }

    public function styles($sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
