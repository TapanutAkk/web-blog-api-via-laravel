<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Traits\ApiResponse;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    use ApiResponse;

    public function login(LoginRequest $request)
    {
        try {
            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return $this->error('ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง', 401);
            }

            $result = [
                'user' => new UserResource($user),
                'token' => $user->createToken('api-token', ['*'])->plainTextToken,
                'token_type' => 'Bearer',
            ];

            return $this->success($result, 'เข้าสู่ระบบสำเร็จ');

        } catch (\Exception $e) {
            return $this->error('เกิดข้อผิดพลาดภายใน: ' . $e->getMessage(), 500);
        }
    }
}
