<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class ClientExport implements FromCollection
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
    public function collection()
    {
        return collect($this->data);
    }
}