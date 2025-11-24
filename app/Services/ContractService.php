<?php

namespace App\Services;

use App\Models\Bid;
use App\Models\Project;
use App\Models\Contract;
use App\Http\Requests\ContractRequest;
use App\Repositories\ContractRepository;

class ContractService extends BaseService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private readonly ContractRepository $contractRepository
    ){}

    public function createContract(ContractRequest $request,Project $project,Bid $bid){
        $this->logwithcontext('creating a contract',[
            'operation'=>'creation',
            'by'=>$request->user()->id
        ]);


        //$project->withcount(bid)<2

        $this->noRepeat($project);
        $this->bidBelongsToProject($request,$project,$bid);
        $this->haveMoney($request,$project,$bid);
        $this->haveBids($project,$bid);

        $data=$request->validated();
        $data['price']=$bid->bid;
        $data['project_id']=$project->id;
        $data['freelancer_id']=$bid->freelancer_id;
        $contract=$this->contractRepository->create($data);

        $this->loginfo('created');
        return $contract;
        
    }

    


    private function noRepeat(Project $project){
        $exist=Contract::where('project_id',$project->id)->exists();
        if($exist){
            $this->logerror('you already created a contract');
            throw new \Exception('you already created a contract');
        }
        return ;
    }



    private function bidBelongsToProject(ContractRequest $request,Project $project,Bid $bid){
        $user=$request->user();
        if($project->id!==$bid->project_id){
            throw new \Exception('this bid is not for this project');
        }
        if($user->id!==$project->client_id){
            throw new \Exception('this project is not from this person');
        }
        return ;
    }

    private function haveMoney(ContractRequest $request,Project $project,Bid $bid){
        $user=$request->user();
        if($user->money<$bid->bid){
            throw new \Exception('you do not have the amount of money needed');
        }
        return ;
    }

    private function haveBids(Project $project,Bid $bid){
        $bidsCount=Bid::where('project_id',$project->id)->count();
        if($bidsCount<2){
            throw new \Exception('you should at least have two bids to accept one');
        }
        return ;
    }

}
