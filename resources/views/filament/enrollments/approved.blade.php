@foreach($enrollments as $enrollment)
<div class="p-4 border rounded shadow bg-white flex items-center gap-4">
    @if($enrollment->course?->image)
        <img src="{{ asset('storage/' . $enrollment->course->image) }}" class="w-20 h-20 object-cover rounded" alt="Course Image">
    @endif
    <div>
        <h2 class="text-lg font-semibold">{{ $enrollment->course?->title }}</h2>
        <p class="text-gray-600">Enrolled at: {{ $enrollment->created_at->format('d M Y') }}</p>
    </div>
</div>
@endforeach
