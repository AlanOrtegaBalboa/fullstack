<?php

namespace App\Macros\Blueprint;

use Illuminate\Database\Schema\Blueprint;

final class DeletedBy{
    public function __invoke(): void
    {
        Blueprint::macro('deletedBy', function (string $authorTable = 'users', string $authorColumn = 'user_id') {
            $this->unsignedBigInteger('deleted_by')->nullable();

            $this->foreign('deleted_by')
                ->references($authorColumn)
                ->on($authorTable)

            ;
        });
    }
}
