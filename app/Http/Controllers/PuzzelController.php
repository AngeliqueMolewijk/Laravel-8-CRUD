<?php

namespace App\Http\Controllers;

use App\Models\Puzzel;
use App\Models\Allepuzzels;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Auth;
class PuzzelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $puzzels = Puzzel::all()->sortByDesc('created_at');

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
        // dd($request);
        $puzzel = new Puzzel;
        
        // dd($request->file('image')->getClientOriginalExtension());
        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path() . '/images/', $filename);


            // $img = Image::make($request->file('image')->getRealPath());
            // $img->resize(500, 500, function ($constraint) {
            //     $constraint->aspectRatio();
            // })->save(storage_path('app/public/' . '/' . $filename));
            // $filesave = ResizeImage::make($request->file('image'))
            // ->resize(100, 100)->save();
            // $filesave->move(public_path('images'), $filename);
            $puzzel->image = $filename;
        }
        if ($request->newurl) {
            $contents = file_get_contents($request->newurl);
            $name = date('YmdHi') . substr($request->newurl, strrpos($request->newurl, '/') + 1);
            Storage::disk('public_uploads')->put($name, $contents);
            // dd($contents);
            // $filename = date('YmdHi') . ".jpg";
            // // $filename = date('YmdHi') . $file->getClientOriginalName();
            // $contents->move(public_path('images'));
            // $img = Image::make($contents);
            // $img->resize(500, 500, function ($constraint) {
            //     $constraint->aspectRatio();
            // })->save(storage_path('app/public/' . '/' . $filename));
            $puzzel->image = $name;
        }
        $puzzel->title = $request->newname;
        $puzzel->stukjes = $request->stukjes;
        $puzzel->nummer = $request->nummer;
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
        $title = $puzzel->getAttribute('title');
        $allePuzzels = Allepuzzels::query()
            ->where('NaamNederlands', 'LIKE', "%{$title}%")->orWhere('NaamEngels', 'LIKE', "%{$title}%")
            ->get()->sortByDesc('Jaar', SORT_NUMERIC);
        // $allePuzzels = AllePuzzels::all()->sortByDesc('Jaar');
        return view('puzzels.edit', compact(['puzzel', 'allePuzzels']));

    }
    public function editallepuzzels($id)
    {
        // $title = $AllePuzzels->getAttribute('title');

        $allePuzzels = Allepuzzels::find($id);
        return view('puzzels.editallepuzzel', with(['puzzel' => $allePuzzels]));
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
        $puzzel->nummer = $request->nummer;
        $puzzel->own = $request->eigen;
        $puzzel->gelegd = $request->gelegd;
        $puzzel->save();

        return redirect()->route('puzzels.index')
        ->with('success', 'Puzzel updated successfully');
    }
    public function updateallepuzzels(Request $request)
    {
        // dd(
        //     $request
        // );
        $allePuzzel = Allepuzzels::find($request->id);
        // dd($allePuzzel);
        // dd($request->image);
        // dd($request->hasFile('image'));
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            // dd($filename);

            $allePuzzel->image = $filename;
        }
        $allePuzzel->save();

        return redirect()->route('allepuzzels')
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
    public function search(Request $request)
    {
        // Get the search value from the request
        $search = $request->input('search');

        // Search in the title and body columns from the posts table
        $puzzel = Puzzel::query()
            ->where('title', 'LIKE', "%{$search}%")
            ->get();

        // Return the search view with the resluts compacted
        return view('puzzels.index')->with("puzzels", $puzzel);
    }
    public function allePuzzels()
    {
        $allePuzzels = Allepuzzels::all()->sortByDesc('Jaar');

        return view('puzzels.puzzellijst', compact('allePuzzels'));
    }
    public function searchallepuzzels(Request $request)
    {
        // dd($request->input('aantal'));
        $searchname = $request->input('searchnaam');
        // dd($searchname);
        $aantal = $request->input('aantal');
        $allePuzzels = Allepuzzels::where(function ($query) use ($aantal) {
            if ($aantal == "<500") {
                $query->where('Aant', '<', 500);
            } elseif ($aantal == ">2000") {
                $query->where('Aant', '>', 2000);
            } elseif (isset($aantal)) {
                $query->where('Aant', '=', "{$aantal}");
            };
        })->where(function ($query) use ($searchname) {
            $query->where('NaamNederlands', 'LIKE', "%{$searchname}%")
            ->orWhere('NaamEngels', 'LIKE', "%{$searchname}%");
        })->get()->sortByDesc('Jaar', SORT_NUMERIC);

        // $allePuzzels = AllePuzzels::query()
        //     ->where('Aant', 'LIKE', "%{$aantal}%")
        //     ->where('NaamNederlands', 'LIKE', "%{$searchname}%")
        //     ->orWhere('NaamEngels', 'LIKE', "%{$searchname}%")
        //     ->get()->sortByDesc('Jaar', SORT_NUMERIC);
        return view('puzzels.puzzellijst', compact('allePuzzels'));
    }
    // public function addimage($puzzelid, $puzzelimage)
    // {
    //     dd($puzzelid);
    //     $puzzeladdimage = AllePuzzels::find($puzzelid);
    //     // dd($puzzeladdimage);
    //     $puzzeladdimage->image = $puzzelimage;
    //     $puzzeladdimage->save();

    // }
    public function addimage(Request $request)
    {
        // dd($request->id);
        $puzzeladdimage = Allepuzzels::find($request->id);
        // dd($puzzeladdimage);
        $puzzeladdimage->image = $request->image;
        $puzzeladdimage->save();
        return redirect('puzzels/' . $request->originalid . '/edit');
        
    }
}
