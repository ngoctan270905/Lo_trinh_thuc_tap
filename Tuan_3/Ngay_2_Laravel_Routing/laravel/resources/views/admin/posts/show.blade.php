@extends('layouts.admin')

@section('title', $post->title)

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2>{{ $post->title }}</h2>
        <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
    <div class="card-body">
        <div class="mb-4">
            <small class="text-muted">
                Created by {{ $post->user->name }} on {{ $post->created_at->format('F j, Y \a\t H:i') }}
            </small>
        </div>
        
        <div class="post-content">
            {!! nl2br(e($post->content)) !!}
        </div>
    </div>
</div>
@endsection 