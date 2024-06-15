<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Builders\UserBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Providers\BackofficeServiceProvider;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Base\User
{

    public function newEloquentBuilder($query): Builders\UserBuilder
    {
        return new Builders\UserBuilder($query);
    }
    public function courses(): HasMany
    {
        return $this->hasMany(Course::class, 'owner_id', 'user_id');
    }

    public function getRedirectUrl(): string
    {
        return match ($this->is_admin) {
          true => route('backoffice.dashboard.index'),
          false =>  route('dashboard'),
        };
    }
}
