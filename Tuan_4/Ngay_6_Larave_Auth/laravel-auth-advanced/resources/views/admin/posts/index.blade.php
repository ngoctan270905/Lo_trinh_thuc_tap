@extends('layouts.app')

@section('content')
<h1>Quản lý tất cả bài viết (Admin)</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tiêu đề</th>
            <th>Tác giả</th>
            <th>Ngày tạo</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($posts as $post)
        <tr>
            <td>{{ $post->id }}</td>
            <td>{{ $post->title }}</td>
            <td>{{ $post->user->name ?? 'Không rõ' }}</td>
            <td>{{ $post->created_at->format('d/m/Y') }}</td>
            <td>
                <a href="{{ route('admin.posts.show', $post->id) }}">Xem</a> |
                <a href="{{ route('admin.posts.edit', $post->id) }}">Sửa</a> |
                <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Bạn có chắc muốn xóa?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background:none;border:none;color:red;cursor:pointer;">Xóa</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
