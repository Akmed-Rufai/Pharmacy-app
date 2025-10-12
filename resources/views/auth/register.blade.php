<x-layout>
    <form action="{{ route('register')}}" method="POST" class="mt-5 max-w-screen-sm mx-auto">

      @csrf

      <h2 class="mb-5 font-bold text-xl tracking-wide">Register</h2>

      @if( $errors->any())
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
      <label for="email">Email:</label>
      <input 
        type="email" 
        id="email" 
        name="email"
        value= "{{ old('email')}}"
      >
  
      <label for="password">Password:</label>
      <input 
        type="password" 
        id="password" 
        name="password"
        required
      >
      <label for="password_confirmation">Confirm Password:</label>
      <input 
        type="password" 
        id="password" 
        name="password_confirmation"
        required
      >

      <button type="submit" class="btn-primary mt-4">Register</button>
    </form>
</x-layout>
