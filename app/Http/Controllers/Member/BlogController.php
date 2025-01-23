<?php

namespace App\Http\Controllers\Member;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\Mime\MimeTypes;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $user = Auth::user();
        $search = $request->search;
        $data = Post::where('user_id', $user->id)->where(function ($query) use ($search) {
            if ($search) {
                $query->where('title', 'like', "%{$search}%")->orWhere('content', 'like', "%{$search}%");
            }
        })->orderby('id', 'desc')->paginate(7)->withQueryString();
        return view('member.blogs.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('member.blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'thumbnail' => 'image|mimes:jpeg,jpg,png|max:1240',
        ], [
            'title.required' => 'Judul wajib diisi',
            'content.required' => 'Konten wajib diisi',
            'thumbnail.image' => 'Hanya menerima file gambar',
            'thumbnail.mimes' => 'Format gambar harus jpeg, jpg, png',
            'thumbnail.max' => 'Ukuran gambar tidak boleh lebih dari 10MB',
        ]);

        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $thumbnailName = time() . "_" . $thumbnail->getClientOriginalName();
            $destinationPath = public_path(getenv("CUSTOM_THUMBNAIL_LOCATION"));
            $thumbnail->move($destinationPath, $thumbnailName);
        }
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'status' => $request->status,
            'thumbnail' => isset($thumbnailName) ? $thumbnailName : null,
            'slug' => $this->generateSlug($request->title),
            'user_id' => Auth::user()->id
        ];

        Post::create($data);
        return redirect()->route('member.blogs.index')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        Gate::authorize('edit', $post);
        $data = $post;
        return view('member.blogs.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'thumbnail' => 'image|mimes:jpeg,jpg,png|max:1240',
        ], [
            'title.required' => 'Judul wajib diisi',
            'content.required' => 'Konten wajib diisi',
            'thumbnail.image' => 'Hanya menerima file gambar',
            'thumbnail.mimes' => 'Format gambar harus jpeg, jpg, png',
            'thumbnail.max' => 'Ukuran gambar tidak boleh lebih dari 10MB',
        ]);

        if ($request->hasFile('thumbnail')) {
            if (isset($post->thumbnail) && file_exists(public_path(getenv("CUSTOM_THUMBNAIL_LOCATION") . "/" . $post->thumbnail))) {
                unlink(public_path(getenv("CUSTOM_THUMBNAIL_LOCATION") . "/" . $post->thumbnail));
            }
            $thumbnail = $request->file('thumbnail');
            $thumbnailName = time() . "_" . $thumbnail->getClientOriginalName();
            $destinationPath = public_path(getenv("CUSTOM_THUMBNAIL_LOCATION"));
            $thumbnail->move($destinationPath, $thumbnailName);
        }
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'status' => $request->status,
            'thumbnail' => isset($thumbnailName) ? $thumbnailName : $post->thumbnail,
            'slug' => $this->generateSlug($request->title, $post->id),
        ];

        Post::where('id', $post->id)->update($data);
        return redirect()->route('member.blogs.index')->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Gate::authorize('delete', $post);
        if (isset($post->thumbnail) && file_exists(public_path(getenv("CUSTOM_THUMBNAIL_LOCATION") . "/" . $post->thumbnail))) {
            unlink(public_path(getenv("CUSTOM_THUMBNAIL_LOCATION") . "/" . $post->thumbnail));
        }
        Post::where('id', $post->id)->delete();
        return redirect()->route('member.blogs.index')->with('success', 'Data berhasil dihapus');
    }

    private function generateSlug($title, $id = null)
    {
        $slug = Str::slug($title);
        $count = Post::where('slug', $slug)->when($id, function ($query, $id) {
            return $query->where('id', '!=', $id);
        })->count();

        if ($count > 0) {
            return $slug . '-' . $count;
        }

        return $slug;
    }
}
