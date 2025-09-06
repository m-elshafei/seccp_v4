<?php

namespace App\Http\Controllers;

use Flash;
use Response;
use App\Models\User;
use App\Http\Requests;
use App\Models\Branch;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Overrides\Spatie\Role;
use App\Utils\PermissionsUtil;
use App\DataTables\UserDataTable;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Validation\Rules\Password;
use App\Http\Controllers\AppBaseController;

class UserController extends AppBaseController
{

        public $gClient;

    /**
     * Display a listing of the User.
     *
     * @param UserDataTable $userDataTable
     * @return Response
     */
    public function index(UserDataTable $userDataTable)
    {
        return $userDataTable->render('users.index');
    }

    /**
     * Show the form for creating a new User.
     *
     * @return Response
     */
    public function create()
    {
        $branches = Branch::pluck('name', 'id')->prepend("اختر","");
        return view('users.create',compact('branches'));
    }

    /**
     * Store a newly created User in storage.
     *
     * @param CreateUserRequest $request
     *
     * @return Response
     */
    public function store(CreateUserRequest $request)
    {
        $input = $request->all();
        // $pass =Str::random(12);
        // $pass =$input['username']."@Alfaseel";
        // /** @var User $user */
        $input['password']=  Hash::make($request->password);
        if (!$request->branch_id){
            $input['branch_id']=  1;
        }
        $input['pass_need_to_be_changed']=  1;
        $user = User::create($input);

        Flash::success(__('messages.saved', ['model' => __('models/users.singular')]));

        return redirect(route('users.index'));
    }

    /**
     * Display the specified User.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var User $user */
        $user = User::find($id);

        if (empty($user)) {
            Flash::error(__('models/users.singular').' '.__('messages.not_found'));

            return redirect(route('users.index'));
        }

        return view('users.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified User.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var User $user */
        $user = User::find($id);
        $branches = Branch::pluck('name', 'id')->prepend("اختر","");

        if (empty($user)) {
            Flash::error(__('messages.not_found', ['model' => __('models/users.singular')]));

            return redirect(route('users.index'));
        }

        $roles_list  = Role::pluck('ar_name' , 'id');

        $userRoles = $user->roles()
                            ->select('id', 'ar_name')
                            ->get();

        return view('users.edit',compact('user','roles_list' , 'userRoles','branches'));
    }

    /**
     * Update the specified User in storage.
     *
     * @param  int              $id
     * @param UpdateUserRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserRequest $request)
    {
        $this->validate($request,[
            'username' => 'required|unique:users,username,'. $id,
            'email' => 'required|email|unique:users,email,'. $id
         ]);

        /** @var User $user */
        $user = User::find($id);

        if (empty($user)) {
            Flash::error(__('messages.not_found', ['model' => __('models/users.singular')]));

            return redirect(route('users.index'));
        }
        $input = $request->all();

        $input['password']=  Hash::make($request->password);
        $user->fill($input);
        $user->save();

        $user->syncRoles($request->input('roles'));
        PermissionsUtil::clearPermissionCash();

        Flash::success(__('messages.updated', ['model' => __('models/users.singular')]));

        return redirect(route('users.index'));
    }

    /**
     * Remove the specified User from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var User $user */
        $user = User::find($id);

        if (empty($user)) {
            Flash::error(__('messages.not_found', ['model' => __('models/users.singular')]));

            return redirect(route('users.index'));
        }

        $user->delete();

        Flash::success(__('messages.deleted', ['model' => __('models/users.singular')]));

        return redirect(route('users.index'));
    }

    public function changePassword()
    {
        return view('users.change-password');
    }

    public function updatePassword(Request $request)
    {
        # Validation
        $request->validate([
            'old_password' => 'required',
            // 'new_password' => 'required|confirmed',
            'new_password' => [
                'required',
                'confirmed',
                Password::min(8)
                  ->mixedCase()
            ],
            // 'new_password_confirmation' => 'required|same:new_password'
        ]);


        #Match The Old Password
        if(!Hash::check($request->old_password, auth()->user()->password)){
            return back()->with("error", __("Old Password Doesn't match!"));
        }


        #Update the new Password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password),
            'pass_need_to_be_changed'=>0
        ]);

        return back()->with("status", __("Password changed successfully!"));
    }
}
