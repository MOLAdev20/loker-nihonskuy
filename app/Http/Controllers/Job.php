<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Job extends Controller
{
    public function index()
    {
        return view('admin.job');
    }

    public function store(Request $req)
    {
        return response()->json([
            "status" => "success",
            "data-post" => $req->post()
        ]);
    }
}
