<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\ApiResponse;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        try {
            return $this->success(
                UserResource::collection(
                    User::paginate(
                        $request->get('per_page', 10)
                    )
                )
                ->response()
                ->getData(true),
                'เรียกข้อมูลผู้ใช้ทั้งหมดสำเร็จ'
            );
        } catch (\Exception $e) {
            return $this->error('เกิดข้อผิดพลาดในการเรียกข้อมูล: ' . $e->getMessage(), 500);
        }
    }
}
