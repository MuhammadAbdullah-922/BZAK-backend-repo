<?php
namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'customer')
            ->withCount('orders')
            ->withSum('orders', 'total');

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        $customers = $query->latest()->paginate(15);

        return response()->json([
            'success'   => true,
            'customers' => $customers,
        ]);
    }

    public function show($id)
    {
        $customer = User::where('role', 'customer')
            ->with(['orders' => function($q) {
                $q->latest()->take(10);
            }])
            ->findOrFail($id);

        return response()->json([
            'success'  => true,
            'customer' => $customer,
        ]);
    }

    public function destroy($id)
    {
        $customer = User::findOrFail($id);
        $customer->delete();

        return response()->json([
            'success' => true,
            'message' => 'Customer deleted successfully',
        ]);
    }
}