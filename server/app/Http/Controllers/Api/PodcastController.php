<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PodcastController extends Controller
{
    public function store(Request $request)
    {
        ProcessPodcast::dispatch($podcast);
    }
}
