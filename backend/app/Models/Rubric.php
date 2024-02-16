<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Rubric
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Rubric newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rubric newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rubric query()
 * @mixin \Eloquent
 */
class Rubric extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public $timestamps = false;

    public function emails(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Email::class, 'email_rubric', 'rubric_id', 'email_id');
    }
}
