<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
// use Illuminate\Support\Facades\Auth;
use Throwable;

class ApiPasswordResetToken extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'token_signature', 'token_type'];
    Public static $PASSWORD_RESET_TOKEN = 10;

    public function userInfo()
    {
        return $this->belongsTo(User::class);
    }

    public function getResetCode()
    {
        $randomString = Str::random(10);
        return $randomString;
    }

    public function getResetIdentifierCode($ser_id)
    {
        $token = $this->getResetCode();

        try{
            $obj = new ApiPasswordResetToken();
            $obj ->user_id = $ser_id;
            $obj ->token_signature = hash('md5',  $token);
            $obj ->token_type = ApiPasswordResetToken::$PASSWORD_RESET_TOKEN;
            $obj ->expires_at = Carbon::now()->addMinutes(30);
            $obj->save();

            return $token;
        }catch(Throwable $th){
            return response()->json([
                'status' => false,
                'message' => 'There is an error while validating the password reset code.',
                'error' => $th->getMessage(),
            ], 422);
        }
    }


}
