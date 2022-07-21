<?php

namespace App\Http\Controllers;

use App\Models\Nuse;
use App\Models\User;
use App\Models\Like;
use Illuminate\Http\Request;

class NuseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        $req->validate([
            'title' => 'required|string|min:3|max:30',
            'body' => 'required|string|min:3',
            'location' => 'required|string',
            'happened_at' => 'required|date_format:Y-m-d'
        ]);

        // dd($req);
        $nuse = auth()->user()->nuse()->create($req->all());

        return response()->json([
            'message' => 'Nuse created successfully',
            'nuse_obj' => $nuse
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Nuse  $nuse
     * @return \Illuminate\Http\Response
     */
    public function show(Request $req, Nuse $nuse)
    {
        $nuseList = $nuse::with('user')->with('likes')->latest()->get();
        return response()->json($nuseList);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Nuse  $nuse
     * @return \Illuminate\Http\Response
     */
    public function showSpecificNuse(Request $req, $id)
    {
        $nuse = Nuse::with('user')->with('likes')->latest()->find($id);
        return response()->json($nuse);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Nuse  $nuse
     * @return \Illuminate\Http\Response
     */
    public function edit(Nuse $nuse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Nuse  $nuse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Nuse $nuse, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Nuse  $nuse
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nuse $nuse, $id)
    {
        return $nuse::find($id)->delete();
    }

    public function like(Request $req, Nuse $nuse, $id)
    {
        $foundNuse = $nuse->find($id);
        return $foundNuse->likes()->create([
            'user_id' => $req->user()->id
        ]);
        // return $nuse::find($id)->delete();
    }

    public function dislike(Request $req, Nuse $nuse, $id)
    {
        $foundNuse = $nuse->find($id);
        return $foundNuse->dislikes()->create([
            'user_id' => $req->user()->id
        ]);
        // return $nuse::find($id)->delete();
    }

    public function unlike(Request $req, Nuse $nuse, $id)
    {
        $foundNuse = $nuse->find($id);
        return $foundNuse->likes()->delete();
    }

    public function testLike(Request $req, Nuse $nuse, $id)
    {
        $foundNuse = $nuse->find($id)->likedByUser($req->user()->id);

        return response($foundNuse);
    }

    public function showNuserNuseList(Request $req, $id)
    {
        $foundNuse = Nuse::where('user_id', $id)->with('user')->latest()->get();
        return response()->json($foundNuse);
    }
}
