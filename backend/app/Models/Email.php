<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Email
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Email newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Email newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Email query()
 *
 * @property-read Collection<int, Rubric> $rubrics
 * @property-read int|null $rubrics_count
 * @property-read User|null $user
 * @property int $id Идентификатор почтового адреса
 * @property string $address Адрес электронной почты
 * @property bool $main Является ли данный почтовый адрес основным
 * @property bool $verified Является ли данный почтовый адрес подтвержденным
 * @property int $user_id Идентификатор пользователя, которому принадлежит данный почтовый адрес
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Email whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Email whereMain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Email whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Email whereVerified($value)
 *
 * @property string $value Адрес электронной почты
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Email whereValue($value)
 *
 * @property string|null $token Токен для подтверждения подписи почтового адреса
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Email whereToken($value)
 *
 * @mixin \Eloquent
 */
class Email extends Model
{
    use HasFactory;

    protected $fillable = ['value', 'user_id', 'main', 'verified', 'token'];

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
