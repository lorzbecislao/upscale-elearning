<?php

namespace App\Services;

use App\Models\Program;

class ProgramService
{
    public function getAsDropdown(): array
    {
        return Program::all()->map(function ($program) {
            return [
                'id' => $program->id,
                'label' => $program->initial . ' - ' . $program->name,
                'value' => $program->id,
            ];
        })->toArray();
    }
}