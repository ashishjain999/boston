<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected $book;

    public function __construct(Book $book)
    {
        $this->book = $book;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $item = $this->book->with('authors','publisher')->get();
        return response(['data' => $items, 'status' => 200]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'year' => 'required|integer|digits:4',
            'page' => 'required|integer',
            'isbn' => 'required|digits:13|integer|unique:books,isbn',
            'publisher_id' => 'exists:publishers,id',
            'authors' => 'array',
            'authors.*' => 'exists:authors,id',
        ]);
        $item = $this->book->create($request->all());

        $authors = $request->get('authors');
        $item->authors()->sync($authors);
        
        return $this->index();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = $this->book->with('authors', 'publisher')->findOrFail($id);
        return response(['data' => $item, 'status' => 200]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = $this->book->with('authors', 'publisher')->findOrFail($id);
        $item->update($request->all());

        $authors = $request->get('authors');
        $item->authors()->sync($authors);

        return response(['data' => $item, 'status' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = $this->book->with('authors', 'publisher')->findOrFail($id);
        $item->authors()->detach();
        $item->delete();
        return $this->index();

    }
}
