<div class="space-y-4">
    <h3 class="text-lg font-semibold">Media</h3>
    <div class="flex flex-wrap gap-4">
        @foreach($record->images ?? [] as $image)
            <img src="{{ asset('storage/' . $image['image']) }}"
                 alt="Instructor Image"
                 class="w-32 h-32 object-cover rounded-lg">
        @endforeach
    </div>
</div>
