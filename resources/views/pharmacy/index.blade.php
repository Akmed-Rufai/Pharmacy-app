
<x-layout>
    <div class="container">
        <div class="modal flex relative flex-col items-center py-5 gap-2 ">
                <div class="flex justify-center items-center border-b-1 w-1/2">
                    <h3 class="text-xl font-semibold text-blue-700 mb-3">Pharmacy</h3>
                </div>
                <div class="modal-body flex-1 mt-4"></div>
                <div class="flex flex-col py-5 ">
                    <div class="text-center">
                        <strong>Total - </strong>
                        <span id="tota"></span>
                    </div>
                    <p>Thanks for your patronage, Hope to see you soon</p>
                    <div class="flex gap-2">
                        <button type="button" class="btn-primary-modal" id="prt-btn" onclick="printAndSave()">Print</button>
                        <button class="text-xl close-btn btn-primary-modal" id="cancel-btn">X Cancel</button>
                    </div>
                </div>
        </div>
    
        <div class="sidebar flex justify-around">
            <div class="left-side bg-[#fbfbfb] active h-full list-none 
            flex flex-col gap-25 cursor-pointer z-30">
                <div class="show active bg-blue-400">
                    <div id="top" class="bar rounded-2xl"></div>
                    <div id="bot" class="bar rounded-2xl"></div>
                </div>
              <div>
                <a href="{{ route('pharmacy.index')}}">
                    <i class="fas fa-home mr-2 text-2xl text-blue-600"></i>Home
                </a>
                <a href="{{ route('pharmacy.pharmstore')}}">
                    <i class="fas fa-store mr-2 text-2xl text-blue-600"></i>Store
                </a>
                <a href="{{ route('pharmacy.sales')}}">
                    <i class="fa fa-wallet mr-2 text-2xl text-blue-600"></i>Sales
                </a>
                <a><i class="fas fa-user mr-2 text-2xl text-blue-600"></i>Profile</a>
                <a><i class="fa fa-gear  mr-2 text-2xl text-blue-600"></i>Settings</a>
              </div>
                <form class="mt-10" action="{{ route('logout')}}" method="POST">
                    @csrf
                    <button class="cursor-pointer">
                        <i class="fa-solid
                         fa-right-from-bracket mr-2 text-2xl text-blue-600"></i>Logout
                    </button>
                </form>
        </div>
    </div> 

        <div class="flex py-15 w-250 mx-auto justify-around rounded-sm h-auto gap-5">
            <form id='form-cart'class="bg-[#f9f9f9] w-1/2 gap-2 border-1 border-gray-200 px-6
             py-9 hover:shadow-lg rounded-sm">
             
                @csrf
          
               <label for="medicine" class="text-lg mb-1  inline-block tracking-wide">Medicine Name:</label>
                <input type="text" id="medicine" name="medicine"
                placeholder="search medicine"
                class="!w-full !mb-2"
                autocomplete="off"
                >
                <div id='search-result'></div>
          
                <label for="quantity" class="text-lg mb-1 inline-block tracking-wide">Quantity:</label>
                <input 
                  type="number" 
                  id="quantity" 
                  name="quantity" 
                  class="!w-full"
                >
                <label for="group_id">Medicine groups:</label>
                <select id="group_id" name="group_id" class="!w-full">
                    <option value="" disabled selected>Select a group</option>
                    @foreach ( $groups as $group )
                    <option value="{{ $group->id }}">
                        {{ $group->group }}
                    </option>
                    @endforeach
                </select>
            
                <button type="submit" class="btn-primary !mt-5 py-5 !w-full !tracking-wider">Add To Cart</button>
                            
              </form>

            <div id="medicine-results" class="w-1/2 bg-[#fcfcfc]">
                @include('pharmacy.partials.medicine-list', ['medicines' => $medicines])
            </div>
        </div>
    </div>
</x-layout>

<script>
    window.allMedicines = @json($allMedicines);
</script>
@vite(['resources/js/app.js'])