<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'country', 'latitude', 'longitude'];

    public function menu()
    {
        return $this->hasOne(Menu::class);
    }

    /**
     * @return array
     */
    public function getCoordinatesAttribute(): array
    {
        return [
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ];
    }

    /**
     * @param $value
     * @return void
     */
    public function setCoordinatesAttribute($value): void
    {
        $this->latitude = $value['latitude'];
        $this->longitude = $value['longitude'];
    }

    /**
     * @param $userCoordinates
     * @return float|int
     */
    public function calculateDistance($userCoordinates): float|int
    {
        $userLongitude = $userCoordinates['longitude'];
        $userLatitude = $userCoordinates['latitude'];

        $lat1 = $userLatitude;
        $lon1 = $userLongitude;
        $lat2 = $this->latitude;
        $lon2 = $this->longitude;

        $rad = M_PI / 180;

        $distance = acos(sin($lat2 * $rad) * sin($lat1 * $rad) + cos($lat2 * $rad) * cos($lat1 * $rad) * cos($lon2 * $rad - $lon1 * $rad)) * 6371;
        return $distance;
    }
}
