<?php

namespace App\Http\Controllers;

use App\Exports\PostExport;
use App\Models\Post;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PostController extends Controller
{
    public function index()
    {
        $post = Post::all();
        return view('welcome', compact('post'));
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $post = new Post();
        $post->fill($request->all());
        $post->save();

        return redirect()->route('index');
    }

    public function export()
    {
        return Excel::download(new PostExport, 'post.xlsx');
    }
}
