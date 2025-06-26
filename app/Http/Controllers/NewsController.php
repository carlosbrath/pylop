<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $title= 'Notifications';
        $page_title= 'Notifications';
        $news = News::latest()->get();
        if ($request->expectsJson()) {
            return response()->json($news, 200);
        }
        return view('news.list', compact('news'), compact('title'), compact('page_title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title= 'Add Notifications';
        $page_title= 'Add Notifications';
        return view('news.create', compact('title'), compact('page_title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'body' => 'required|string',
                'link' => 'nullable|string|max:255', // If link is optional
            ]);

            News::create([
                'title' => $validatedData['title'],
                'body' => $validatedData['body'],
                'link' => $validatedData['link'] ?? null,
                'created_by' => auth()->user()->id,
            ]);

            if ($request->expectsJson()) {
                return response()->json(['message' => 'News item created successfully!'], 201);
            } else {
                return redirect()->route('news.index')->with('success', 'News item created successfully!');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            } else {
                return redirect()->back()
                    ->withErrors($e->errors())
                    ->withInput();
            }
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'An error occurred: ' . $e->getMessage()], 500);
            } else {
                return redirect()->back()
                    ->with('error', 'An error occurred: ' . $e->getMessage())
                    ->withInput();
            }
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show(News $news)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit(News $news)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, News $news)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news)
    {
        //
    }
}
