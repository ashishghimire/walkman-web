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
     * @param $userId
     * @return \Illuminate\Http\Response
     */
    public function store(IncentiveRequest $request, $userId)
    {
        $user = $this->user->find($userId);

        if ($this->incentive->save($userId, $request->all())) {
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
     * @param $userId
     * @param $incentiveId
     * @return \Illuminate\Http\Response
     */
    public function edit($userId, $incentiveId)
    {
        $user = $this->user->find($userId);
        $incentive = $this->incentive->find($incentiveId);

        return view('incentive.edit', compact('user', 'incentive'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param IncentiveRequest|Request $request
     * @param $userId
     * @param $incentiveId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(IncentiveRequest $request, $userId, $incentiveId)
    {
        if (!$this->incentive->update($incentiveId, $request->all())) {
            return redirect()->back()->withErrors('There was a problem in updating user');
        }

        return redirect()->route('user.show', $userId)->with('message', 'Incentive successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $userId
     * @param $incentiveId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($userId, $incentiveId)
    {
        if (!$this->incentive->delete($incentiveId)) {
            return redirect()->back()->withErrors('There was a problem in deleting incentive');
        }

        return redirect()->route('user.show', $userId)->with('message', 'Incentive successfully deleted');
    }
}
