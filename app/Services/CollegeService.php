<?php

namespace App\Services;

use App\Models\College;

class CollegeService
{
    public function getAsDropdown(): array
    {
        return College::all()->map(function ($college) {
            return [
                'id' => $college->id,
                'label' => $college->initial . ' - ' . $college->name,
                'value' => $college->id,
            ];
        })->toArray();
    }
}