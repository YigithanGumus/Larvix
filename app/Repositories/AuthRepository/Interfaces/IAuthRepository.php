<?php

namespace App\Repositories\AuthRepository\Interfaces;

interface IAuthRepository
{
    public function authLogin(array $params);
    public function authLogout();
}
