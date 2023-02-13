<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Auth;
use Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BlogExport;
use DB;
use Illuminate\Support\Facades\Session as FacadesSession;
use Illuminate\Http\Request;
use App\Models\ArticleWidget;
class BlogWidgetController extends Controller
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
            'widget_heading' => 'required|string|min:1',
            'widget_content' => 'required|string|min:1',
        ]);

        $widget = new ArticleWidget();
        $widget->widget_heading = $request->widget_heading;
        $widget->widget_content = $request->widget_content;
        $widget->blog_id = $request->blog_id;
        $widget->widget_btn_text = $request->widget_btn_text;
        $widget->widget_btn_link = $request->widget_btn_link;
        $widget->save();

        if (!$widget) {
            return redirect()->back()->with('Error occurred while creating Article Widget.', 'error', true, true);
        }
        return redirect()->back()->with('admin.blog.index', 'Article Widget has been created successfully', 'success', false, false);
    }

    public function update(Request $request,$id)
    {
       // dd($request->all());
        $request->validate([
            'widget_heading' => 'required|string|min:1',
            'widget_content' => 'required|string|min:1',
        ]);

        $widget = ArticleWidget ::findOrFail($id);
        $widget->widget_heading = $request->widget_heading;
        $widget->widget_content = $request->widget_content;
        $widget->blog_id = $request->blog_id;
        $widget->widget_btn_text = $request->widget_btn_text;
        $widget->widget_btn_link = $request->widget_btn_link;
        $widget->save();

        if (!$widget) {
            return redirect()->back()->with('Error occurred while creating Article Widget.', 'error', true, true);
        }
        return redirect()->back()->with('admin.blog.index', 'Article Widget has been created successfully', 'success', false, false);
    }

    public function delete($id)
    {
        $widget = ArticleWidget::findOrFail($id);
        $widget->delete();
        if (!$widget) {
            return redirect()->back()->with('Error occurred while deleting Article Widget.', 'error', true, true);
        }
        return redirect()->back()->with('admin.blog.index', 'Article Widget has been deleted successfully', 'success', false, false);
    }
}
