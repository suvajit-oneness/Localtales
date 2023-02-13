<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\ContactForm;
class ContactController extends BaseController
{
  public function index(Request $request){
    $contact=ContactForm::latest('id')->paginate(25);
    $this->setPageTitle('Contact Form', 'Contact Form');
    return view('admin.contactform.index', compact('contact'));
  }

  public function detail(Request $request,$id){
    $target=ContactForm::where('id',$id)->get();
    $contact = $target[0];
    $this->setPageTitle('Contact Form', 'Contact Form');
    return view('admin.contactform.details', compact('contact'));
  }
}
