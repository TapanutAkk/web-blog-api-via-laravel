<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Traits\ApiResponse;
use App\Http\Resources\BlogResource;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        try {
            return $this->success(
                BlogResource::collection(
                    Blog::paginate(
                        $request->get('per_page', 10)
                    )
                )
                ->response()
                ->getData(true),
                'เรียกข้อมูลบทความทั้งหมดสำเร็จ'
            );
        } catch (\Exception $e) {
            return $this->error('เกิดข้อผิดพลาดในการเรียกข้อมูล: ' . $e->getMessage(), 500);
        }
    }

    public function show(string $id)
    {
        try {
            return $this->success(
                new BlogResource(
                    Blog::find($id)
                ),
                'เรียกข้อมูลบทความสำเร็จ'
            );
        } catch (\Exception $e) {
            return $this->error('เกิดข้อผิดพลาดในการเรียกข้อมูล: ' . $e->getMessage(), 500);
        }
    }

    public function myBlogs(Request $request)
    {
        try {
            $user = Auth::user();

            $perPage = $request->get('per_page', 10);

            $myBlogs = $user->blogs()
                            ->orderBy('created_at', 'desc')
                            ->paginate($perPage);

            $result = BlogResource::collection($myBlogs)->response()->getData(true);

            return $this->success($result, 'เรียกข้อมูล Blog ส่วนตัวสำเร็จ');

        } catch (\Exception $e) {
            return $this->error('เกิดข้อผิดพลาดในการเรียกข้อมูล Blog ส่วนตัว: ' . $e->getMessage(), 500);
        }
    }
}
