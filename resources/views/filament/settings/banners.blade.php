<div class="flex flex-wrap gap-4">
  @foreach($images as $image)
    <img src="{{ asset('storage/' . $image) }}" alt="Banner" class="w-32 h-32 object-cover rounded-lg" />
@endforeach

</div>
