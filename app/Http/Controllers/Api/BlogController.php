<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Traits\ApiResponse;
use App\Http\Resources\BlogResource;

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
}
