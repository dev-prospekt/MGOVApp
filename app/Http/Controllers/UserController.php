<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use App\Models\Shelter\Shelter;
use Yajra\Datatables\Datatables;
use Spatie\Permission\Models\Role;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\UserPostRequest;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::all();

        if($request->ajax()){
            $users = User::whereNotIn('name', ['Super Admin'])
                    ->select('users.*')
                    ->with('shelter')
                    ->get();

            return Datatables::of($users)
                ->addColumn('shelter', function($user){
                    return $user->shelter->name ?? 'Sva oporavilišta';
                })
                ->addColumn('action', function ($user) {
                    return '
                    <div class="d-flex align-items-center">
                        <a href="javascript:void(0)" class="edit btn btn-xs btn-sm btn-primary mr-2" data-id="'.$user->id.'">
                            Uredi
                        </a>

                        <a href="javascript:void(0)" id="bntDeleteUser" class="btn btn-xs btn-sm btn-danger" >
                            <input type="hidden" id="userId" value="'.$user->id.'" />
                            Obriši
                        </a>
                    </div>
                    ';
                })->make(true);
        }

        return view("users.index", [
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     $shelters = Shelter::all();

    //     return view("users.create", [
    //         'shelters' => $shelters
    //     ]);
    // }

    public function create() 
    {
        $shelters = Shelter::all();

        $returnHTML = view('users._create', ['shelters'=> $shelters])->render();
        return response()->json( array('success' => true, 'html' => $returnHTML) );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'role_id' => 'required',
        ], [
            'name.required' => 'Ime je obavezan podatak',
            'email.required' => 'Email je obavezan podatak',
            'email.unique' => 'Email postoji',
            'password.required' => 'Lozinka je obavezan podatak',
            'role_id.required' => 'Rola je obavezan podatak',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->shelter_id = $request->shelter_id;
        $user->roles()->detach();
        $user->save();

        if($request->role_id){
            $user->roles()->attach($request->role_id);
        }

        return response()->json(['success' => 'Uspješno dodano.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit(User $user)
    // {
    //     $shelters = Shelter::all();

    //     return view('users.edit', compact('shelters'))->with('user', $user); 
    // }

    public function edit(User $user) 
    {
        $shelters = Shelter::all();

        $returnHTML = view('users._edit', ['shelters'=> $shelters, 'user' => $user])->render();
        return response()->json( array('success' => true, 'html' => $returnHTML) );
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
        ], [
            'name.required' => 'Ime je obavezan podatak',
            'email.required' => 'Email je obavezan podatak',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->shelter_id = $request->shelter_id;
        $user->roles()->detach();
        $user->save();

        if($request->role){
            $user->assignRole($request->role);
        }

        return response()->json(['success' => 'Uspješno dodano.']);
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

    public function roleMapping()
    {
        // Vraća nam sve korisnike osim Super Admina
        $users = User::with('roles')->whereNotIn('name', ['Super Admin'])->get();
        $roles = Role::with('permissions')->get();

        return view('users.rolemapping', [
            'users' => $users,
            'roles' => $roles,
        ]);
    }

    public function roleMappingAdd(Request $request)
    {
        $user = User::where('email', $request['email'])->first();
        $user->roles()->detach();

        if($request['administrator']){
            $user->roles()->attach(Role::where('name', 'Administrator')->first());
        }
        if($request['user']){
            $user->roles()->attach(Role::where('name', 'Korisnik')->first());
        }
        if($request['shelter']){
            $user->roles()->attach(Role::where('name', 'Oporavilište')->first());
        }

        return redirect("/roleMapping")->with('role', 'Uspješno spremljeno.');
    }

    public function permissionMapping(Request $request)
    {
        $role = Role::find($request->role);
        $role->revokePermissionTo(['create', 'edit', 'delete', 'generate']);

        if($request['create']){
            $role->givePermissionTo('create');
        }
        if($request['edit']){
            $role->givePermissionTo('edit');
        }
        if($request['delete']){
            $role->givePermissionTo('delete');
        }
        if($request['generate']){
            $role->givePermissionTo('generate');
        }

        return redirect()->back()->with('permissions', 'Uspješno spremljeno.');
    }
}
