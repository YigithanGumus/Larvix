<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest\AuthLoginRequest;
use App\Http\Requests\AuthRequest\AuthRegisterStoreRequest;
use App\Repositories\AuthRepository\Interfaces\IAuthRepository;
use Mockery\Exception;

class AuthController extends Controller
{
    public $authRepository;

    public function __construct(IAuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function login(AuthLoginRequest $request)
    {
        try {
            $data = $this->authRepository->authLogin($request->all());

            return response([
                "message" => $data["message"],
                "status" => $data["status"],
            ], $data["response_code"]);
        } catch (Exception $th) {
            return response([
                "message" => "Hata! Daha sonra tekrar deneyiniz.",
                "error_message" => $th->getMessage(),
                "status" => true,
            ], 400);
        }
    }

    public function register(AuthRegisterStoreRequest $request)
    {
        try {
            $this->authRepository->create($request->all());

            return response([
                "message" => "Başarıyla kullanıcı oluşturuldu!",
                "status" => true,
            ], 201);
        } catch (\Exception $th) {
            return response([
                "message" => "Hata! Daha sonra tekrar deneyiniz.",
                "error_message" => $th->getMessage(),
                "status" => true,
            ], 400);
        }
    }

    public function logout()
    {
        try {
            $this->authRepository->authLogout();

            return response([
                "message" => "Başarıyla çıkış yapıldı!",
                "status" => true,
            ], 201);
        } catch (\Exception $th) {
            return response([
                "message" => "Hata! Daha sonra tekrar deneyiniz.",
                "error_message" => $th->getMessage(),
                "status" => true,
            ], 400);
        }
    }
}

