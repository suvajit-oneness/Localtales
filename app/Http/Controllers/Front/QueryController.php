<?php

namespace App\Http\Controllers\Front;

use App\Contracts\QueryContract;
use App\Http\Controllers\Controller;
use App\Models\QueryCatagory;
use Illuminate\Http\Request;

class QueryController extends Controller
{
    public function __construct(QueryContract $QueryRepository)
    {
        $this->QueryRepository = $QueryRepository;
    }

    public function createQuery()
    {
        $query_catagory_all = QueryCatagory::all();
        return view('site.partials.support.query', compact('query_catagory_all'));
    }

    public function storeQuery(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'query_catagory' => 'nullable|string|max:255',
            'other' => 'nullable|string|max:255',
            'query' => 'required|string|max:255',
            'related_images' => 'nullable|array',
            'related_images.*' => 'image',
        ]);

        $data = $request->except('_token');
        $save = $this->QueryRepository->createQuery($data);

        if ($save != 'error') {
            session()->flash('success', $save);
            return back();
        } else
            return back()->with('error', 'Query submission error!');
    }
}
