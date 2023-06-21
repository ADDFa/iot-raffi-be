<?php

namespace App\Http\Controllers;

use App\Http\Helper\Response;
use App\Models\User;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    private function tokens($user)
    {
        try {
            $encode = function (int $exp, $keyname) use ($user) {
                $time = time();

                return JWT::encode([
                    "user"  => $user,
                    "exp"   => $time + $exp
                ], env($keyname), "HS256");
            };

            $result = [
                "user"          => $user,
                "token_access"  => $encode(3600, "JWT_SECRET"),
                "token_refresh" => $encode(604800, "JWT_REFRESH")
            ];

            return Response::success($result);
        } catch (Exception $e) {
            return Response::message($e->getMessage());
        }
    }

    public function login(Request $request)
    {
        $credential = User::find($request->username);
        if (!$credential || !password_verify($request->password, $credential->password)) {
            return Response::message("Username atau Password salah", 400);
        }

        $user = User::find($credential->user_id);
        return $this->tokens($user);
    }

    public function refreshToken(Request $request)
    {
        try {
            $payload = JWT::decode($request->token_refresh, new Key(env("JWT_REFRESH"), "HS256"));
            return $this->tokens($payload->user);
        } catch (Exception $e) {
            return response()->json(Response::message($e->getMessage()));
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "username"  => "required|unique:users,username|string",
            "name"      => "required|string",
            "password"  => "required|min:8"
        ]);
        if ($validator->fails()) return Response::errors($validator);

        $user = new User([
            "username"  => $request->username,
            "name"      => $request->name,
            "password"  => password_hash($request->password, PASSWORD_DEFAULT)
        ]);
        $user->save();

        return Response::message("Registrasi Berhasil!", 200);
    }
}
