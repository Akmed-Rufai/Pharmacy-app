<x-layout>
    <form action="{{ route('pharmacy.store')}}" method="POST" class="mt-5 w-120 mx-auto max-w-screen-sm">
 
      @csrf

      <h2 class="mb-5 font-bold">Create a New Ninja</h2>

      @if( $errors->any())
        <ul class="bg-red-100 px-6 py-3">
          @foreach( $errors->all() as $error)
              <li class="mt-2 text-red-500">{{$error}}</li>
          @endforeach
        </ul>
      @endif
  
      <label for="medicine">Medicine Name:</label>
      <input 
        type="text" 
        id="medicine" 
        name="medicine" 
        value="{{ old('medicine')}}"
        required
      >
  
      <label for="price">Medicine Price:</label>
      <input 
        type="number" 
        id="price" 
        name="price"
        value="{{ old('price')}}"
        required
      >

      <label for="quantity">Quantity:</label>
      <input 
        type="number" 
        id="quantity" 
        name="quantity"
        value="{{ old('quantity')}}"
      >

      <label for="description">Description:</label>
      <textarea
        rows="5"
        id="description" 
        name="description" 
        placeholder="Type Here"
        required
      >{{ old('description')}}</textarea> 


      <label for="group_id">Medicine groups:</label>
      <select id="group_id" name="group_id">
        <option value="" disabled selected>Select a group</option>
        @foreach ( $groups as $group )
          <option value="{{ $group->id }}" {{ $group->id == old('group_id') ? 'selected' : ''}}>
            {{ $group->group }}
          </option>
        @endforeach
      </select>
  
      <button type="submit" class="btn-primary mt-4">Create Medicine</button>
  
      
    </form>
  </x-layout>
