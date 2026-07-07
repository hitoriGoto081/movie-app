<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Genre;
use Illuminate\Support\Facades\Validator;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movies = Movie::with('genre')->get();

        return response()->json([
            'status' => true,
            'message' => 'Data movie berhasil diambil',
            'data' => $movies
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'genre_id' => 'required|exists:genres,id',
            'judul' => 'required|string|max:255',
            'sutradara' => 'required|string|max:255',
            'tahun_rilis' => 'required|digits:4|integer',
            'deskripsi' => 'nullable|string',
            'rating' => 'required|numeric|min:0|max:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $movie = Movie::create([
            'genre_id' => $request->genre_id,
            'judul' => $request->judul,
            'sutradara' => $request->sutradara,
            'tahun_rilis' => $request->tahun_rilis,
            'deskripsi' => $request->deskripsi,
            'rating' => $request->rating,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Movie berhasil ditambahkan',
            'data' => $movie->load('genre')
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $movie = Movie::with('genre')->find($id);

        if (!$movie) {
            return response()->json([
                'status' => false,
                'message' => 'Movie tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data movie berhasil ditemukan',
            'data' => $movie
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $movie = Movie::find($id);

        if (!$movie) {
            return response()->json([
                'status' => false,
                'message' => 'Movie tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'genre_id' => 'required|exists:genres,id',
            'judul' => 'required|string|max:255',
            'sutradara' => 'required|string|max:255',
            'tahun_rilis' => 'required|digits:4|integer',
            'deskripsi' => 'nullable|string',
            'rating' => 'required|numeric|min:0|max:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $movie->update([
            'genre_id' => $request->genre_id,
            'judul' => $request->judul,
            'sutradara' => $request->sutradara,
            'tahun_rilis' => $request->tahun_rilis,
            'deskripsi' => $request->deskripsi,
            'rating' => $request->rating,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Movie berhasil diupdate',
            'data' => $movie->load('genre')
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $movie = Movie::find($id);

        if (!$movie) {
            return response()->json([
                'status' => false,
                'message' => 'Movie tidak ditemukan'
            ], 404);
        }

        $movie->delete();

        return response()->json([
            'status' => true,
            'message' => 'Movie berhasil dihapus'
        ], 200);
    }
}
