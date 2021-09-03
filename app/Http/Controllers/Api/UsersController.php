<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserPostRequest;
use App\Http\Requests\UserPutRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{

    public function index(Request $request)
    {

        // $requestData = $request->all();
        // dd($requestData);
        // $data = $this->userService->getList($requestData);
        // return $this->success($data);

        
        $query = User::query();

        $users = $query->orderBy('id','desc')->paginate(1);
        // dd($users);
        // $users = User::all();
        return response()->json($users);

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserPutRequest $request
     * @param \App\Models\User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function update($id, UserPutRequest $request)
    {
        $requestData = $request->only('name', 'email', 'password');
        if($requestData['password']) {
            $requestData['password'] = bcrypt($requestData['password']);
        } else {
            unset($requestData['password']);
        }
        User::where('id', $id)->update($requestData);
        return response()->json(true);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param UserPostRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(UserPostRequest $request)
    {
        $params = $request->only('name', 'email', 'password');
        $params['password'] = bcrypt($params['password']);
        $data = User::create($params);
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        // dd($user);
        $data = $user->delete();
        return response()->json($data);
    }


}
