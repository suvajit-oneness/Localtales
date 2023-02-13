<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Auth;
use Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BlogExport;
use DB;
use Illuminate\Support\Facades\Session as FacadesSession;
use App\Models\ArticleFeature;
class BlogFeatureController extends Controller
{
 /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
       // dd($request->all());
        $request->validate([
            'heading' => 'required|string|min:1',
            'content' => 'required|string|min:1',
        ]);

        $widget = new ArticleFeature();
        $widget->heading = $request->heading;
        $widget->content = $request->content;
        $widget->highlights = $request->highlights;
        $widget->features = $request->features;
        $widget->blog_id = $request->blog_id;
        $widget->btn_text = $request->btn_text;
        $widget->btn_link = $request->btn_link;

     //   $widget->image = $request->image;
        $widget->save();

        if (!$widget) {
            return redirect()->back()->with('Error occurred while creating Article Feature.', 'error', true, true);
        }
        return redirect()->back()->with('admin.blog.index', 'Article Feature has been created successfully', 'success', false, false);
    }

    public function update(Request $request,$id)
    {
       // dd($request->all());
        $request->validate([
            'heading' => 'required|string|min:1',
            'content' => 'required|string|min:1',
        ]);

        $widget = ArticleFeature ::findOrFail($id);
        $widget->heading = $request->heading;
        $widget->content = $request->content;
        $widget->highlights = $request->highlights;
        $widget->features = $request->features;
        $widget->blog_id = $request->blog_id;
        $widget->btn_text = $request->btn_text;
        $widget->btn_link = $request->btn_link;
        // $file=$request->file('image');
        //  $text= $file->getClientoriginalExtension();
        //  $fileName= time().'.'.$text;
        //  $file->move('Blogs/',$fileName);
        //  $widget->image = $fileName;
        $widget->save();

        if (!$widget) {
            return redirect()->back()->with('Error occurred while creating Article Feature.', 'error', true, true);
        }
        return redirect()->back()->with('admin.blog.index', 'Article Feature has been created successfully', 'success', false, false);
    }

    public function delete($id)
    {
        $widget = ArticleFeature::findOrFail($id);
        $widget->delete();
        if (!$widget) {
            return redirect()->back()->with('Error occurred while deleting Article Feature.', 'error', true, true);
        }
        return redirect()->back()->with('admin.blog.index', 'Article Feature has been deleted successfully', 'success', false, false);
    }
}
