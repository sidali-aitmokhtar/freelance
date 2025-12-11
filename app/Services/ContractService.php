<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Bid;
use App\Models\Project;
use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests\ContractRequest;
use App\Http\Resources\ContractResource;
use App\Repositories\ContractRepository;
use function Symfony\Component\Clock\now;

class ContractService extends BaseService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private readonly ContractRepository $contractRepository,
        private readonly EscrowTransactionService $escrowService
    ){}

    public function getContracts(Request $request){
        $this->logwithcontext('getting contracts',[
            'operation'=>'getting',
            'by'=>$request->user()->id
        ]);
        $contracts=$this->contractRepository->all();
        return  ContractResource::collection($contracts);
    }

    public function createContract(ContractRequest $request,Project $project,Bid $bid){
        $this->logwithcontext('creating a contract',[
            'operation'=>'creation',
            'by'=>$request->user()->id
        ]);

        $this->logwithcontext('creating a contract',[
            'operation'=>'creation',
            'bid accepted'=>$bid->id,
            'accepted by'=>$request->user()->id
        ]);
        

        $this->noRepeat($project);
        $this->bidBelongsToProject($request,$project,$bid);
        $this->haveMoney($request,$bid);
        $this->haveBids($project,$bid);

        $this->loginfo('authorization checked');

        $data=$request->validated();
        $data['price']=$bid->bid;
        $data['project_id']=$project->id;
        $data['freelancer_id']=$bid->freelancer_id;
        $data['dead_line']=Carbon::now()->addMonths($bid->months)->addDays($bid->days)->format('y-m-d');
        $contract=$this->contractRepository->create($data);

        $this->escrowService->createEscrow($contract, $bid);

        $this->status($project,$bid);

        $this->loginfo('created');
        return $contract;
        
    }

    public function deleteContract(Request $request,Contract $contract){
        $this->logwithcontext('deleting the contract',[
            'operation'=>'deleting',
            'contract'=>$contract->id,
            'by'=>$request->user()->id
        ]);

        $this->access($request,$contract);
        
        $this->contractRepository->delete($contract->id);

        $this->loginfo('deleted');
        return ;
    }

    private function access(Request $request,Contract $contract){
        $user=$request->user();
    
        if($user->id===$contract->project->client_id||$user->hasRole('admin')){
            $this->loginfo('access check');
            return ;
        }
        $this->logerror('you are not the owner of this contract');
        throw new \Exception('you are not the owner of this contract',403);
        

    }

    private function noRepeat(Project $project){
        $exist=Contract::where('project_id',$project->id)->exists();
        if($exist){
            $this->logerror('you already created a contract');
            throw new \Exception('you already created a contract',409); // 409 denotes a conflict because a contract for this project already exists
        }
        $this->loginfo('no repeat check');
        return ;
    }



    private function bidBelongsToProject(ContractRequest $request,Project $project,Bid $bid){
        $user=$request->user();
        if($project->id!==$bid->project_id){
            throw new \Exception('this bid is not for this project',422); // 422 states the provided bid cannot be processed for this project
        }
        if($user->id!==$project->client_id){
            throw new \Exception('this project is not from this person',403); // 403 because only the owning client can create the contract
        }
        $this->loginfo('the owner is the owner and the bid in from the project check');
        return ;
    }

    private function haveMoney(ContractRequest $request,Bid $bid){
        $user=$request->user();
        if($user->money<$bid->bid){
            throw new \Exception('you do not have the amount of money needed',422); // 422 indicates the request is valid but cannot be fulfilled due to insufficient funds
        }
        $this->loginfo('have enough amount of money check');
        return ;
    }

    private function haveBids(Project $project,Bid $bid){
        $bidsCount=Bid::where('project_id',$project->id)->count();
        if($bidsCount<2){
            throw new \Exception('you should at least have two bids to accept one',422); // 422 because business rules prevent proceeding without at least two bids
        }
        $this->loginfo('have more than one bid check');
        return ;
    }

//'accepted','denaied','hanging'
    private function status(Project $project,Bid $bid){
        $this->loginfo('updating the project bids staus');
        // Bid::query()->where('project_id',$project->id)->where('id','!=',$bid->id)->update([
        //     'status'=>'denaid'
        // ]);
        DB::table('bids')->where('project_id',$project->id)
                         ->where('id','!=',$bid->id)
                         ->update(['status'=>'denied']);
        $bid->update(['status'=>'accepted']);
        $this->loginfo('bids status updated');
    }

}
