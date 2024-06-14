<?php

namespace App\Models\Base;

use App\Traits\Models\CreatedBy;
use App\Traits\Models\DeletedBy;
use App\Traits\Models\HasSlug;
use App\Traits\Models\UpdatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lesson extends Model
{
    use SoftDeletes, HasSlug, CreatedBy, HasSlug, UpdatedBy, DeletedBy;

    protected $table = 'lessons';

    protected $primaryKey = 'lesson_id';

    protected $fillable = [
        'course_id',
        'lesson_type_id',
        'name',
        'slug',
        'description',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'course_id' => 'integer',
        'lesson_type_id' => 'integer',
        'name' => 'string',
        'slug' => 'string',
        'description' => 'string',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'deleted_by' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',

    ];
}
