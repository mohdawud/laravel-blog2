<?php

namespace App\Http\Controllers\Front;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomepageController extends Controller
{

    public function index()
    {
        $lastData = $this->lastData();

        $data = Post::where('status', 'publish')->where('id', '!=', $lastData->id)->orderBy('id', 'desc')->paginate(5);
        return view('components.front.home-page', compact('data', 'lastData'));
    }

    private function lastData()
    {
        $data = Post::where('status', 'publish')->orderBy('id', 'desc')->latest()->first();
        return $data;
    }
}
