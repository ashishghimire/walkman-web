<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Session;
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
        $this->middleware('admin', ['only' => ['index', 'edit', 'update', 'masquerade']]);
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
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->user->find($id);

        if (Gate::denies('view', $user)) {
            return redirect()->route('home')->with('message', 'You are not allowed to view this page');
        }
        return view('user.show', compact('user'));

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
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, $id)
    {
        $user = $this->user->find($id);

        if (!$this->user->update($user, $request->all())) {
            return redirect()->back()->withErrors('There was a problem in updating user');
        }

        return redirect()->route('user.index')->with('message', 'User Updated Successfully');
    }

    /**
     * Change password form
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function changePassword($id)
    {
        $user = $this->user->find($id);

        if (Gate::denies('changePassword', $user)) {
            return redirect()->route('home')->with('message', 'You are not allowed to perform this action');
        }

        return view('user.change-password', compact('user'));
    }

    /**
     * Update password
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword($id)
    {
        $user = $this->user->find($id);

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
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Validate password
     *
     * @param array $data
     * @return mixed
     */
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

    /**
     * Impersonate user
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function masquerade($id)
    {
        $sponsor = $this->user->find($id);
        Session::put('admin-logged-in', auth()->id());
        auth()->login($sponsor);

        return redirect()->route('home');
    }

    /**
     * Switch back to admin
     * @return \Illuminate\Http\RedirectResponse
     */
    public function stopMasquerade()
    {
        $id = Session::pull('admin-logged-in');
        $admin = $this->user->find($id);
        auth()->login($admin);

        return redirect()->route('home');
    }
}
