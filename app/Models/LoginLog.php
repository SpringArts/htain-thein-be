<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LoginLog
 *
 * @property int $id
 * @property string $user_agent
 * @property string|null $browser
 * @property string|null $platform
 * @property string|null $device
 * @property string|null $ip_address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|LoginLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LoginLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LoginLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|LoginLog whereBrowser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginLog whereDevice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginLog whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginLog wherePlatform($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginLog whereUserAgent($value)
 * @mixin \Eloquent
 */
class LoginLog extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
}
