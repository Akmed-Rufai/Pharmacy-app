

<x-layout>
   <div class="details max-w-screen-md mx-auto pt-10">
        <x-cards>
            <div class="flex flex-col w-full">
                <div class="flex justify-between mb-3">
                    <label class="flex-1 font-semibold tracking-wide">Medicne Name</label>
                    <label class="flex-1 font-semibold tracking-wide">Qty</label>
                    <label class="font-semibold tracking-wide">Price</label>
                </div>
                @foreach( $sales->cart_data as $item)
                    <div class="flex justify-between mb-3">
                        <p class="flex-1 tracking-wide">{{ $item['name']}}</p>
                        <p class="flex-1">{{$item['quantity']}}</p>
                        <p>{{$item['price']}}</p>
                    </div>
                @endforeach
                <div class="flex justify-between border-t-2">
                <p class="font-semibold">Total</p>
                <p class="font-semibold">{{ $sales->total}}</p>
                </div>
            </div>
        </x-cards>
        <form action="{{ route('pharmacy.destroysale', $sales->id)}}" method="POST" class="block !w-full mt-5">
            @csrf
            @method('DELETE')
            <button class="bg-blue-700 py-3 cursor-pointer rounded !w-[200px]
             text-white font-semibold block" type="submit">DELETE</button>
        </form>
   </div>
</x-layout>