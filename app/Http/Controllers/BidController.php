<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBidRequest;
use App\Http\Requests\UpdateBidRequest;

class BidController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id,Request $request)
    {
        //
        $val=$request->validate([
            'bid'=>'required'
        ]);
        Bid::factory()->create([
            'freelancer_id'=>$request->user()->id,
            'project_id'=>$id,
            'bid'=>$request->bid]
        );
        
        
        return response()->json('your bid is saved',201);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBidRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Bid $bid)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bid $bid)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBidRequest $request, Bid $bid)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bid $bid)
    {
        //
    }
}
