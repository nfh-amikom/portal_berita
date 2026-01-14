<div class="mb-4">
    <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title:</label>
    <input type="text" name="title" id="title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('title') border-red-500 @enderror" value="{{ old('title', $news->title ?? '') }}" required>
    @error('title')
        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label for="category_id" class="block text-gray-700 text-sm font-bold mb-2">Category:</label>
    <select name="category_id" id="category_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('category_id') border-red-500 @enderror" required>
        <option value="">Select a Category</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ old('category_id', $news->category_id ?? '') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    @error('category_id')
        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label for="content" class="block text-gray-700 text-sm font-bold mb-2">Content:</label>
    <textarea name="content" id="content" class="summernote shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('content') border-red-500 @enderror" rows="10">{{ old('content', $news->content ?? '') }}</textarea>
    @error('content')
        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Image:</label>
    
    <input type="file" name="image" id="image" 
        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-md cursor-pointer bg-white focus:outline-none @error('image') border-red-500 @enderror 
        file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">

    @error('image')
        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
    @enderror

    @if(isset($news) && $news->image)
        <div class="mt-3 p-2 border rounded-md bg-gray-50 flex items-center gap-3">
            <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" class="h-16 w-16 object-cover rounded shadow-sm">
            <span class="text-xs text-gray-500">Gambar saat ini</span>
        </div>
    @endif
</div>
