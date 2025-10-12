<x-layout>
    <form action="{{route('pharmacy.group_create')}}" method="POST" class="mt-5 w-120 mx-auto max-w-screen-sm">
    
      @csrf
  
      <h2 class="mb-5 font-bold">Create a New Group</h2>
  
      <label for="group">Group Name:</label>
      <input 
        type="text" 
        id="group" 
        name="group" 
        required
      >
      <label for="usage">Usage:</label>
      <input 
        type="text" 
        id="usage" 
        name="usage" 
      >
      <label for="medicine">Prescription:</label>
      <input 
        type="text" 
        id="prescription" 
        name="prescription" 
      >
  
      <button type="submit" class="btn-primary mt-4">Create Medicine</button>
      
    </form>
  </x-layout>