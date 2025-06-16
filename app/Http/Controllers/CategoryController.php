<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $category = category::all();
        return view('seller.category.index' , compact('category'));

    }

    public function create(){
        return view('seller.category.create');
    }

    public function show($id){
        $category = category::find($id);
        return view('seller.category.show', compact('category'));
    }

    public function edit($id){
        $category = category::find($id);
        return view('seller.category.edit', compact('category'));
    }

    public function store(Request $request){
        category::create($request->validate([
            'name' => 'required',
        ]));

        return redirect()->route('category.index')->with('success', 'Product created!');
    }

    public function update(Request $request, category $category)
    {
        $category->update($request->validate([
            'name' => 'required'
        ]));

        return redirect()->route('category.index');
    }


    public function destroy(category $category)
    {
        //
    }
}
