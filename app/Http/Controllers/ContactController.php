<?php
namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact-us.contactus');
    }

      public function providerIndex()
    {
        return view('providers.contactus');
    }
    public function store(Request $request)
    {
        try{
            $request->validate([
                'name'    => 'required',
                'email'   => 'required|email',
                'phone'   => 'required',
                'subject' => 'required',
                'body' => 'required',
            ]);
            
            Contact::create($request->all());
            return redirect()->back()
                ->with(['success' => 'Thank you for contact us. we will contact you shortly.']);
        }catch(Exception $e){
            return redirect()->back()
                ->with(['error' => $e->getMessage()]);
        }
    }


  
}
