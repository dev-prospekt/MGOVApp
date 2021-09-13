<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use App\Models\Shelter\Shelter;
use Yajra\Datatables\Datatables;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\UserPostRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $usersTrashed = User::onlyTrashed()->get();

        return view("users.index", [
            'users' => $users,
            'usersTrashed' => $usersTrashed
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $shelters = Shelter::all();

        return view("users.create", [
            'shelters' => $shelters
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserPostRequest $request)
    {
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->email);
        $user->shelter_id = $request->shelter_id;
        $user->save();

        return redirect()->route("user.index")->with('msg', 'Uspješno dodano.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

        return view('users.edit', compact('shelters'))->with('user', $user); 
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
        $user->email = $request->email;
        $user->shelter_id = $request->shelter_id;
        $user->save();

        return redirect()->route("user.index")->with('msg', 'Uspješno ažurirano.');
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

        return response()->json(['msg'=>'success']);
        //return redirect()->route("user.index")->with('msg', 'Uspješno obrisano.');
    }

    public function restore($user_id)
    {
        User::withTrashed()->find($user_id)->restore();

        return redirect()->route("user.index");
    }

    public function indexDataTables()
    {
        $users = User::where('name', '!=', 'Admin User')
                ->select('users.*')
                ->with('shelter')
                ->get();

        return Datatables::of($users)
            ->addColumn('shelter', function($user){
                return $user->shelter->name;
            })
            ->addColumn('action', function ($user) {
                return '
                <div class="d-flex align-items-center">
                    <a href="user/'.$user->id.'/edit" class="btn btn-xs btn-primary mr-2">
                        <i class="mdi mdi-tooltip-edit"></i> 
                        Edit
                    </a>

                    <a href="javascript:void(0)" id="bntDeleteUser" class="btn btn-xs btn-danger" >
                        <i class="mdi mdi-delete"></i>
                        <input type="hidden" id="userId" value="'.$user->id.'" />
                        Delete
                    </a>
                </div>
                ';
            })->make(true);
    }
}
