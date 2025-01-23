<?php

namespace App\Http\Controllers\Front;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogDetailController extends Controller
{
    public function detail($slug)
    {
        $data = Post::where('status', 'publish')->where('slug', $slug)->firstOrfail();
        $pagination = $this->pagination($data->id);
        return view('components.front.blog-detail', compact('data', 'pagination'));
    }

    private function pagination($id)
    {
        $dataPrev = Post::where('status', 'publish')->where('id', '<', $id)->orderBy('id', 'desc')->first();
        $dataNext = Post::where('status', 'publish')->where('id', '>', $id)->orderBy('id', 'asc')->first();
        $data = [
            'prev' => $dataPrev,
            'next' => $dataNext
        ];
        return $data;
    }
}
