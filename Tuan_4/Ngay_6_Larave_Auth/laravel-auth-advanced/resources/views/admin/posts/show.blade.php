@extends('layouts.app')

@section('content')
<h1>Chi tiết bài viết</h1>

<p><strong>Tiêu đề:</strong> {{ $post->title }}</p>
<p><strong>Nội dung:</strong></p>
<p>{{ $post->content }}</p>
<p><strong>Tác giả:</strong> {{ $post->user->name ?? 'Không rõ' }}</p>
<p><strong>Ngày tạo:</strong> {{ $post->created_at->format('d/m/Y H:i') }}</p>

<a href="{{ route('admin.posts.index') }}">Quay lại danh sách</a>
@endsection
