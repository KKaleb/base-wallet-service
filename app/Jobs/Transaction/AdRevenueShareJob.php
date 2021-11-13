<?php

namespace App\Jobs\Transaction;

use App\Models\Wallet;
use App\Models\AdRevenueShareGroup;
use App\Models\Transaction;
use App\Models\TransactionCategory;
use App\Models\TransactionChannel;

class AdRevenueShareJob extends Job
{
    protected $influencerID;
    protected $audienceID;
    protected $camapignID;
    protected $adBreakerActivityID;
    protected $channel;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($influencerID=null, $audienceID, $camapignID, $adBreakerActivityID, $channel)
    {
        $this->influencerID = $influencerID;
        $this->audienceID = $audienceID;
        $this->camapignID = $camapignID;
        $this->adBreakerActivityID = $adBreakerActivityID;
        $this->channel = $channel;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            \DB::transaction(function () {
                // category ID
                $categoryID = TransactionCategory::where('name', 'ad_revenue')->firstOrFail()->id;
                // category ID
                $channelID = TransactionChannel::where('name', $this->channel)->firstOrFail()->id;

                // disburse group 1
                $groupOne = AdRevenueShareGroup::where('group', 1)->firstOrFail();
                $platformOwnerwallet = Wallet::where('ad_revenue_share_group_id', $groupOne->id)->firstOrFail();
                $platformOwnerwallet->balance += 0.7 * $groupOne->share_percent;
                $platformOwnerwallet->save();
                $this->createTransactionHistory($platformOwnerwallet->id, $categoryID, $channelID, $this->adBreakerActivityID, 0.7 * $groupOne->share_percent);

                // disburse group 2
                $groupTwo = AdRevenueShareGroup::where('group', 2)->firstOrFail();
                $partnerWallet = Wallet::where('ad_revenue_share_group_id', $groupTwo->id)->firstOrFail();
                $partnerWallet->balance += 0.7 * $groupTwo->share_percent;
                $partnerWallet->save();
                $this->createTransactionHistory($partnerWallet->id, $categoryID, $channelID, $this->adBreakerActivityID, 0.7 * $groupTwo->share_percent);

                // disburse group 3
                $audienceWallet = Wallet::where('user_id', $this->audienceID)->firstOrFail();
                $groupThree = AdRevenueShareGroup::findOrFail($audienceWallet->ad_revenue_share_group_id);
                $audienceWallet->balance += 0.7 * $groupThree->share_percent;
                $audienceWallet->save();
                $this->createTransactionHistory($audienceWallet->id, $categoryID, $channelID, $this->adBreakerActivityID, 0.7 * $groupThree->share_percent);


                // disburse influencer
                if ($this->influencerID) {
                    $influencerWallet = Wallet::where('user_id', $this->influencerID)->firstOrFail();
                    $influencerWallet->balance += 0.7 * $groupThree->influencer_percent;
                    $influencerWallet->save();
                    $this->createTransactionHistory($influencerWallet->id, $categoryID, $channelID, $this->adBreakerActivityID, 0.7 * $groupThree->influencer_percent);
                }
            });
        } catch (\Throwable $th) {
            report($th);
        }
    }

    public function createTransactionHistory($wallet_id, $category_id, $channel_id, $reference, $amount)
    {
        Transaction::create([
            'wallet_id' => $wallet_id,
            'category_id' => $category_id,
            'channel_id' => $channel_id,
            'amount' => $amount,
            'reference' => $reference,
            'status' => 'success'
        ]);
    }
}
