

@if($medicines->count())
<ul class="cart">
  @foreach( $medicines as $medicine)
    <li class="cart-items transition-shadow duration-300 hover:shadow-lg">
      <x-cards :highlights="$medicine->quantity < 50">
        <div>
            <h1 class='text-xl font-semibold tracking-wide title text-blue-700 '>{{ $medicine->medicine}}</h1>
            <p class="tracking-wide font-light text-sm group">{{ $medicine->group?->group ?? 'no group'}}</p>
        </div>
        <h1 class="text-2xl price">{{ $medicine->price}}</h1>
      </x-cards>
    </li>
  @endforeach
  {{ $medicines->links() }}
</ul>

@else
    <p class="w-1/2">No medicines found.</p>
@endif