<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Support\Facades\Validator;
use Gate;

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{

    /**
     * @var UserService
     */
    protected $user;

    /**
     * UserController constructor.
     * @param UserService $user
     */
    public function __construct(UserService $user)
    {
        $this->middleware('auth');
        $this->middleware('admin', ['only' => ['index', 'edit', 'update']]);
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $users = $this->user->getSponsors();

        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     * @internal param User $user
     */
    public function edit($id)
    {
        $user = $this->user->find($id);

        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest|Request $request
     * @param  \App\User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, User $user)
    {
        if (!$this->user->update($user, $request->all())) {
            return redirect()->back()->withErrors('There was a problem in updating user');
        }

        return redirect()->route('user.index')->with('message', 'User Updated Successfully');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function changePassword($id)
    {
        $user = $this->user->find($id);

        if (Gate::denies('changePassword', $user)) {
            abort(403);
        }

        return view('user.change-password', compact('user'));
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(User $user)
    {
        if (Gate::denies('changePassword', $user)) {
            abort(403);
        }
        
        $this->validator(request()->all())->validate();

        if (!$this->user->changePassword($user, request()->all())) {
            return redirect()->back()->withErrors('Could not change password');
        }

        $route = auth()->user()->role == 'admin' ? 'user.index' : 'home';

        return redirect()->route($route)->with('message', 'Password Changed Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    protected function validator(array $data)
    {
        if (auth()->user()->role == 'admin') {
            return Validator::make($data, [
                'password' => 'required|min:6|confirmed',
            ]);
        }

        return Validator::make($data, [
            'current_password' => 'required|old_password:' . request()->user->password,
            'password' => 'required|min:6|confirmed',
        ]);
    }
}
