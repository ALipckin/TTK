<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Header;
use Illuminate\Http\Request;

class HeaderController extends Controller
{
    public function index(){
        
        $header = Header::all();

        return view('header.index', compact('header'));
    }
    public function create(){
        return view('header.create');
    }
    public function show(Header $ttk)
    {
        return view('header.show', compact('header'));
    }

    public function edit(Header $header)
    {
        return view('header.edit', compact('header'));
    }

    public function update(Header $ttk)
    {
        $data = request()->validate([
            'ash'           =>  'numeric | required',
        ]);

        $ttk->update($data);
        return redirect()->route('header.show', $ttk->id);
    }
    public function destroy(Header $header){
        $header->delete();
        return redirect()->route('header.index');
    }

    public function store()
    {

        $data = request()->validate([
            'ash'           =>  'numeric | required',
        ]);
        
        Header::create($data);
        
        return redirect()->route('header.index');
        
    }
    //
}
