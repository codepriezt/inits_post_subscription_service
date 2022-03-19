<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\MessageBag;

trait ResponseTrait
{
	public function sendApiResponse($status, $message, $data = null, $errors = null)
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
            'errors' => $errors
        ], $status);
    }

    public function error($message,$code){
        if($message instanceof MessageBag){
            foreach($message->getmessages() as $key => $value){

                $message = "'{$key}' : {$value[0]}";
                break;
            }
        }

        return $this->sendApiResponse($code, $message);
    }
	public function Exception(\Exception $exception)
    {
        Log::error($exception->getMessage() , $exception->getTrace());
    }
}