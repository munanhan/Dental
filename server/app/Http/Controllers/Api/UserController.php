<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use APP\User;

class UserController extends Controller
{
    public function getDetails()
    {
        $user=Auth::user();
        return $user;
    }

    public function test()
    {
        return ['this is a word'];
    }

    /***
     *  Create a new record
     * @param Request $request
     */
    public function store(Request $request)
    {
        // Validate the request...

        $user = new User;

        $user->name = $request->name;

        $user->save();
    }

    /***
     * Update a record
     * @param Request $request
     */
    public function update(Request $request)
    {
        $user = User::find(1);

        $user->name = $request->name;

        $user->save();
    }

    /***
     * Conditional update
     * @param Request $request
     */
    public function updateWhere(Request $request)
    {
        User::where('status',1)
            ->where('phone','13451728874')
            ->update(['name'=>'han']);
    }
}
