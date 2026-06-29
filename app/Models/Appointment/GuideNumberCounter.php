<?php

namespace App\Models\Appointment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use DateTime;

class GuideNumberCounter extends Model
{
    protected $table = 'appointment_guide_number_counters';

    protected $fillable = [
        'unity_id',
        'number',
    ];

    // METHODS

    public static function incrementGuide($unityId)
    {
        $unityCounter = self::firstWhere('unity_id', $unityId);

        // if ($unityCounter == '2') {
            $unityCounter->update(['number' => $unityCounter->number + 1]);
        // } 
        // else {
        //     $unityCounter = self::create([
        //         'unity_id' => $unityId,
        //         'number' => 1,
        //     ]);
        // }

        return $unityCounter->number;
    }

    public static function reset()
    {
        $lastUpdatedTimestamp = self::max('updated_at');
        
        $dateLastUpdated = new DateTime(date('Y-m-d', strtotime($lastUpdatedTimestamp)));
        $dateCurrent = new DateTime(date('Y-m-d'));

        if ($dateCurrent > $dateLastUpdated) {
            DB::table('appointment_guide_number_counters')
                ->where('unity_id', 1)
                ->update([
                    'number' => 99,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);

            DB::table('appointment_guide_number_counters')
                ->where('unity_id', 2)
                ->update([
                    'number' => 0,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
        }
    }
}
