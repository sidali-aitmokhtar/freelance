<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Project;
use App\Services\BidService;
use Illuminate\Http\Request;
use App\Http\Requests\BidRequest;

class BidController extends Controller
{

    public function __construct(
        private readonly BidService $bidService
    ){}
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
    public function store(BidRequest $request,Project $project)
    {
        try{
            $bid=$this->bidService->createBid($request,$project);
            return response()->json([
                'success'=>true,
                'message'=>'created a bid successfully',
                'data'=>$bid
            ],201);
        }catch(\Exception $e){
            return response()->json([
                'success'=>false,
                'message'=>$e->getMessage()
            ],500);
        }
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
    public function update(BidRequest $request,Project $project, Bid $bid)
    {
        try{
            $this->bidService->updateBid($request,$project,$bid);
            return response()->json([
                'success'=>true,
                'message'=>'updated the bid successfully'
            ],200);
        }catch(\Exception $e){
            return response()->json([
                'success'=>false,
                'message'=>$e->getMessage()
            ],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BidRequest $request,Project $project ,Bid $bid)
    {
        try{
            $this->bidService->deleteBid($request,$project,$bid);
            return response()->json([
                'seccess'=>true,
                'message'=>'bid deleted successfully'
            ],);
        }catch(\Exception $e){
            return response()->json([
                'success'=>false,
                'message'=>$e->getMessage()
            ],500);
        }
    }
}
