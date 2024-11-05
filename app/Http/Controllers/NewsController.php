<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function news()
    {
        $news = News::take(10)->get();
        return view('news', compact('news'));
    }
    public function loadMore(Request $request)
    {
        $skip = $request->get('skip', 0);

        $news = News::skip($skip)->take(10)->get();

        return response()->json([
            'news' => $news
        ]);
    }
    public function newsDetail($id)
    {
        $news = News::find($id);
        return view('news-detail', compact('news'));
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = News::query();

        // Check if there's a search term
        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('content', 'like', '%' . $request->search . '%');
        }

        // Paginate results
        $news = $query->paginate(10);

        return view('admin.news.index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.news.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNewsRequest $request)
    {
        $news = new News();
        $news->title = $request->title;
        $news->content = $request->content;

        if ($request->hasFile('image')) {
            $filename = 'news/' . (string) Str::uuid() . '.' . $request->file('image')->getClientOriginalExtension();
            Storage::disk('public')->put($filename, file_get_contents($request->file('image')));
            $news->image = $filename;
        }

        $news->save();

        return redirect()->route('news.index')->with('success', 'News created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        News::where('id', $news->id)->get();
        return view('admin.news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNewsRequest $request, News $news)
    {
        $news->title = $request->title;
        $news->content = $request->content;

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($news->image);
            $filename = 'news/' . (string) Str::uuid() . '.' . $request->file('image')->getClientOriginalExtension();
            Storage::disk('public')->put($filename, file_get_contents($request->file('image')));
            $news->image = $filename;
        }

        $news->save();

        return redirect()->route('news.index')->with('success', 'News updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        Storage::disk('public')->delete($news->image);
        $news->delete();

        return redirect()->route('news.index')->with('success', 'News deleted successfully.');
    }
}
