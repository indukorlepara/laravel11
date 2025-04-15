<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Post;

class ImageController extends Controller
{
    public function uploadImage(Request $request)
    {
        // Validate the image upload
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validation rules for the image
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Handle the image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // Generate a unique name for the image
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // Store the image on the public disk
            $path = $image->storeAs('images', $imageName, 'public');

              // Get the post by the provided post_id
              $post = Post::find($request->post_id);

              // Update the post with the image path
              $post->image_path = $path;
              $post->save();

            // Return the image path in the response
            return response()->json(['message' => 'Image uploaded successfully', 'path' => $path], 200);
        }

        return response()->json(['error' => 'No image file provided'], 400);
    }
}
