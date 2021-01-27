<?php

namespace App\Imports;

use App\Models\Position;
use Maatwebsite\Excel\Concerns\ToModel;

class PositionImport implements ToModel
{
    protected $company_id;

    function __construct($company_id) {
            $this->company_id = $company_id;
    }

    public function model(array $row)
    {
        return new Position([
            'company_id' => $this->company_id,
            'position_name' => $row[0],
            'group' => $row[1],
        ]);
    }
}
