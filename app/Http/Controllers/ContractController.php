<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Project;
use App\Models\Contract;
use Illuminate\Http\Request;
use App\Policies\ContractPolicy;
use App\Models\EscrowTransaction;
use App\Services\ContractService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ContractRequest;
use App\Http\Requests\StoreContractRequest;
use App\Http\Requests\UpdateContractRequest;

class ContractController extends Controller
{

    public function __construct(
        private readonly ContractService $contractService
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
    // public function create(Project $project,Bid $bid,Request $request)
    // {
    //     // eclipse for modeling
    //     Gate::authorize('create',[Contract::class,$project,$bid]);
    //     $user=$request->user();
    //     $val=$request->validate([
    //         'yes'=>'required'
    //     ]);
    //     if($request->yes!='yes'){
    //         return response()->json('you did not accept',400);
    //     }

    //     // if(!$user->two_factor_code){
    //     //     $code=rand(100000,999999);

    //     //     $user->update([
    //     //         'two_factor_code'=>$code,
    //     //         'two_factor_expires_at'=>now()->addMinutes(2)
    //     //     ]);

    //     //     //Mail::to($user->email)->send(new TwoFactorCodeMail($code));
    //     // }

    //     $contract=Contract::factory()->create([
    //         'freelancer_id'=>$bid->freelancer_id,
    //         'project_id'=>$project->id,
    //         'price'=>$bid->bid
    //     ]);
    //     $request->user()->money-=$bid->bid;
    //     EscrowTransaction::factory()->create([
    //         'contract_id'=>$contract->id,
    //         'money'=>$contract->price
    //     ]);

    //     return response()->json('you have accepted this bid now the contract is created',201);
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContractRequest $request,Project $project,Bid $bid)
    {
        try{
            $contract=$this->contractService->createContract($request,$project,$bid);
            return response()->json([
                'success'=>true,
                'message'=>'contract created successfully',
                'data'=>$contract
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
    public function show(Request $request,Contract $contract)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contract $contract)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContractRequest $request, Contract $contract)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,Contract $contract)
    {
        //
    }
}
