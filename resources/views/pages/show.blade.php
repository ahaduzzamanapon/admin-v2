@extends('layouts.shop')

@section('title', $page->title)

@section('content')
    <div class="section" style="padding-top:40px; min-height:600px;">
        <div class="container">
            <div class="section-header">
                <div class="section-title">{{ $page->title }}</div>
            </div>

            <div class="page-content bg-white p-4 rounded shadow-sm border">
                {!! $page->content !!}
            </div>
        </div>
    </div>
@endsection