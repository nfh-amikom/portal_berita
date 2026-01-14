@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h2 class="text-3xl font-bold mb-6">Berita Saat Ini</h2>

    <form action="{{ route('news.index') }}" method="GET" class="mb-6">
        <label class="block text-gray-700 text-sm font-bold mb-4">Filter by Category:</label>
        <div class="flex flex-wrap gap-2">
            <button type="submit" name="category" value="all" 
                class="px-4 py-2 rounded shadow border transition-colors {{ $selectedCategory == 'all' ? 'bg-green-600 text-white border-green-600' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                All Categories
            </button>
            @foreach($categories as $category)
                <button type="submit" name="category" value="{{ $category->id }}"
                    class="px-4 py-2 rounded shadow border transition-colors 
                    {{ $selectedCategory == $category->id ? 'bg-green-600 text-white border-green-600' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                    {{ $category->name }}
                </button>
            @endforeach
        </div>
    </form>

    @if($headline)
    <a href="{{ route('news.show', $headline) }}" class="block no-underline text-gray-900 mb-8">
        <div class="p-6 bg-white shadow-md rounded-lg hover:shadow-lg transition duration-200 overflow-hidden">
            <img src="{{ asset('storage/' . $headline->image) }}" 
                 class="w-full aspect-video object-cover rounded-lg mb-4 shadow-sm">
            
            <h2 class="text-2xl md:text-3xl font-bold mb-2 break-words leading-tight text-gray-800">
                {{ $headline->title }}
            </h2>
            
            <div class="text-gray-500 text-sm mb-4 flex items-center gap-2">
                <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-bold uppercase">
                    {{ $headline->category->name }}
                </span>
                <span>•</span>
                <span>{{ $headline->created_at->format('d M Y') }}</span>
            </div>
            
            <p class="text-gray-600 break-words line-clamp-4 md:line-clamp-none">
                {{ Str::limit(strip_tags($headline->content), 400) }}
            </p>
        </div>
    </a>
@endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($other_news as $news)
            <a href="{{ route('news.show', $news) }}" class="block no-underline text-gray-900">
                <div class="bg-white p-4 shadow-md rounded-lg hover:shadow-lg transition duration-200 h-full flex flex-col overflow-hidden">
                    <img src="{{ asset('storage/' . $news->image) }}" class="w-full h-48 object-cover rounded-lg mb-4">
                    
                    <h3 class="text-xl font-semibold mb-2 line-clamp-2 break-words leading-tight h-8">
                        {{ $news->title }}
                    </h3>
                    
                    <div class="text-gray-600 text-sm mb-2">
                        {{ $news->category->name }} • {{ $news->created_at->format('d M Y') }}
                    </div>
                    
                    <p class="text-gray-700 break-words line-clamp-3 flex-grow">
                        {{ Str::limit(strip_tags($news->content), 120) }}
                    </p>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection