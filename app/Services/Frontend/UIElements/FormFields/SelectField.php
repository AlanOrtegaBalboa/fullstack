<?php

namespace App\Services\Frontend\UIElements\FormFields;

use Illuminate\Support\Str;

class SelectField implements Contracts\Field
{
    const COMPONENT = 'AppSelectField';

    public function __construct(
        protected string $name,
        protected string $label,
        protected string $placeholder = '',
        protected array $options = [],
        protected bool $disabled = false,
    ) {}

    public function generate(): array
    {
        return [
            'uuid' => Str::uuid(),
            'component' => self::COMPONENT,
            'props' => [
                'name' => $this->name,
                'label' => __($this->label),
                'placeholder' => __($this->placeholder),
                'options' => $this->options,
                'disabled' => $this->disabled,

            ],
        ];
    }
}
