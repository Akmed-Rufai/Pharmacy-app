

<x-layout>
   <div class="details max-w-screen-sm mx-auto pt-10">
        <h1 class="font-bold text-2xl tracking-wide">{{ $medicine->medicine }}</h1>
        <p class="font-semibold mt-5">Groups</p>
        <x-cards>
            <div>
                <h3 class="font-semibold mt-2">Usage: </h3>
                <p>{{ $medicine->group->usage }}</p>
                <h3 class="font-semibold mt-2">Prescription: </h3>
                <p>{{ $medicine->group->prescription }}</p>
            </div>
        </x-cards>
        <form action="{{ route('pharmacy.destroy', $medicine->id)}}" method="POST" class="block !w-full mt-5">
            @csrf
            @method('DELETE')
            <button class="bg-blue-700 py-3 cursor-pointer rounded !w-[200px]
             text-white font-semibold block" type="submit">DELETE</button>
        </form>
   </div>
</x-layout>
