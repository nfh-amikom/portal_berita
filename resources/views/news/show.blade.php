@extends('layouts.app')

@section('content')
<style>
    .prose img {
        max-width: 100% !important;
        height: auto !important;
    }

    .prose table {
        display: block;
        width: 100%;
        overflow-x: auto;
    }

</style>

<div class="container mx-auto px-4 py-8 shadow-sm bg-white rounded-lg overflow-hidden">

    <h1 class="text-4xl font-bold mb-4 break-words">{{ $news->title }}</h1>

    <div class="flex flex-wrap justify-between items-center mt-4 mb-6 text-sm text-gray-600 gap-y-2">
        <div class="flex items-center gap-2">
            <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-bold uppercase">
                {{ $news->category->name }}
            </span>
            <span class="text-gray-400">•</span>
            <span>{{ $news->created_at->format('d M Y') }}</span>
        </div>

        <div class="flex items-center bg-gray-50 px-3 py-1 rounded-full border border-gray-100">
            <img src="/company_logo.png" alt="Author" class="h-5 w-5 object-contain mr-2 rounded-full">
            <span class="font-medium text-gray-700">{{ $news->author->name }}</span>
        </div>
    </div>

    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-sm bg-gray-100 flex justify-center">
    <img src="{{ asset('storage/' . $news->image) }}" 
         alt="{{ $news->title }}" 
         class="max-w-full h-auto max-h-[500px] object-contain" 
         loading="lazy">
</div>

    <div class="prose prose-lg max-w-none text-gray-800 break-words leading-relaxed">
        {!! $news->content !!}
    </div>

</div>
@endsection
