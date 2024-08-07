<?php

namespace App\Traits\ViewModels;

trait WithPerPage
{
    protected function perPage(int $perPage): int
    {
        return request('perPage') ?? $perPage;
    }
}
