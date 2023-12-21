<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{

    protected $author;

    public function __construct(Author $author)
    {
        $this->author = $author;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = $this->author->with('books')->get();
        return response(['data' => $items], 200);
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
            'first_name' => 'required',
            'last_name' => 'required',
            'identifier' => 'required|unique:authors|min:3',
        ]);

        $this->author->create($request->all());
        return $this->index();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = $this->author->with('books')->findOrFail($id);
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
        $item = $this->author->with('books')->findOrFail($id);
        $item->update($request->all());
        return response(['data' => $item, 'status' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = $this->author->with('books')->findOrFail($id);
        $item->books()->detach();
        $item->delete();
        return $this->index();
    }
}
