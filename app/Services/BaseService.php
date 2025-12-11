<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

abstract class BaseService
{
    public function loginfo($message,$details=[]){
        Log::info($message,$details);
    }
    public function logerror($message,$details=[]){
        Log::error($message,$details);
    }
    public function logwithcontext($message,$context=[]){
        Log::withContext($context)->info($message);
    }
}
