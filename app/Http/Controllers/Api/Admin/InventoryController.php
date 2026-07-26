<?php
namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Inventory::with('product');

        if ($request->low_stock) {
            $query->whereColumn('quantity', '<=', 'low_stock_alert');
        }

        $inventory = $query->paginate(15);

        return response()->json([
            'success'   => true,
            'inventory' => $inventory,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        $inventory = Inventory::findOrFail($id);
        $inventory->update(['quantity' => $request->quantity]);

        return response()->json([
            'success'   => true,
            'message'   => 'Inventory updated successfully',
            'inventory' => $inventory,
        ]);
    }

    public function lowStock()
    {
        $items = Inventory::with('product')
            ->whereColumn('quantity', '<=', 'low_stock_alert')
            ->get();

        return response()->json([
            'success' => true,
            'items'   => $items,
        ]);
    }
}