<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Shelter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ShelterUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('shelterUser.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $shelters = Shelter::all();
        
        return view('shelterUser.create', compact('shelters'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User;
        $user->name = $request->name;
        $user->name_lastname = $request->name_lastname;
        $user->email = $request->email;
        $user->shelter_id = $request->shelter_id;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('users.index')->with('msg', 'Korisnik je uspješno dodan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('shelterUser.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $shelters = Shelter::all();

        return view('shelterUser.edit', compact('shelters'))->with('user', $user);
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
        $user = User::find($id);
        $user->name = $request->name;
        $user->name_lastname = $request->name_lastname;
        $user->email = $request->email;
        $user->shelter_id = $request->shelter_id;
        $user->save();

        return redirect()->route('users.index')->with('msg', 'Korisnik je uspješno ažuriran');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect()->route('users.index')->with('msg', 'Korisnik je uspješno uklonjen');
    }
}
