<?php

namespace Modules\Basicdata\Exports;

use Modules\Basicdata\Models\Notaris;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class NotarisExport implements FromCollection, WithHeadings, WithMapping
{
    protected $search;

    public function __construct($search = null)
    {
        $this->search = $search;
    }

    public function collection()
    {
        $query = Notaris::query();

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

    public function map($notaris): array
    {
        return [
            $notaris->id,
            $notaris->code,
            $notaris->name,
            $notaris->created_at,
            $notaris->updated_at,
        ];
    }
}
