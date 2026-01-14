@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <form action="{{ route('admin.news.index') }}" method="GET" class="mb-6">
        <label class="block text-gray-700 text-sm font-bold mb-4">Filter by Category:</label>
        
        <div class="flex flex-wrap gap-2">
            <button type="submit" name="category" value="all" 
                class="px-4 py-2 rounded shadow border transition-colors {{ $selectedCategory == 'all' ? 'bg-green-600 text-white border-green-600' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                All Categories
            </button>

            @foreach($categories as $category)
                <button type="submit" name="category" value="{{ $category->id }}"
                    class="px-4 py-2 rounded shadow border transition-colors 
                    {{ $selectedCategory == $category->id 
                        ? 'bg-green-600 text-white border-green-600' 
                        : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                    {{ $category->name }}
                </button>
            @endforeach
        </div>
    </form>

       <div class="flex justify-between items-center mb-6">
           <h1 class="text-3xl font-bold">News Management</h1>
           
           <div class="flex space-x-2">
               <a href="{{ route('admin.dashboard') }}" 
                  class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150">
                  Back to Dashboard
               </a>
   
               <a href="{{ route('admin.news.create') }}" 
                  class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150">
                  Add New News
               </a>
           </div>
       </div>
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Image
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Title
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Category
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Author
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($news as $item)
                <tr>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="h-16 w-16 object-cover rounded">
                        @else
                            <img src="https://via.placeholder.com/64" alt="No Image" class="h-16 w-16 object-cover rounded">
                        @endif
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <p class="text-gray-900 whitespace-no-wrap">{{ $item->title }}</p>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <p class="text-gray-900 whitespace-no-wrap">{{ $item->category->name }}</p>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <p class="text-gray-900 whitespace-no-wrap">{{ $item->author->name }}</p>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('admin.news.edit', $item) }}" 
                            class="inline-flex items-center px-3 py-1.5 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Edit
                            </a>

                            <form action="{{ route('admin.news.destroy', $item) }}" method="POST" onsubmit="return confirm('Are you sure?')" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                    class="inline-flex items-center px-3 py-1.5 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                        No news articles found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-5">
            {{ $news->links() }}
        </div>
    </div>
</div>
@endsection
