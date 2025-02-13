<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        try {
            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
    
            // Debugging: Log the filename
            \Log::info('Uploading file: ' . $filename);
    
            $path = $image->storeAs('images', $filename, 'public');
    
            // Debugging: Log the storage path
            \Log::info('File stored at: ' . $path);
    
            $imageModel = Image::create([
                'filename' => $filename,
                'path' => $path,
                'mime_type' => $image->getMimeType(),
                'size' => $image->getSize(),
            ]);
    
            // Debugging: Log the created model
            \Log::info('Image model created: ', $imageModel->toArray());
    
            return response()->json(['message' => 'Image uploaded successfully!', 'data' => $imageModel]);
    
        } catch (\Exception $e) {
            // Debugging: Log the exception
            \Log::error('Image upload error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function show($filename)
{
    $path = storage_path('app/public/images/' . $filename);
    
    if (!file_exists($path)) {
        return response()->json(['error' => 'Image not found'], 404);
    }
    
    return response()->file($path);
}
}

