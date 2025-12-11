<?php

namespace App\Services;

use App\Models\Bid;
use App\Models\Contract;
use App\Models\EscrowTransaction;
use App\Repositories\MilestoneRepository;

class MilestoneService extends BaseService
{
    
    public function __construct(
        private readonly MilestoneRepository $milestoneRepository
    ){}


    public function getMilestone(){

    }

    public function createMilestone(EscrowTransaction $escrow,Bid $bid){
        $milestone=$bid->milestone_json;
        foreach($milestone as $value){
            $this->milestoneRepository->create([
                'escrow_transaction_id' => $escrow->id,
                'step' => $value['step'],
                'description' => $value['description'],
                'price' => $value['price']
            ]);
        }
    }

    
}
