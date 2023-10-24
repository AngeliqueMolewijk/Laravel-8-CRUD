<?php

namespace App\Http\Controllers;

use App\Models\Puzzel;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class PuzzelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $puzzels = Puzzel::all()->sortByDesc('updated_at');

        return view('puzzels.index', compact('puzzels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('puzzels.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $puzzel = new Puzzel;
        // dd($request->file('image')->getClientOriginalExtension());
        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $img = Image::make($file->path());
            $img->resize(500, 500, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('/images') . '/' . $filename);
            // $filesave = ResizeImage::make($request->file('image'))
            // ->resize(100, 100)->save();
            // $filesave->move(public_path('images'), $filename);
            $puzzel->image = $filename;
        }
        $puzzel->title = $request->title;
        $puzzel->stukjes = $request->stukjes;
        $puzzel->own = $request->eigen;
        $puzzel->gelegd = $request->gelegd;
        // $puzzel->image = $imageName;
        $puzzel->save();

        return redirect()->route('puzzels.index')
        ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $puzzel = Puzzel::find($id);

        return view('puzzels.show')->with("puzzel", $puzzel);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Puzzel $puzzel)
    {
        return view('puzzels.edit', compact('puzzel'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $puzzel = Puzzel::find($id);
        // dd($request->image);
        // dd($request->hasFile('image'));
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $puzzel->image = $filename;
        }
        $puzzel->title = $request->title;
        $puzzel->stukjes = $request->stukjes;
        $puzzel->own = $request->eigen;
        $puzzel->gelegd = $request->gelegd;
        $puzzel->save();

        return redirect()->route('puzzels.index')
        ->with('success', 'Puzzel updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Puzzel $puzzel)
    {
        $puzzel->delete();

        return redirect()->route('puzzels.index')
        ->with('success', 'Puzzel deleted successfully');
    }
}
