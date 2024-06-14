<?php

namespace App\Macros\Blueprint;

use Illuminate\Database\Schema\Blueprint;

final class UpdatedBy{
    public function __invoke(): void
    {
        Blueprint::macro('updatedBy', function (string $authorTable = 'users', string $authorColumn = 'user_id') {
            $this->unsignedBigInteger('updated_by')->nullable();

            $this->foreign('updated_by')
                ->references($authorColumn)
                ->on($authorTable)

            ;
        });
    }
}
