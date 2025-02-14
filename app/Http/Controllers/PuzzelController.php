<?php

namespace App\Http\Controllers;

use App\Models\Puzzel;
use App\Models\Allepuzzels;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
// use Auth;
use Illuminate\Support\Facades\Auth;
use PSpell\Config;

class PuzzelController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sortBy = 'title';
        $orderBy = 'desc';
        $perPage = 20;
        $q = null;
        $aantal = 0;
        $aantalReturn = 0;
        $gelegd = null;
        $eigen = null;
        $sign = '=';
        if ($request->has('orderBy')) $orderBy = $request->query('orderBy');
        if ($request->has('sortBy')) $sortBy = $request->query('sortBy');
        if ($request->has('perPage')) $perPage = $request->query('perPage');
        if ($request->has('q')) $q = $request->query('q');
        if ($request->has('aantal')) $aantal = $request->query('aantal');
        if ($request->has('aantal')) $aantalReturn = $request->query('aantal');
        if ($request->has('gelegd')) $gelegd = $request->query('gelegd');
        if ($request->has('eigen')) $eigen = $request->query('eigen');
        if (str_contains($aantal, '<')) {
            $aantal = str_replace('<', "", $aantal);
            $sign = '<';
        } elseif (str_contains($aantal, '>')) {
            $aantal = str_replace(['>', '='], "", $aantal);
            $sign = '>=';
        }
        $aantal = (int)$aantal;
        if ($aantal == 0) {
            $sign = '>';
        }
        $puzzels = Puzzel::where('title', 'LIKE', $q)->where('stukjes', $sign, $aantal)->where('gelegd', 'LIKE', $gelegd)->where('own', 'LIKE', $eigen)->orderBy($sortBy, $orderBy)->paginate($perPage)->where('userid', Auth::id());


        return view('puzzels.index', compact('puzzels', 'orderBy', 'sortBy', 'q', 'perPage', 'aantalReturn', 'gelegd', 'eigen'));
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

        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path() . '/images/', $filename);
            $puzzel->image = $filename;
        }
        if ($request->newurl) {
            $contents = file_get_contents($request->newurl);
            $name = date('YmdHi') . substr($request->newurl, strrpos($request->newurl, '/') + 1);
            Storage::disk('public_uploads')->put($name, $contents);
            $puzzel->image = $name;
        }
        $puzzel->title = $request->newname;
        $puzzel->stukjes = $request->stukjes;
        $puzzel->nummer = $request->nummer;
        $puzzel->own = $request->eigen;
        $puzzel->gelegd = $request->gelegd;
        $puzzel->note = $request->note;
        $puzzel->userid = $request->user()->id;

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
        $stukjes = $puzzel->getAttribute('stukjes');

        // $allePuzzels = Allepuzzels::query()
        //     ->where('NaamNederlands', 'LIKE', "%{$title}%")->orWhere('NaamEngels', 'LIKE', "%{$title}%")
        //     ->get()->sortByDesc('Jaar', SORT_NUMERIC);
        // $allePuzzels = AllePuzzels::all()->sortByDesc('Jaar');
        $allePuzzels = Allepuzzels::query()
            ->where('Aant', "{$stukjes}")
            ->get()->sortByDesc('Jaar ', SORT_NUMERIC);
        // dd($allePuzzels);

        return view('puzzels.edit', compact(['puzzel', 'allePuzzels ']));
    }

    public function editallepuzzels($id)
    {
        // $title = $AllePuzzels->getAttribute('title ');
        // dd($id);
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
        $puzzel->note = $request->note;
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

    public function addFromAllepuzzels(Request $request)
    {
        // dd($request);
        // dd($request->puzzelimage);
        // dd($user);

        $puzzel = new Puzzel;

        if (isset($request->puzzelimage)) {
            // $file = $request->file('image');
            // $filename = date('YmdHi') . $file->getClientOriginalName();
            // $file->move(public_path() . '/images/', $filename);
            $puzzel->image = $request->puzzelimage;
        }
        // if ($request->newurl) {
        //     $contents = file_get_contents($request->newurl);
        //     $name = date('YmdHi') . substr($request->newurl, strrpos($request->newurl, '/') + 1);
        //     Storage::disk('public_uploads')->put($name, $contents);
        //     $puzzel->image = $name;
        // }
        $puzzel->title = $request->name;
        $puzzel->stukjes = $request->aantal;
        $puzzel->nummer = $request->nummer;
        $puzzel->userid = $request->user()->id;
        // $puzzel->image = $imageName;
        $puzzel->save();

        return redirect()->route('puzzels.index')
            ->with('success', 'Product created successfully.');
    }
}
