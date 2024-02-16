<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Email
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Email newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Email newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Email query()
 * @mixin \Eloquent
 */
class Email extends Model
{
    use HasFactory;

    protected $fillable = ['address', 'user_id', 'main', 'status'];

    public $timestamps = false;

    public function rubrics(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Rubric::class, 'email_rubric', 'email_id', 'rubric_id');
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
