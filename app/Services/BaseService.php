<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

abstract class BaseService
{
    public function loginfo($message,$details=[]){
        return Log::info($message,$details);
    }
    public function logerror($message,$details=[]){
        return Log::error($message,$details);
    }
    public function logwithcontext($message,$context=[]){
        $enrichedContext = array_merge($context, [
            'service' => static::class,
            'timestamp' => now()->toIso8601String()
        ]);
        return Log::info($message,$enrichedContext);
    }
}
