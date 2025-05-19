<?php

namespace Modules\Basicdata\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Modules\Basicdata\Models\HolidayCalendar;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class HolidayCalendarExport implements WithColumnFormatting, WithHeadings, FromCollection, WithMapping
{
    protected $search;

    public function __construct($search = null)
    {
        $this->search = $search;
    }

    public function collection()
    {
        $query = HolidayCalendar::query();

        if (!empty($this->search)) {
            $search = $this->search;
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(description) LIKE ?', ['%' . strtolower($search) . '%'])
                  ->orWhereRaw('LOWER(type) LIKE ?', ['%' . strtolower($search) . '%'])
                  ->orWhereRaw('CAST(date AS TEXT) LIKE ?', ['%' . $search . '%']);
            });
        }

        return $query->get();
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->date,
            $row->description,
            $row->type,
            $row->created_at,
            $row->updated_at
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Date',
            'Description',
            'Type',
            'Created At',
            'Updated At'
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_NUMBER,
            'B' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'E' => NumberFormat::FORMAT_DATE_DATETIME,
            'F' => NumberFormat::FORMAT_DATE_DATETIME
        ];
    }
}
