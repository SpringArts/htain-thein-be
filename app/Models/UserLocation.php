<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserLocation
 *
 * @property int $id
 * @property int $user_id
 * @property float $latitude
 * @property float $longitude
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|UserLocation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserLocation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserLocation query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserLocation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserLocation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserLocation whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserLocation whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserLocation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserLocation whereUserId($value)
 *
 * @mixin \Eloquent
 */
class UserLocation extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'latitude', 'longitude'];
}
