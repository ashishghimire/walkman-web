<?php

namespace App\Http\Controllers;

use App\Http\Requests\IncentiveRequest;
use App\Services\IncentiveService;
use App\Services\UserService;
use Illuminate\Http\Request;

class IncentiveController extends Controller
{
    /**
     * @var UserService
     */
    protected $user;
    /**
     * @var IncentiveService
     */
    protected $incentive;

    /**
     * IncentiveController constructor.
     * @param UserService $user
     * @param IncentiveService $incentive
     */
    public function __construct(UserService $user, IncentiveService $incentive)
    {
        $this->user = $user;
        $this->middleware('admin');
        $this->incentive = $incentive;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $userId
     * @return \Illuminate\Http\Response
     */
    public function create($userId)
    {
        $user = $this->user->find($userId);

        return view('incentive.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param IncentiveRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(IncentiveRequest $request, $userId)
    {
        $user = $this->user->find($userId);

        if($this->incentive->save($userId, $request->all())) {
            return redirect()->route('user.index')->with('message', "Incentive successfully added for sponsor {$user->name}");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
