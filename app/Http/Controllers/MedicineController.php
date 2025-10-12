<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicine;
use App\Models\Groups;

class MedicineController extends Controller
{
    function index(Request $request){

        $query = Medicine::with('group');
        $groups = Groups::all();

        if ($request->filled('medicine')) {
            $search = $request->input('medicine');
            $query->where('medicine', 'like', "%{$search}%");
        }
    
        $medicines = $query->orderBy('created_at', 'desc')->paginate(5);
        $allMedicines = Medicine::all();

        if ($request->ajax()) {
            return view('pharmacy.partials.medicine-list', compact('medicines'))->render();
        }

    
        return view('pharmacy.index', [
            'medicines' => $medicines,
            'allMedicines' => $allMedicines,
            'groups'=> $groups
        ]);
    }

    function pharmstore(Request $request){
        $query = Medicine::with('group');

        if ($request->filled('medicine')) {
            $search = $request->input('medicine');
            $query->where('medicine', 'like', "%{$search}%");
        }
    
        $medicines = $query->orderBy('created_at', 'desc')->paginate(5);

        if ($request->ajax()) {
            return view('pharmacy.partials.medicine-store', compact('medicines'))->render();
        }

    
        return view('pharmacy.pharmstore', compact('medicines'));
    }

    function show(Medicine $medicine){
        $medicine->load('group');

        return view('pharmacy.show', ['medicine' => $medicine ]);
    }
    function create(){
        $groups = Groups::all();

        return view('pharmacy.create', ['groups'=> $groups]);
    }

  
    public function pharminstock(Medicine $medicine){

        $groups = Groups::all();
        return view('pharmacy.pharminstock', compact('medicine', 'groups'));
    }
    function store(Request $request){
        
        $validated = $request->validate([
            "medicine" => 'required|string|max:255',
            "price" => 'required|integer|min:0|max:1000',
            "description" => 'required|string|max:255',
            "quantity" => 'required|integer|min:0|max:1000',
            "group_id" => 'nullable|exists:groups,id',
        ]);

        Medicine::create($validated);

        return redirect()->route('pharmacy.index')->with('success', 'medicine created successfully.');
    }

    public function update(Request $request, Medicine $medicine){
    $request->validate([
        'medicine' => 'required|string|max:255',
        'price' => 'required|numeric',
        'quantity' => 'required|numeric',
        'group_id' => 'nullable|exists:groups,id',
    ]);

    $addQuant = $request->input('add-quantity');
    $newquant = $medicine->quantity + $addQuant;

    $medicine->update([
        'medicine' => $request->medicine,
        'price' => $request->price,
        'quantity' => $newquant,
        'group_id' => $request->group_id,
    ]);

    return redirect()->route('pharmacy.index')->with('success', 'medicine updated successfully.');
    }

    function destroy(Medicine $medicine){

        $medicine->delete();

        return redirect()->route('pharmacy.index')->with('success', 'medicine deleted successfully.');
    }

    public function reduceStock(Request $request){
    $cartItems = $request->input('cart', []);

    foreach ($cartItems as $item) {
        $medicine = Medicine::where('medicine', $item['name'])->first();

        if ($medicine) {
            $newQty = max(0, $medicine->quantity - $item['quantity']);
            $medicine->update(['quantity' => $newQty]);
        }
    }

    return response()->json(['status' => 'success', 'message' => 'Stock updated']);

}
    public function restockAlert()
{
    // Get all medicines with low stock
    $lowStock = Medicine::where('quantity', '<=', 50)->get();

    // Pass them to the view
    return view('pharmacy.restock', compact('lowStock'));
}


}
