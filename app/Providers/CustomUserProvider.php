<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Facades\Auth;
use App\UserAdmin;
use Illuminate\Support\Facades\Hash;
use Encore\Admin\Facades\Admin;

class CustomUserProvider implements UserProvider
{
    public function retrieveById($identifier)
    {
        // dd($identifier);
        session()->put("admin",UserAdmin::find($identifier)->toArray());
        dd(Admin::user());
        // return redirect("/tz_admin");
    }

    public function retrieveByToken($identifier, $token)
    {}

    public function updateRememberToken(Authenticatable $user, $token)
    {}

    public function retrieveByCredentials(array $credentials)
    {
        // 用$credentials里面的用户名密码去获取用户信息，然后返回Illuminate\Contracts\Auth\Authenticatable对象
        // dd(UserAdmin::where(["username" => $credentials["username"]])->get());
        return UserAdmin::where(["username" => $credentials["username"]])->first();
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        // 用$credentials里面的用户名密码校验用户，返回true或false
        if (Hash::check($credentials['password'],$user->getAuthPassword())) {
            return true;
        } else {
            return false;
        }
    }
}
