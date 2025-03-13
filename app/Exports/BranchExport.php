<?php

    namespace Modules\Basicdata\Exports;

    use Maatwebsite\Excel\Concerns\FromCollection;
    use Maatwebsite\Excel\Concerns\WithColumnFormatting;
    use Maatwebsite\Excel\Concerns\WithHeadings;
    use Maatwebsite\Excel\Concerns\WithMapping;
    use Modules\Basicdata\Models\Branch;
    use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

    class BranchExport implements WithColumnFormatting, WithHeadings, FromCollection, withMapping
    {
        public function collection()
        {
            return Branch::all();
        }

        public function map($row)
        : array
        {
            return [
                $row->id,
                $row->code,
                $row->name,
                $row->created_at
            ];
        }

        public function headings()
        : array
        {
            return [
                'ID',
                'Code',
                'Name',
                'Created At'
            ];
        }

        public function columnFormats()
        : array
        {
            return [
                'A' => NumberFormat::FORMAT_NUMBER,
                'D' => NumberFormat::FORMAT_DATE_DATETIME
            ];
        }
    }
