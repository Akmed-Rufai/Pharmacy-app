<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Home</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
     
   @vite(['resources/css/app.css', 'resources/js/app.js'])
 
</head>
<body>
     @if(session('success'))
        <div id='flash' class="text-center bg-red-500 p-4 text-white
         font-semibold transition-opacity duration-200 ease-in-out tracking-wide">
            {{session('success')}}
        </div>
    @endif
    <header>
        @auth
        <nav>
            <a class="logo tracking-wide" href="{{ route('pharmacy.index')}}">Pharmacy</a>
            
            <a class="inline-block hover:bg-blue-500 p-2 rounded
            tracking-wide" href="{{ route('pharmacy.create')}}">Add Drugs</a>
            <a class="inline-block hover:bg-blue-500 p-2 rounded
            tracking-wide" href="{{ route('pharmacy.group')}}">Add Groups</a>
            <a class="tracking-wide hover:bg-blue-500 p-2 rounded" href= "{{ route('pharmacy.pharmstore')}}">Store</a>
            <a class="tracking-wide hover:bg-blue-500 p-2 rounded" href="{{ route('pharmacy.sales')}}">Sales</a>
        </nav>
         @endauth
         @guest
        <div class="w-2/3 mx-auto flex justify-between items-center">
            <a class="logo tracking-wide" href="{{ route('pharmacy.index')}}">Pharmacy</a>
            <a href="{{ route('show.login')}}" class="btn-primary tracking-wide">Login</a>   
        </div>
        @endguest
        @auth
        <div class="flex gap-2 items-center">
            <a href="{{ route('pharmacy.restock') }}" class="relative">
                <i class="fas fa-bell text-2xl hover:text-3xl "></i> 
                
                @if(\App\Models\Medicine::where('quantity', '<=', 50)->exists())
                    <span class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full px-1">!</span>
                @endif
            </a>
            <span class="font-semibold text-sm text-white">
                 welcome, <span class="font-bold text-lg cursor-pointer tracking-wide">{{ Auth::user()->name}}</span>
            </span>
            <form action="{{ route('logout')}}" method="POST">
                @csrf
                <button class="btn-primary cursor-pointer">Logout</button>
            </form>

            <i class="fa-solid fa-bag-shopping fa-2x text-white show-left actives cursor-pointer"></i>
            <div class="items h-full bg-[#f0f0f0] active absolute top-26 !p-2 text-gray-700">
                 <button id="clear-cart" class="text-left mb-2">clear cart</button>
                <div class="item-cart"></div>
                <div class="flex justify-end mt-2">
                   <strong class="tot">Total</strong>
                   <span id="total" class="ml-2 block tot">0</span>
                </div>
                 <p id='empty' class="text-center text-xl mt-10">cart is empty</p>
                <button type="submit" class="btn-primary mt-4 pay !w-full">PAY</button>
            </div>
        </div>
        @endauth
       
    </header>

    <main class="w-full">
        {{$slot}}
    </main>
</body>
</html>
