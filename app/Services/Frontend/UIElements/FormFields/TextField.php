<?php

namespace App\Services\Frontend\UIElements\FormFields;

use Illuminate\Support\Str;

class TextField implements Contracts\Field
{
    const COMPONENT = 'AppTextInputField';

    const CSS_FIELD_CLASS = 'bg-gray-50 border text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:placeholder-gray-400 dark:text-white dark:bg-gray-700';

    public function __construct(
        protected string $name,
        protected string $label,
        protected string $placeholder = '',
    )
    {}

    public function generate(): array
    {
        return [
            'uuid' => Str::uuid(),
            'component' => self::COMPONENT,
            'props' => [
                'name' => $this->name,
                'label' => __($this->label),
                'placeholder' => __($this->placeholder),
                'cssFieldClass' => self::CSS_FIELD_CLASS,
            ],
        ];
    }
}
