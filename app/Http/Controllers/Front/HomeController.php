<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Mail\CampaignViewMail;
use App\Models\EmailCampaign;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Validator;

class HomeController extends Controller
{
    public function getSubscribeForm()
    {
        $data = view('components.front.subscribeForm')->render();

        return $this->jsonSuccess($data);
    }

    public function closeSubscribeForm()
    {
        session()->put(['closeNewsletter' => true]);

        return $this->jsonSuccess();
    }

    public function subscribe(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        if ($validation->fails()) {
            return $this->jsonError($validation->errors());
        }

        $subscriber = new Subscriber();
        $status = $subscriber->subscribe($request);

        $data = view('components.front.subscribeSuccess', compact('status'))->render();

        return $this->jsonSuccess($data);
    }

    public function subscribeConfirm($token)
    {
        $subscriber = Subscriber::whereToken($token)->first();
        if ($subscriber == null) {
            return redirect()->route('home')
                ->with('info', 'Session is expired.');
        }
        $subscriber->status = 1;
        $subscriber->save();

        return redirect()->route('home')
            ->with('success', 'Successfully confirmed!');
    }

    public function mail($id)
    {
        $campaign = EmailCampaign::where('status', 'sent')
            ->where('id', hashDecode($id))
            ->firstorfail();

        $data['body'] = $campaign->body;
        $data['subject'] = $campaign->subject;

        return new CampaignViewMail($data);
    }
}
