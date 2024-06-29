<?php

namespace App\Services\Frontend\UIElements\FormFields\SelectOptions;

class BooleanOptions implements COntracts\WithOptions
{
    public function getOptions(): array
    {
        return [
            [
                'text' => __('Sí'),
                'value' => 1,
            ],
            [
                'text' => __('No'),
                'value' => 0,
            ],
        ];
    }
}
