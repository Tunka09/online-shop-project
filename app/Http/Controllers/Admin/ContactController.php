<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\ContactRequest;

class ContactController extends Controller
{
    //

    public function index()
    {
        $contact_requests = ContactRequest::all();
        return view('admin.contact_request.index', compact('contact_requests'));
    }

    public function destroy($id)
    {
        $contact_request = ContactRequest::findOrFail($id);
        $contact_request->delete();

        return redirect('admin/contact')->with('message', 'Contact Request Deleted Successfully!');
    }
}
