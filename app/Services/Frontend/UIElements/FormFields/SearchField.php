<?php

namespace App\Services\Frontend\UIElements\FormFields;

use Illuminate\Support\Str;

class SearchField implements Contracts\Field
{
    const COMPONENT = 'AppSearchInputField';
    public function __construct(
        protected string $name,
        protected string $label,
        protected string $placeholder = '',

    ){}
    public function generate(): array
    {
        return [
            'uuid' => Str::uuid(),
            'component' => self::COMPONENT,
            'props' => [
                'name' => $this->name,
                'label' => __($this->label),
                'placeholder' => __($this->placeholder),

            ],
        ];
    }
}
