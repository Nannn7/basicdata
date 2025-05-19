<?php

    namespace Modules\Basicdata\Exports;

    use Maatwebsite\Excel\Concerns\FromCollection;
    use Maatwebsite\Excel\Concerns\WithColumnFormatting;
    use Maatwebsite\Excel\Concerns\WithHeadings;
    use Maatwebsite\Excel\Concerns\WithMapping;
    use Modules\Basicdata\Models\Branch;
    use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

    class BranchExport implements WithColumnFormatting, WithHeadings, FromCollection, WithMapping
    {
        protected $search;

        public function __construct($search = null, $parent_id = null)
        {
            $this->search    = $search;
            $this->parent_id = $parent_id;
        }

        public function collection()
        {
            $query = Branch::query();

            if (!empty($this->search)) {
                $search = strtolower($this->search);
                $query->where(function ($q) use ($search) {
                    $q->whereRaw('LOWER(code) LIKE ?', ['%' . $search . '%'])
                      ->orWhereRaw('LOWER(name) LIKE ?', ['%' . $search . '%'])
                      ->orWhereHas('parent', function ($q) use ($search) {
                          $q->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%']);
                      });
                });
            }

            // Apply parent filter if provided
            if (isset($this->parent_id) && !empty($this->parent_id)) {
                $parentId = $this->parent_id;
                $query->where('parent_id', $parentId);
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
                $row->parent ? $row->parent->name : '',
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
                'Parent Branch',
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
