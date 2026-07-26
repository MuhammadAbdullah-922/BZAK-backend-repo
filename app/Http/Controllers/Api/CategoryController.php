<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)
            ->withCount('products')
            ->get();

        return response()->json([
            'success'    => true,
            'categories' => $categories,
        ]);
    }

    public function show($slug)
    {
        $category = Category::where('slug', $slug)
            ->where('is_active', true)
            ->withCount('products')
            ->firstOrFail();

        return response()->json([
            'success'  => true,
            'category' => $category,
        ]);
    }
}