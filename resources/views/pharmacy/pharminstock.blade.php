<x-layout>
  <form action="{{ route('pharmacy.update', $medicine->id) }}" method="POST" class="mt-5 max-w-screen-sm mx-auto">
    @csrf
    @method('PUT')

    <label for="medicine">Medicine Name:</label>
    <input 
      type="text" 
      id="medicine" 
      name="medicine" 
      value="{{ old('medicine', $medicine->medicine) }}"
      required
    >

    <label for="price">Medicine Price:</label>
    <input 
      type="number" 
      id="price" 
      name="price" 
      value="{{ old('price', $medicine->price) }}"
      required
    >

    <label for="quantity">Quantity:</label>
    <input 
      type="number" 
      id="quantity" 
      name="quantity" 
      value="{{ old('quantity', $medicine->quantity) }}"
      required
    >
    <label for="quantity">Add Quantity:</label>
    <input 
      type="number" 
      id="add-quantity" 
      name="add-quantity"
      placeholder="add quantity"
    >

    <label for="group_id">Medicine groups:</label>
    <select id="group_id" name="group_id">
      <option value="" disabled>Select a group</option>
      @foreach ( $groups as $group )
        <option value="{{ $group->id }}" {{ $medicine->group_id == $group->id ? 'selected' : '' }}>
          {{ $group->group }}
        </option>
      @endforeach
    </select>

    <button type="submit" class="btn-primary mt-4">Update Item</button>
  </form>
</x-layout>
