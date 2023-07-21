<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContentFormRequest;
use Illuminate\Http\Request;
use App\Models\Contact;

class AjaxController extends Controller
{
    public function contactSave(ContentFormRequest $request)
    {
        $data = $request->all();
        $data['ip'] = request()->ip();

        $lastCreated = Contact::create($data);

        return back()->withSuccess('Message Sent Successfully');
    }
}
