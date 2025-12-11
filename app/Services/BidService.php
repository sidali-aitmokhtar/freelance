<?php

namespace App\Services;

use App\Models\Bid;
use App\Models\Project;
use App\Filters\BidFilter;
use Illuminate\Http\Request;
use App\Http\Requests\BidRequest;
use App\Http\Resources\BidResource;
use App\Repositories\BidRepository;

class BidService extends BaseService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private readonly BidRepository $bidRepository
    ){}


    public function getBids(Project $project,BidFilter $filter){
        // $query=$this->bidRepository->query();

        $bid=$filter->apply(Bid::query())->where('project_id',$project->id)->get();

        // $bid->where('project_id',$project->id);

        return BidResource::collection($bid);
    }



    public function createBid(BidRequest $request,Project $project){
        $this->logwithcontext('creating a bid',[
            'operation'=>'creation',
            'by'=>$request->user()->id
        ]);
        $milestone=$request->milestone_json;
        $this->price($request,$milestone);
        $this->already($request,$project);

        $data=$request->validated();
        $data['project_id']=$project->id;
        $data['freelancer_id']=$request->user()->id;
        return $this->bidRepository->create($data);
    }


    public function updateBid(BidRequest $request,Project $project,Bid $bid){
        $this->logwithcontext('updating bid',[
            'operation'=>'updating',
            'by'=>$request->user()->id
        ]);

        $milestone=$request->milestone_json;
        $this->price($request,$milestone);

        $this->same($bid,$project);
        $this->access($request,$bid);

        $data=array_filter($request->validated(),fn($val)=>!is_null($val));
        $bid=$this->bidRepository->update($data,$bid->id);
        $this->loginfo('updated');
        return $bid;
    }




    public function deleteBid(BidRequest $request,Project $project ,Bid $bid){
        $this->logwithcontext('deleting the bid',[
            'operation'=>'deleting',
            'bid'=>$bid->id,
            'by'=>$request->user()->id
        ]);


        $this->same($bid,$project);
        $this->access($request,$bid);


        $this->loginfo('deleted');

        
        return $this->bidRepository->delete($bid->id);

    }


    private function already(BidRequest $request,Project $project){
            $user=$request->user();
            $exist=Bid::where('freelancer_id',$user->id)
                        ->where('project_id',$project->id)
                        ->exists();
            
            if($user->hasRole('admin')){
                $this->loginfo('you are the admin');
                return ;
            }
            if($exist){
                $this->logerror('you already have bid try updating your bid instead');
                throw new \Exception('you already have bid try updating your bid instead',409); // 409 reflects a conflict because the freelancer already created a bid for this project
            }
            $this->loginfo('everything id good');
            return ;
        }


    private function same(Bid $bid,Project $project){
        if($bid->project_id===$project->id){
            return ;
        }
        throw new \Exception('this bid is not for this project',400);
    }



    private function access(BidRequest $request,Bid $bid){
        $user=$request->user();
        
        if($user->hasRole('freelancer') && $user->id===$bid->freelancer_id){
            $this->loginfo('your bid');
            return ;
        }
        $this->logerror('rak ta3rf rani bdit nkrah');
        throw new \Exception('rak ta3rf rani bdit nkrah',403);
    }

    private function price(Request $request,$milestone=[]){
        $price=0;
        foreach($milestone as $value){
            $price+=$value['price'];
        }
        if($price!=$request->bid){
            $this->logerror('the prices do not match');
            throw new \Exception('the prices do not match');
        }
        $this->loginfo('the prices match');
        return ;
    }



}
