<?php

namespace App\Jobs\Wallet;

use App\Models\Wallet;
use App\Models\AdRevenueShareGroup;

class CreateJob extends Job
{
    protected $userID;
    protected $groupNum;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($userID, $groupNum=0)
    {
        $this->userID = $userID;
        $this->groupNum = $groupNum;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            // if groupNum is 0, wallet owner is an Audience. Default group Number
            // if groupNum is 1, wallet owner is a platform owner
            // if groupNum is 2, wallet owner is a partner
            if ($this->groupNum == 0) {
                $this->groupNum = 3;
            }
            $group_id = AdRevenueShareGroup::where('group', $this->groupNum)->firstOrFail()->id; 
            $wallet = Wallet::firstOrCreate([
                'user_id' => $this->userID,
                'ad_revenue_share_group_id' => $this->groupNum
            ]);
        } catch (\Throwable $th) {
            report($th);
        }
    }
}
