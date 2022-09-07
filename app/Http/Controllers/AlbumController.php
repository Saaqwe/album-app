<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AlbumController extends Controller
{
    public function store(Request $request) {
        $validatedFields = $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'image_src' => 'required|string|max:500',
        ]);
        $album = Album::create($validatedFields);
        if($album) {
            Log::info("Album with id " . $album['id'] . " and name "
                . $album['title'] . " created");
            return response()->json();
        } else {
            return response()->json([
                "error" => "Error during creating user"
            ], 422);

        }
    }

    public function showAll(Request $request) {
        $validatedFields = $request->validate([
            'offset' => 'integer'
        ]);
        $validatedFields['offset'] = $validatedFields['offset'] ?? 0;
        $albums = Album::orderBy('created_at')
            ->get();
        return response()->json($albums);
    }

    /**
     * Update the specified user.
     *
     * @param Request $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, string $id)
    {
        $validatedFields = $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'image_src' => 'required|string|max:500',
        ]);
        $album = Album::find(intval($id));
        $album->title = $validatedFields['title'];
        $album->artist = $validatedFields['artist'];
        $album->description = $validatedFields['description'];
        $album->image_src = $validatedFields['image_src'];
        $album->save();
        Log::info("Album with id " . $album['id'] . " and name "
            . $album['title'] . " update");
        return response()->json();
    }

    public function destroy($id)
    {
        $album = Album::find(intval($id));
        $album->delete();
        Log::info("Album with id " . $album['id'] . " and name "
            . $album['title'] . " deleted");
        response()->json();
    }
}
