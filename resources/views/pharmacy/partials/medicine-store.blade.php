
@if($medicines->count())
@foreach( $medicines as $medicine)
<li>
   <x-cards :highlights="$medicine->quantity < 50">
     <div class="flex items-center justify-between flex-1">
        <div>
            <h1 class='text-xl font-semibold'>{{ $medicine->medicine}}</h1>
            <p class="font-light text-sm">{{ $medicine->group?->group ?? 'No group'}}</p>
            <p>Remaining: {{ $medicine->quantity}}</p>
            <a href={{ route('pharmacy.pharminstock', $medicine->id)}}
            class=" inline-block font-semibold text-blue-500 cursor-pointer">Update Item</a>
        </div>

        <a href="{{ route('pharmacy.show', $medicine->id)}}" class="btn-primary">View Details</a>
     </div>
   </x-cards>
</li>
@endforeach
{{$medicines->links()}}

@else
    <p class="w-1/2">No medicines found.</p>
@endif