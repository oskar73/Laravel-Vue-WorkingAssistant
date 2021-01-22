<?php

namespace App\Traits;

use App\Integration\Stripe;
use App\Models\Price;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait RecurringPrice
{
    public function prices(): MorphMany
    {
        return $this->morphMany(
            Price::class,
            'prices',
            'model_type',
            'model_id'
        );
    }

    public function approvedPrices(): MorphMany
    {
        return $this->morphMany(
            Price::class,
            'prices',
            'model_type',
            'model_id'
        )->where('status', 1)
            ->orderBy('standard', 'DESC')
            ->orderBy('recurrent', 'DESC')
            ->orderBy('price', 'ASC');
    }

    public function standardPrice(): MorphOne
    {
        return $this->morphOne(
            Price::class,
            'prices',
            'model_type',
            'model_id'
        )->where('status', 1)
            ->orderBy('standard', 'DESC');
    }

    public function priceRule($request)
    {
        $rule['slashed_price'] = 'nullable|regex:/^\d+(\.\d{1,2})?$/';
        if ($request->edit_price == null) {
            $rule['payment_type'] = 'required|in:1,0';
            $rule['price'] = 'required|regex:/^\d+(\.\d{1,2})?$/';
            if ($request->payment_type == 1) {
                $rule['period'] = 'required|numeric|min:1';
                $rule['period_unit'] = 'required|in:day,week,month,year';
            }
        } else {
            $rule['price'] = 'nullable|regex:/^\d+(\.\d{1,2})?$/';
        }

        return $rule;
    }

    public function createPriceRule($request)
    {
        $rule['price'] = 'required|regex:/^\d+(\.\d{1,2})?$/';
        $rule['slashed_price'] = 'nullable|regex:/^\d+(\.\d{1,2})?$/';
        $rule['payment_type'] = 'required|in:1,0';
        if ($request->payment_type == 1) {
            $rule['period'] = 'required|numeric|min:1';
            $rule['period_unit'] = 'required|in:day,week,month,year';
        }

        return $rule;
    }

    public function updatePriceRule($request)
    {
        $rule['slashed_price'] = 'nullable|regex:/^\d+(\.\d{1,2})?$/';
        $rule['price'] = 'nullable|regex:/^\d+(\.\d{1,2})?$/';

        return $rule;
    }

    public function savePrice($request)
    {
        if ($request->edit_price == null) {
            return $this->createPrice($request);
        } else {
            return $this->updatePrice($request);
        }
    }

    public function createPrice($request)
    {
        $item = $this;
        $price['stripe'] = 1;
        $price['standard'] = $request->standard ? 1 : 0;
        $price['status'] = $request->status ? 1 : 0;
        $price['price'] = $request->price;
        $price['slashed_price'] = $request->slashed_price;
        $price['recurrent'] = $request->payment_type;

        if ($request->payment_type == 1) {
            $stripe = new Stripe();
            $name = $item->name.', $'.formatNumber($request->price).'/'.periodName($request->period, $request->period_unit);
            $plan = $stripe->createPlan($request->period, $request->period_unit, $request->price, $name);

            $price['plan_id'] = $plan->id;
            $price['period'] = $request->period;
            $price['period_unit'] = $request->period_unit;
        }
        if ($request->standard) {
            $item->prices()->whereStandard(1)->update(['standard' => 0]);
        }
        $result = $item->prices()->create($price);

        return $result;
    }

    public function updatePrice($request)
    {
        $item = $this;
        if ($request->standard) {
            $item->prices()
                ->whereStandard(1)
                ->update(['standard' => 0]);
        }

        $itemPrice = $item->prices()
            ->where('id', $request->edit_price)
            ->first();
        $price['slashed_price'] = $request->slashed_price;
        $price['standard'] = $request->standard ? 1 : 0;
        $price['status'] = $request->status ? 1 : 0;

        if ($itemPrice->recurrent == 0) {
            $price['price'] = $request->price;
        }

        $itemPrice->update($price);

        return $item;
    }

    public function deletePlan($stripe_plan_id)
    {
        $stripe = new Stripe();
        $stripe->deletePlan($stripe_plan_id);

        return true;
    }
}
