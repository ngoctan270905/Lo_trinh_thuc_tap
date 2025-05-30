@extends('layouts.app')

@section('content')
<h1>Chỉnh sửa bài viết</h1>

@if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.posts.update', $post->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Tiêu đề:</label><br>
    <input type="text" name="title" value="{{ old('title', $post->title) }}" required><br><br>

    <label>Nội dung:</label><br>
    <textarea name="content" rows="6" required>{{ old('content', $post->content) }}</textarea><br><br>

    <button type="submit">Cập nhật</button>
</form>

<a href="{{ route('admin.posts.index') }}">Quay lại danh sách</a>
@endsection
