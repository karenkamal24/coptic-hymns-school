<div class="text-center">
    @if ($getState())
        <img src="{{ asset('storage/' . $getState()) }}"
             alt="Receipt"
             class="w-full max-w-md mx-auto rounded-lg shadow-md border mb-4" />

        <a href="{{ asset('storage/' . $getState()) }}"
           target="_blank"
           class="inline-block px-6 py-2 bg-black text-black font-semibold rounded-lg shadow hover:bg-gray-800 transition duration-200">
            🔍 View Full Image
        </a>
    @else
        <p class="text-gray-500 italic">No receipt uploaded.</p>
    @endif
</div>
