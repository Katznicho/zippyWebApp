<x-filament-panels::page>

    @php
    $record = $this->getRecord();
    $images = $record->images ?? [];
    $coverImage = $record->cover_image ?? null;
    @endphp

    <div class="container mx-auto">
        <h1 class="text-3xl font-bold mb-4">Images</h1>

        <div class="mb-8">
            @if ($coverImage)
            <h2 class="text-lg font-bold mb-2">Cover Image</h2>
            <div class="flex items-center justify-center mb-4">
                <img src="{{ $coverImage }}" alt="Cover Image" class="cursor-pointer max-w-full rounded-lg transition-transform hover:scale-110 cursor-zoom-in">
            </div>
            <hr class="mb-4 border-t border-gray-300">
            @else
            <p>No cover image available.</p>
            @endif
        </div>

        <div>
            @if ($images)
            <h2 class="text-lg font-bold mb-2">Other Images</h2>
            <div class="flex flex-wrap gap-4">
                @foreach ($images as $image)
                <img src="{{ $image }}" alt="Image" class="cursor-pointer max-w-[calc(25%-1rem)] mb-4 rounded-md transition-transform hover:scale-110">
                @endforeach
            </div>
            @else
            <p>No images available.</p>
            @endif
        </div>
    </div>

</x-filament-panels::page>