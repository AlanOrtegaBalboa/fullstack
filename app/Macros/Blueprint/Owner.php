<?php

namespace App\Macros\Blueprint;

use Illuminate\Database\Schema\Blueprint;

final class Owner{
    public function __invoke(): void
    {
        Blueprint::macro('owner', function (string $authorTable = 'users', string $authorColumn = 'user_id') {
            $this->unsignedBigInteger('owner_id')->nullable();

            $this->foreign('owner_id')
                ->references($authorColumn)
                ->on($authorTable)

            ;
        });
    }
}
