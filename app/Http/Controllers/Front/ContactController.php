<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use App\Models\Module\Website\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use Mail;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        try {
            $data = [
                'first_name' => $request->data['firstName'] ?? '',
                'last_name' => $request->data['lastName'] ?? '',
                'email' => $request->data['email'] ?? '',
                'subject' => $request->data['subject'] ?? '',
                'phone' => $request->data['phone'] ?? '',
                'date' => $request->data['date'] ?? '',
                'address' => $request->data['address'] ?? '',
                'message' => $request->data['message'] ?? '',
            ];
            $email = $request->email;
            if (empty($email)) {
                $admin = User::where('is_owner', 1)->first();
                $email = $admin->email;
            }

            Mail::to($email)->send(new ContactMail($data));

            $data['web_id'] = tenant()->id;

            Contact::create($data);

            return $this->jsonSuccess(['success', 'Mail sent successfully..!']);
        } catch (\Exception $e) {
            info($e->getMessage());

            return $this->jsonError(['error' => $e->getMessage()]);
        }
    }
}
