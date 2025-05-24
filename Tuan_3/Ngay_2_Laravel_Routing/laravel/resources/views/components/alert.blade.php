@props(['type' => 'info', 'message'])

@php
$classes = [
    'success' => 'alert-success',
    'error' => 'alert-danger',
    'warning' => 'alert-warning',
    'info' => 'alert-info'
][$type] ?? 'alert-info';
@endphp

<div class="alert {{ $classes }} alert-dismissible fade show" role="alert">
    {{ $message }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div> 