<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\sales;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SalesController extends Controller{
    public function cartStore(Request $request){
        $cart = $request->input('cart');

        if (!is_array($cart) || empty($cart)) {
            return response()->json(['error' => 'Invalid cart format'], 400);
        }

        $total = collect($cart)->reduce(function ($carry, $item) {
            return $carry + ($item['quantity'] * $item['price']);
        }, 0);

        sales::create([
            'cart_data' => $cart,
            'total' => $total,
            'user_id' => Auth::id() // Associate with current user
        ]);

        return response()->json(['message' => 'Cart saved as JSON']);
    }

    public function index(Request $request){

        $query = sales::where('user_id', auth()->id());

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        
        if ($startDate && $endDate) {
            
            // Ensure dates are valid and set end date to end of the day
            // This makes the filter inclusive up to the very last second of the end day.
            $start = Carbon::parse($startDate)->startOfDay();
            $end = Carbon::parse($endDate)->endOfDay();
            
            // Filter sales records between the two dates (inclusive)
            $query->whereBetween('created_at', [$start, $end]);
        }

        // 4. Execute the final query
        // ->withQueryString() ensures pagination links keep the date filters in the URL
        $sales = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        // 5. Pass the sales data and the current filter dates to the view
        return view('pharmacy.sales', [
            'sales' => $sales,
            'startDate' => $startDate, // Used to pre-fill the form
            'endDate' => $endDate      // Used to pre-fill the form
        ]);
    }
    public function show($id){

        $sales = sales::findOrfail($id);

        return view('pharmacy.showsales', ['sales'=> $sales]);
    }

    public function destroy(Sales $sales){

        $sales->delete();

        return redirect()->route('pharmacy.sales');
    }

}
