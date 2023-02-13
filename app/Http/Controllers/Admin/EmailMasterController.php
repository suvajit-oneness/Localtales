<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MailTemplate;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Str;
use Session;
use Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session as FacadesSession;

class EmailMasterController extends BaseController
{
    public function index(Request $request)
    {
        $this->setPageTitle('Email', 'Email Template');

        if (!empty($request->term)) {
            $email = MailTemplate::where('type', 'like', '%'.$request->term.'%')->latest('id')->paginate(25);
        } else {
            $email = MailTemplate::latest('id')->paginate(25);
        }

        return view('admin.email-template.index', compact('email'));
    }

    public function create()
    {
        $this->setPageTitle('Category', 'Create category');
        return view('admin.email-template.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $this->validate($request, [
            'subject' => 'required|string|min:1|max:255',
            'type' => 'required',
        ]);

        $category = new MailTemplate;
        $category->type = 1;
        $category->parent_category = !empty($request->title) ? $request->title : '';
        // image
        if (!empty($request->image)) {
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = mt_rand().'_'.time().".".$ext;
            $image->move("categories/",$imageName);
            $category->parent_category_image = $imageName;
        }

        $category->description = !empty($request->description) ? $request->description : '';
        $category->short_content = !empty($request->short_content) ? $request->short_content : '';
        $category->medium_content = !empty($request->medium_content) ? $request->medium_content : '';
        $category->long_content = !empty($request->long_content) ? $request->long_content : '';
        $category->parent_category_email_template = !empty($request->parent_category_email_template) ? $request->parent_category_email_template : '';
        $category->meta_title = !empty($request->meta_title) ? $request->meta_title : '';
        $category->meta_description = !empty($request->meta_description) ? $request->meta_description : '';
        $category->save();

        return $this->responseRedirect('admin.dircategory.index', 'Primary Category created successfully', 'success', false, false);

        
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        // $targetCategory = $this->DirectoryCategoryRepository->finddirectoryCategoryById($id);
        $email = MailTemplate::findOrFail($id);
        $this->setPageTitle('Email Template', 'Edit Email Template : ' . ucwords($email->type));
        return view('admin.email-template.edit', compact('email'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        //dd($request->all());
        $this->validate($request, [
             'subject' => 'required',
             'type' => 'required',
        ]);
        $email = MailTemplate::findOrFail($request->id);
        $email->type = !empty($request->type) ? $request->type : '';
        $email->subject = !empty($request->subject) ? $request->subject : '';
        $email->is_image = !empty($request->is_image) ? $request->is_image : '';
        if($request->is_image == 1){
        // image
            if (!empty($request->body)) {
                $image = $request->body;
                $ext = $image->getClientOriginalExtension();
                $imageName = mt_rand().'_'.time().".".$ext;
                $image->move("email/",$imageName);
                $email->body = $imageName;
            }
        }
        else{    
        $email->body = !empty($request->body) ? $request->body : '';
        }
        //dd($email);
        $email->save();
        
        return $this->responseRedirect('admin.email.master.index', 'Template edited successfully', 'success', false, false);
    }
    public function details($id)
    {
        $email = MailTemplate::findOrFail($id);
        $this->setPageTitle('Email Template Details: ' . ucwords($email->type), 'Email Template Details : ' . ucwords($email->type));

        return view('admin.email-template.details', compact('email'));
    }
}
