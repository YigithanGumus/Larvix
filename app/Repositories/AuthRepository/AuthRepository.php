<?php

namespace App\Repositories\AuthRepository;

use App\Models\User;
use App\Repositories\AuthRepository\Interfaces\IAuthRepository;
use App\Repositories\BaseRepository\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

class AuthRepository extends BaseRepository implements IAuthRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function authLogin(array $params)
    {
        $user = $this->getByColumn("email",$params['email']);

        if (!$user || !Hash::check($params['password'],$user->password)) {
            return collect([
                "message"=>"Girilen e-mail veya şifre hatalıdır!",
                "status"=>false,
                "response_code"=>404
            ]);
        }

        $token = $user->createToken($user->name.'-AuthToken')->plainTextToken;

        return collect([
            "message"=>[
                "name"=>$user->name,
                "email"=>$user->email,
                "token"=>"Bearer ".$token,
            ],
            "status"=>true,
            "response_code"=>200,
        ]);
    }

    public function authLogout()
    {
        return auth()->user()->tokens()->delete();
    }
}
