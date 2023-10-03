<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContentFormRequest;
use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Str;

class AjaxController extends Controller
{
    public function contactSave(ContentFormRequest $request)
    {
        $newData = [
          'name' => Str::title($request->name),
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => $request->status,
            'ip' => request()->ip(),
        ];

        $lastCreated = Contact::create($newData);

        return back()->withSuccess('Message Sent Successfully');
    }
}
