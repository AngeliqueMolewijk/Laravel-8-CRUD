<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Http;
use Auth;

class GoogleController extends Controller
{
    function readjson()
    {
        $json = \File::get('vanhaasterenresult.json');
        $data = json_decode($json);
        return view('puzzels.create')->with("image", $data->items[0]);
    }
    function postsearch(Request $request)
    {
        $json = \File::get('vanhaasterenresult.json');
        $data = json_decode($json);
        return view('puzzels.create')->with("images", $data->items);
    }

    function getJsonSearch(Request $request)
    {
        $searchname = $request->titlesearch;
        $searchUrl = "https://www.googleapis.com/customsearch/v1?key=";
        $apiKey = getenv('GOOGLE_KEY');
        $cx_key = getenv("CX_KEY");

        $searchName = "van haasteren " . $searchname;
        $urlimits = "&searchType=image&num=3";
        $totalUrl = $searchUrl . $apiKey . "&cx=" . $cx_key . "&q=" . $searchName . $urlimits;

        $puzzelimagesgoogle   = Http::get($totalUrl);
        $result = json_decode($puzzelimagesgoogle);


        return view('puzzels.create')->with("images", $result->items);
    }
    function showresults($data)
    {
        $resultGoogle = $data;
        dd($resultGoogle);
    }
}
