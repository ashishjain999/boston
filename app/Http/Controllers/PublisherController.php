<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{

    protected $publisher;

    public function __construct(Publisher $publisher)
    {
        $this->publisher = $publisher;    
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = $this->publisher->with('books')->get();
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
            'first_name' => 'required',
            'last_name' => 'required',
            'identifier' => 'required|min:3',
        ]);

        $this->publisher->create($request->all());
        return $this->index();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = $this->publisher->with('books')->findOrFail($id);
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
        $item = $this->publisher->with('books')->findOrFail($id);
        $item->update($request->all());
        return response(['data' => $item, 'status' => 200]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = $this->publisher->with('books')->findOrFail($id);
        $item->delete();
        return $this->index();
    }
}
