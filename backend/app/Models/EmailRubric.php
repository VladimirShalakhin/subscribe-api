<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\EmailRubric
 *
 * @method static \Illuminate\Database\Eloquent\Builder|EmailRubric newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailRubric newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailRubric query()
 *
 * @property int $email_id Идентификатор почтового адреса из таблицы emails
 * @property int $rubric_id идентификатор рубрики из таблицы rubrics
 * @property string $subscribed_at Дата, когда была выполнена подписка на данную рубрику
 *
 * @method static \Illuminate\Database\Eloquent\Builder|EmailRubric whereEmailId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailRubric whereRubricId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailRubric whereSubscribedAt($value)
 *
 * @property string $confirmed_at Дата, когда было выполнено подтверждение подписки на данную рубрику
 * @property string $token Токен для подтверждения подписи на рубрику
 *
 * @method static \Illuminate\Database\Eloquent\Builder|EmailRubric whereConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailRubric whereToken($value)
 *
 * @mixin \Eloquent
 */
class EmailRubric extends Pivot
{
    //TODO: add scope
}
