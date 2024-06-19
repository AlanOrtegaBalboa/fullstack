<?php

namespace App\Services\Frontend\UIElements\SidebarItems;

use App\Services\Frontend\UIElements\SidebarItems\Contracts\SidebarItem;

class SidebarLink implements SidebarItem
{
    const COMPONENT = 'AppSidebarLinkItem';

    public function __construct(
        protected readonly string $text,
        protected readonly string $href,
        protected readonly string $iconComponent,
        protected readonly string $current,

    ) {
    }

    public function toArray(): array
    {
        return [
            'component' => self::COMPONENT,
            'props' => [
                'text' => $this->text,
                'href' => $this->href,
                'iconComponent' => $this->iconComponent,
                'current' => $this->current,
            ]
        ];
    }
}
