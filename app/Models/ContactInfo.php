<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ContactInfo
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ContactInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactInfo whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactInfo whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactInfo whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactInfo whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ContactInfo extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
}
