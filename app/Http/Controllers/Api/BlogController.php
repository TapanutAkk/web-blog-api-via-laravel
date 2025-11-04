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

    public function save(Request $request)
    {
        try {
            $request->validate([
                'title' => ['required'],
                'content' => ['required'],
            ], [
                'title.required' => 'กรุณากรอกหัวข้อ Blog.',
                'content.required' => 'กรุณากรอกเนื้อหา Blog.',
            ]);

            $user = Auth::user();

            $blog = new Blog();
            $blog->title = $request->title;
            $blog->content = $request->content;
            $blog->is_published = $request->input('is_published', false);
            $blog->user_id = $user->id;
            $blog->save();

            return $this->success(new BlogResource($blog), "สร้าง Blog สำเร็จ");

        } catch (\Exception $e) {
            return $this->error('เกิดข้อผิดพลาดในการสร้าง Blog: ' . $e->getMessage(), 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'title' => ['required'],
                'content' => ['required'],
            ], [
                'title.required' => 'กรุณากรอกหัวข้อ Blog.',
                'content.required' => 'กรุณากรอกเนื้อหา Blog.',
            ]);

            $user = Auth::user();

            $blog = Blog::where('id', $id)->where('user_id', $user->id)->first();

            if(! $blog) {
                return $this->error('ไม่พบบทความนี้', 404);
            }

            $blog->title = $request->title;
            $blog->content = $request->content;
            $blog->is_published = $request->input('is_published', false);
            $blog->save();

            return $this->success(new BlogResource($blog), "สร้าง Blog สำเร็จ");

        } catch (\Exception $e) {
            return $this->error('เกิดข้อผิดพลาดในการสร้าง Blog: ' . $e->getMessage(), 500);
        }
    }
}
