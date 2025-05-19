<?php

    namespace Modules\Basicdata\Exports;

    use Maatwebsite\Excel\Concerns\FromCollection;
    use Maatwebsite\Excel\Concerns\WithColumnFormatting;
    use Maatwebsite\Excel\Concerns\WithHeadings;
    use Maatwebsite\Excel\Concerns\WithMapping;
    use Modules\Basicdata\Models\Currency;
    use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

    class CurrencyExport implements WithColumnFormatting, WithHeadings, FromCollection, WithMapping
    {
        protected $search;

        public function __construct($search = null)
        {
            $this->search = $search;
        }

        public function collection()
        {
            $query = Currency::query();

            if (!empty($this->search)) {
                $search = $this->search;

                $query->where(function ($q) use ($search) {
                    $q->whereRaw('LOWER(code) LIKE ?', ['%' . strtolower($search) . '%'])
                      ->orWhereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%'])
                      ->orWhereRaw('CAST(decimal_places AS TEXT) LIKE ?', ['%' . $search . '%']);
                });
            }

            return $query->get();
        }

        public function map($row)
        : array
        {
            return [
                $row->id,
                $row->code,
                $row->name,
                $row->decimal_places,
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
                'D' => NumberFormat::FORMAT_NUMBER,
                'E' => NumberFormat::FORMAT_DATE_DATETIME
            ];
        }
    }
