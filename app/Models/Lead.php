<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Модель для работы с информацией о лидах.
 *
 * @property int $id
 * @property string $firstname
 * @property string $lastname
 * @property string $surname
 * @property string $phone
 * @property string $email
 * @property string $link
 * @property string $birthday
 * @property int $bitrix_lead_id
 * @property string $comment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @package App\Models
 */
class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname',
        'lastname',
        'surname',
        'phone',
        'email',
        'link',
        'birthday',
        'bitrix_lead_id',
        'comment',
    ];
}
