<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AvailableWeekday;
use Illuminate\Http\Request;
use Validator;

class AdminController extends Controller
{
    public static $viewDir = 'admin.';

    public $sortModel;

    public $model;

    public function getSort()
    {
        try {
            $items = $this->sortModel->orderBy('order')->get(['id', 'name']);
            $view = '';
            foreach ($items as $item) {
                $view .= '<li data-id="'.$item->id.'">'.$item->name.'</li>';
            }

            return response()->json(compact('view'));
        } catch (\Exception $e) {
            echo json_encode($e->getMessage());
        }
    }

    public function updateSort(Request $request)
    {
        try {
            $sorts = $request->get('sorts');
            foreach ($sorts as $key => $sort) {
                $item = $this->model->findorfail($sort);
                $item->order = $key + 1;
                $item->save();
            }

            return response()->json(['status' => 1]);
        } catch (\Exception $e) {
            echo json_encode($e->getMessage());
        }
    }

    public function switch(Request $request)
    {
        try {
            $action = $request->action;

            $items = $this->model->whereIn('id', $request->ids)->get();

            if ($action === 'active') {
                $items->each->update(['status' => 1]);
            } elseif ($action === 'inactive') {
                $items->each->update(['status' => 0]);
            } elseif ($action === 'featured') {
                $items->each->update(['featured' => 1]);
            } elseif ($action === 'unfeatured') {
                $items->each->update(['featured' => 0]);
            } elseif ($action === 'new') {
                $items->each->update(['new' => 1]);
            } elseif ($action === 'undonew') {
                $items->each->update(['new' => 0]);
            } elseif ($action === 'delete') {
                $items->each->delete();
            } elseif ($action === 'approve') {
                $items->each->update(['status' => 'approved']);
            }

            return response()->json(['status' => 1]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }

    public function createPrice(Request $request, $id)
    {
        try {
            $validation = Validator::make($request->all(), $this->model->priceRule($request));
            if ($validation->fails()) {
                return response()->json(['status' => 0, 'data' => $validation->errors()]);
            }

            $item = $this->model->findorfail($id);
            $item->savePrice($request);

            return response()->json([
                'status' => 1,
                'data' => 1,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }

    public function deletePrice(Request $request, $id)
    {
        try {
            $price = $this->model->findorfail($id)
                ->prices()
                ->where('id', $request->id)
                ->firstorfail();
            if ($price->recurrent == 1) {
                $this->model->deletePlan($price->plan_id);
            }
            $price->delete();

            return response()->json([
                'status' => 1,
                'data' => $id,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }

    public function updateMeetingForm(Request $request, $id)
    {
        try {
            $rule = array_merge(
                $this->model->updateFormRule($request),
                $this->model->updateMeetingRule($request)
            );

            $weekday = new AvailableWeekday();
            if ($request->meeting) {
                $weekdayRule = $weekday->storeRule($request);
                $rule = array_merge($rule, $weekdayRule);
                $error = $weekday->checkRule($request);
                if (count($error) != 0) {
                    return response()->json([
                        'status' => 0,
                        'data' => $error,
                    ]);
                }
            }
            $customMsg = array_merge(
                $this->model->getUpdateFormValidatoinCustomMessgae(),
                $this->model->getUpdateMeetingValidationMessage()
            );

            $validation = Validator::make($request->all(), $rule, $customMsg);

            if ($validation->fails()) {
                return response()->json([
                    'status' => 0,
                    'data' => $validation->errors(),
                ]);
            }

            $item = $this->model->find($id);
            $item->updateForm($request)
                ->updateMeeting($request);
            if ($item->step == 1) {
                $item->status = 1;
                $item->step = 2;
                $item->save();
            }
            if ($request->meeting) {
                $req = $request;
            } else {
                $req = null;
            }

            $weekday->storeItem($req, get_class($item), $item->id);

            return $this->jsonSuccess($item);
        } catch (\Exception $e) {
            return $this->jsonExceptionError($e);
        }
    }
}
