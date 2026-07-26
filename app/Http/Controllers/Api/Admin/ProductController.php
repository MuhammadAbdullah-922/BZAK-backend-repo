<?php
namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->latest()->paginate(15);

        return response()->json([
            'success'  => true,
            'products' => $products,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id'       => 'required|exists:categories,id',
            'name'              => 'required|string|max:255',
            'description'       => 'nullable|string',
            'short_description' => 'nullable|string',
            'price'             => 'required|numeric|min:0',
            'sale_price'        => 'nullable|numeric|min:0',
            'sizes'             => 'nullable|array',
            'colors'            => 'nullable|array',
            'images'            => 'nullable|array',
            'images.*'          => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'sku'               => 'nullable|string|unique:products',
        ]);

        // Everything except the raw file objects
        $data = $request->except('images', 'quantity');

        // Handle actual uploaded image files
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $imagePaths[] = $file->store('products', 'public');
            }
        }
        $data['images'] = $imagePaths;
        $data['slug']   = Str::slug($request->name) . '-' . Str::random(5);

        // Auto-generate SKU if the admin left it blank
        if (empty($data['sku'])) {
            $data['sku'] = $this->generateSku($request->name);
        }

        $product = Product::create($data);

        // Create Inventory
        if ($request->sizes && $request->colors) {
            foreach ($request->sizes as $size) {
                foreach ($request->colors as $color) {
                    Inventory::create([
                        'product_id' => $product->id,
                        'size'       => $size,
                        'color'      => $color,
                        'quantity'   => $request->quantity ?? 0,
                    ]);
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'product' => $product,
        ], 201);
    }

    public function show($id)
    {
        $product = Product::with(['category', 'inventory', 'reviews'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'product' => $product,
        ]);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'sku'         => 'nullable|string|unique:products,sku,' . $id,
            'images'      => 'nullable|array',
            'images.*'    => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'remove_images'   => 'nullable|array',
            'remove_images.*' => 'string',
        ]);

        $data = $request->except('images', 'remove_images', 'quantity');

        // Don't overwrite the existing SKU with a blank value
        if (empty($data['sku'])) {
            unset($data['sku']);
        }

        // Start from whatever images the product already has
        $currentImages = $product->images ?? [];

        // Remove any images the admin explicitly deleted
        if ($request->filled('remove_images')) {
            foreach ($request->remove_images as $path) {
                Storage::disk('public')->delete($path);
            }
            $currentImages = array_values(array_diff($currentImages, $request->remove_images));
        }

        // Append any newly uploaded images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $currentImages[] = $file->store('products', 'public');
            }
        }

        $data['images'] = $currentImages;

        $product->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'product' => $product,
        ]);
    }

    /**
     * Build a unique SKU like "BZK-TEE-001" from the product name.
     * Uses the first 3 letters of the name as a prefix, then finds
     * the next free running number for that prefix.
     */
    private function generateSku(string $name): string
    {
        $prefix = 'BZK-' . strtoupper(Str::substr(preg_replace('/[^A-Za-z]/', '', $name) ?: 'PRD', 0, 3));

        $lastNumber = Product::where('sku', 'like', $prefix . '-%')
            ->orderByDesc('id')
            ->value('sku');

        $next = 1;
        if ($lastNumber && preg_match('/-(\d+)$/', $lastNumber, $m)) {
            $next = (int) $m[1] + 1;
        }

        return $prefix . '-' . str_pad($next, 3, '0', STR_PAD_LEFT);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Clean up image files from disk too
        foreach ($product->images ?? [] as $path) {
            Storage::disk('public')->delete($path);
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully',
        ]);
    }
}