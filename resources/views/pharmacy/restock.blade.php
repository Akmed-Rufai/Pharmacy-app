
<x-layout>
<div class="container">
    <h2 class="text-xl font-bold mb-4">📦 Medicine Stock Alerts</h2>

    @if($lowStock->count() > 0)
        <div class="bg-red-100 text-red-800 p-4 rounded shadow">
            <strong>Warning:</strong> The following medicines need restocking:
            <ul class="list-disc pl-5 mt-2">
                @foreach($lowStock as $med)
                    <li>{{ $med->medicine }} — {{ $med->quantity }} left</li>
                @endforeach
            </ul>
        </div>
    @else
        <div class="bg-green-100 text-green-800 p-4 rounded shadow">
            All medicines are sufficiently stocked ✅
        </div>
    @endif
</div>
</x-layout>
