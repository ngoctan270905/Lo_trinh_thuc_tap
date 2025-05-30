<?php
namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Hiển thị danh sách bài viết của user hiện tại
    public function index()
    {
        // Kiểm tra nếu đang ở route admin thì hiển thị tất cả bài viết
        if (request()->is('admin/*')) {
            $posts = Post::with('user')->latest()->get();
        } else {
            // Nếu không phải route admin thì chỉ hiển thị bài viết của user hiện tại
            $posts = Post::where('user_id', Auth::id())->get();
        }
        return view('admin.posts.index', compact('posts'));
    }

    // Form tạo bài mới
    public function create()
    {
        return view('admin.posts.create');
    }

    // Lưu bài mới
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'Đã tạo bài viết mới.');
    }

    // Form chỉnh sửa bài
    public function edit(Post $post)
    {
        $this->authorize('update', $post); // kiểm tra quyền sửa bài (policy)

        return view('admin.posts.edit', compact('post'));
    }

    // Cập nhật bài
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $post->update($request->only('title', 'content'));

        return redirect()->route('admin.posts.index')->with('success', 'Cập nhật bài viết thành công.');
    }

    // Xóa bài
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Đã xóa bài viết.');
    }
}
