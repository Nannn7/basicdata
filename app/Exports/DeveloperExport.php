<?php

    namespace Modules\Basicdata\Exports;

    use Modules\Basicdata\Models\Developer;
    use Maatwebsite\Excel\Concerns\FromCollection;
    use Maatwebsite\Excel\Concerns\WithHeadings;
    use Maatwebsite\Excel\Concerns\WithMapping;

    class DeveloperExport implements FromCollection, WithHeadings, WithMapping
    {
        protected $search;

        public function __construct($search = null)
        {
            $this->search = $search;
        }

        public function collection()
        {
            $query = Developer::query();

            if ($this->search) {
                $search = strtolower($this->search);
                $query->where(function ($q) use ($search) {
                    $q->whereRaw('LOWER(code) LIKE ?', ['%' . $search . '%']);
                    $q->orWhereRaw('LOWER(name) LIKE ?', ['%' . $search . '%']);
                });
            }

            return $query->get();
        }

        public function headings(): array
        {
            return [
                'ID',
                'Code',
                'Name',
                'Created At',
                'Updated At',
            ];
        }

        public function map($developer): array
        {
            return [
                $developer->id,
                $developer->code,
                $developer->name,
                $developer->created_at,
                $developer->updated_at,
            ];
        }
    }
