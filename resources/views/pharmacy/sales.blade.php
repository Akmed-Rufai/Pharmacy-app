
<x-layout>
  @if($sales->count())

  <div class="bg-[#f9f9f9] max-w-screen-lg mx-auto p-5 mt-5">
       <div class="flex items-center">
         <form method="GET" action="{{ route('pharmacy.sales') }}" class="flex gap-2">
                <div>
                  <label for="start_date" class="text-sm font-md text-gray-700">Start Date</label>
                  <input type="date" name="start_date" id="start_date" 
                       value="{{ $startDate ?? '' }}" 
                       class="mt-1 !w-50 h-10 rounded-2xl border-gray-300 shadow-sm sm:text-sm">
                </div>
                
                <div>
                  <label for="end_date" class="text-sm font-md text-gray-700">End Date</label>
                  <input type="date" name="end_date" id="end_date" 
                       value="{{ $endDate ?? '' }}" 
                       class="mt-1 !w-50 h-10 rounded-md border-gray-300 shadow-sm sm:text-sm">
                </div>
        </form>
         <button type="submit" class="btn-primary !mt-9">Apply Filter</button>
                 <a href="{{ route('pharmacy.sales') }}" 
                 class="text-gray-500 hover:text-gray-700 py-2 !mt-5 ml-2">Clear Filter</a>
       </div>
       <h3 class="text-2xl font-semibold tracking-wide">Sales List</h3>
        <div class="flex justify-between mt-3 w-full pr-6 text-lg">
            <label class="flex-4 font-semibold tracking-wide">Medicne Name</label>
            <label class="flex-2 font-semibold tracking-wide">Total</label>
        </div>
      @foreach($sales as $sale)
          <div class="flex items-center justify-between">
            <x-cards :wide='true'>
            <div class="flex flex-3">
            @php
                 // 1. Get the first three items (maximum)
                $firstThreeItems = array_slice($sale->cart_data, 0, 3);
                
                // 2. Extract just the names into a new, simple array
                $names = array_column($firstThreeItems, 'name');
                
                // 3. Concatenate the names with ", " separator
                $concatenatedNames = implode(', ', $names);

                // 4. Check if there are more than 3 items in the original array
                $hasMore = count($sale->cart_data) > 3;
            @endphp

           <p class="tracking-wide">{{$concatenatedNames}}</p>
           
            @if($hasMore)
              <p class="tracking-wide">......</p>
            @endif
            </div>
            <p class="flex-1">{{ $sale->total}} </p>
            <a href="{{ route('pharmacy.showsales', $sale->id)}}" class="btn-primary">View Details</a>
            </x-cards>
          </div>
      @endforeach
  </div>
  @else
    <p class="w-1/2">No Records found.</p>
  @endif
</x-layout>