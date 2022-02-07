<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\User;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function index($id)
    {
        return Link::where('user_id', $id)->get();
    }
}
