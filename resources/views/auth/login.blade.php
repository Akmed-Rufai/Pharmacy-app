<x-layout>
    <form action="{{ route('login')}}" method="POST" class="mt-5 max-w-screen-sm mx-auto">
      @csrf

      <h2 class="mb-5 font-bold text-xl tracking-wide">Login</h2>

      @if ($errors->any())
        <ul class="bg-red-100 px-6 py-3">
          @foreach( $errors->all() as $error)
              <li class="mt-2 text-red-500">{{$error}}</li>
          @endforeach
        </ul>
      @endif
  
      <label for="name">Username:</label>
      <input 
        type="text" 
        id="name" 
        name="name" 
        value="{{ old('name')}}"
      >
  
      <label for="password">Password:</label>
      <input 
        type="password" 
        id="password" 
        name="password"     
      > 
      <p id="eye">show password</p>
      <button type="submit" class="btn-primary mt-4">Log in</button>
      
    </form>
</x-layout>

<script>
   const flash = document.getElementById('eye');
   const password = document.getElementById('password');

   flash.addEventListener('click', (e)=>{
      password.type = 'text'
    
   })
</script>