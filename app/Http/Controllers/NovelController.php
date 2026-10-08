<?php

namespace App\Http\Controllers;

use App\Models\Novel;
use Illuminate\Http\Request;

class NovelController extends Controller
{
    
    public function index() {
        
        $novels = Novel::all(); 
        
        return view('admin.index', compact('novels'));
    }

    
    public function show($id) {
        $novel = Novel::findOrFail($id);

        return view('admin.show', compact('novel'));
    }
}