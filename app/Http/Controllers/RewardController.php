<?php

namespace App\Http\Controllers;

use App\User;
use App\Reward;
use App\Http\Traits\ApiTrait;
use App\Http\Traits\AuthTrait;
use Illuminate\Http\Request;

class RewardController extends Controller
{
    use ApiTrait;
    use AuthTrait;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getReward()
    {
        $user = $this->guard()->user();
        $achievement = $user->achievement;
        $wonReward = collect($achievement[User::WON_REWARD]);
        if ($wonReward->count() > 0) {
            return $this->returnSuccess('No More Reward.');
        }

        $reward = Reward::orderByRaw('-LOG(1.0 - RAND()) / likelihood')
            ->where([
                ['likelihood', '>', 0],
                ['quantity', '>', 0],
            ])->firstOrFail();

        if ($reward) {
            if ($reward->quantity > 0) {
                $newReward = $wonReward->push([
                    'reward_id' => $reward->id,
                    'redeemed' => false,
                ]);
                $achievement[User::WON_REWARD] = $newReward;
                $user->achievement = $achievement;
                $user->save();

                $reward->quantity -= 1;
                $reward->save();
            }

            return $this->returnSuccess('Success.', $reward);
        } else {
            return $this->returnSuccess('No More Reward.');
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRewardTest()
    {
        $reward = Reward::orderByRaw('-LOG(1.0 - RAND()) / likelihood')
            ->where([
                ['likelihood', '>', 0],
                ['quantity', '>', 0],
            ])->firstOrFail();

        if ($reward) {
            return $this->returnSuccess('Success.', $reward);
        } else {
            return $this->returnSuccess('No More Reward.');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $reward = Reward::create($request->only([
            'name',
            'name_e',
            'description',
            'description_e',
            'image',
            'redeemable',
            'quantity',
            'likelihood',
        ]));

        return $this->returnSuccess('Store success.', $reward);
    }
}
