<?php

    namespace Modules\Basicdata\Exports;

    use Maatwebsite\Excel\Concerns\FromCollection;
    use Maatwebsite\Excel\Concerns\WithColumnFormatting;
    use Maatwebsite\Excel\Concerns\WithHeadings;
    use Maatwebsite\Excel\Concerns\WithMapping;
    use Modules\Basicdata\Models\Currency;
    use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

    class CurrencyExport implements WithColumnFormatting, WithHeadings, FromCollection, withMapping
    {
        public function collection()
        {
            return Currency::all();
        }

        public function map($row)
        : array
        {
            return [
                $row->id,
                $row->code,
                $row->name,
                $row->decimal_places,
                $row->updated_at,
                $row->deleted_at,
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
                'Decimal Places',
                'Created At'
            ];
        }

        public function columnFormats()
        : array
        {
            return [
                'A' => NumberFormat::FORMAT_NUMBER,
                'B' => NumberFormat::FORMAT_NUMBER,
                'E' => NumberFormat::FORMAT_DATE_DATETIME
            ];
        }
    }
