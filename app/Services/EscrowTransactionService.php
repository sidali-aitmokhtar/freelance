<?php

namespace App\Services;

use App\Models\Bid;
use App\Models\Project;
use App\Models\Contract;
use App\Http\Requests\EscrowTransactionRequest;
use App\Repositories\EscrowTransactionRepository;

class EscrowTransactionService extends BaseService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private readonly EscrowTransactionRepository $escrowtransactionRepository,
        private readonly MilestoneService $milestoneService
    ){}


    public function createEscrow(Contract $contract,Bid $bid){
        

        $data['money']=$bid->bid;
        $data['contract_id']=$contract->id;
        $escrow=$this->escrowtransactionRepository->create($data);
        $this->loginfo('transaction');
        $this->milestoneService->createMilestone($escrow,$bid);
    }

}
