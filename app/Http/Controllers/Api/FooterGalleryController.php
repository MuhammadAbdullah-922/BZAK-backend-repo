<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FooterGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FooterGalleryController extends Controller
{
    /**
     * Display all gallery images
     */
    public function index()
    {
        $gallery = FooterGallery::orderBy('sort_order', 'asc')->get();

        return response()->json($gallery);
    }

    /**
     * Store new image
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'nullable|boolean',
            'sort_order' => 'nullable|integer'
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')
                ->store('footer-gallery', 'public');
        }

        $gallery = FooterGallery::create([
            'image' => 'storage/' . $imagePath,
            'status' => $request->status ?? 1,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Footer image added successfully.',
            'data' => $gallery
        ], 201);
    }

    /**
     * Show single image
     */
    public function show(string $id)
    {
        $gallery = FooterGallery::findOrFail($id);

        return response()->json($gallery);
    }

    /**
     * Update image
     */
    public function update(Request $request, string $id)
    {
        $gallery = FooterGallery::findOrFail($id);

        $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'nullable|boolean',
            'sort_order' => 'nullable|integer'
        ]);

        if ($request->hasFile('image')) {

            if ($gallery->image && Storage::disk('public')->exists(str_replace('storage/', '', $gallery->image))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $gallery->image));
            }

            $imagePath = $request->file('image')
                ->store('footer-gallery', 'public');

            $gallery->image = 'storage/' . $imagePath;
        }

        if ($request->has('status')) {
            $gallery->status = $request->status;
        }

        if ($request->has('sort_order')) {
            $gallery->sort_order = $request->sort_order;
        }

        $gallery->save();

        return response()->json([
            'success' => true,
            'message' => 'Footer image updated successfully.',
            'data' => $gallery
        ]);
    }

    /**
     * Delete image
     */
    public function destroy(string $id)
    {
        $gallery = FooterGallery::findOrFail($id);

        if ($gallery->image && Storage::disk('public')->exists(str_replace('storage/', '', $gallery->image))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $gallery->image));
        }

        $gallery->delete();

        return response()->json([
            'success' => true,
            'message' => 'Footer image deleted successfully.'
        ]);
    }
    public function toggleStatus($id)
{
    $gallery = FooterGallery::findOrFail($id);

    $gallery->status = !$gallery->status;
    $gallery->save();

    return response()->json([
        'success' => true,
        'message' => 'Status updated successfully.',
        'data' => $gallery
    ]);
}
}