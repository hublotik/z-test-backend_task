<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class User extends Model
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'api_key',
    ];

    protected $hidden = [
        'password',
        'api_key',
    ];

    public static function getApiKeyByCredentials($email, $password)
    {
        $user = self::where('email', $email)->first();

        if ($user && Hash::check($password, $user->password)) {
            if(!empty($user->api_key)){return $user->api_key;}
            $user->api_key = Str::random(60);
            $user->save();

            return $user->api_key;
        }

        return null;
    }
}