<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class LastFMController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $validatedFields = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'mimes:png,jpg,jpeg|max:2048',
            'main_text' => 'required|string',
        ]);
        $file = $request->file('image');
        if(isset($file)) {
            if ($path = $file->store('article_images')) {
                $validatedFields['image_name'] = $path;
            } else {
                return response()->json([
                    'error' => "Title and text required"
                ], 422);
            }
        }
        Article::create($validatedFields);
        return response()->json();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        //
    }

    public function showAlbumData(Request $request) {
        $validatedFields = $request->validate([
            'album_name' => 'required|string|max:255',
        ]);
        $apiKey = "51b8221ca7c6afca4ebb657b844a7640";
        $response = Http::get('http://ws.audioscrobbler.com/2.0', [
            'method' => 'album.search',
            'album' => $validatedFields['album_name'],
            'api_key' => $apiKey,
            'format' => 'json',
            'limit' => '1'
        ]);
        $res = $response->json();
        return response()->json($res);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
