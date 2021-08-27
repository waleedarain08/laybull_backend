<?php

namespace App\Helpers;

use App\User;

class Helper
{
    public static function users($moduleName)
    {
        $model =new User();
        $records = $model->where('role','vendor')
            ->whereNotNull('modules')
            ->where('modules', 'like', '%'.$moduleName.'%')
            ->latest()
            ->get();        
        return $records;
    }
}