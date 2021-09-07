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
        $requestData = $request->only('name', 'email', 'created_at');
        // dd($requestData);
        // $data = $this->userService->getList($requestData);
        // return $this->success($data);


        if ((isset($requestData['name']) && $requestData['name']) || (isset($requestData['email']) && $requestData['email']) || (isset($requestData['created_at']) && $requestData['created_at'])) {
            $users = User::select('*');
            // dd($users);
            if(isset($requestData['name']) && $requestData['name']) {
                $users = $users->where('name', 'LIKE', '%' . $requestData['name']. '%');
            }
            if(isset($requestData['email']) && $requestData['email']) {
                $users = $users->where('email', 'LIKE', '%' . $requestData['email']. '%');
            }
            if(isset($requestData['created_at']) && $requestData['created_at']) {
                $users = $users->where('created_at', 'LIKE', '%' . $requestData['created_at']. '%');
            }
            return response()->json($users->paginate(25));
        } else {
            $query = User::query();

            $users = $query->orderBy('id','desc')->paginate(25);
            // $users = User::all();
            return response()->json($users);
        }


        // if (empty($requestData['name']) && empty($requestData['email']) && empty($requestData['created_at'])) {
            
        // $query = User::query();

        // $users = $query->orderBy('id','desc')->paginate(25);
        // // $users = User::all();
        // return response()->json($users);
        // } else {
        //     $users = User::select('*');
        //     // dd($users);
        //     if(isset($requestData['name']) && $requestData['name']) {
        //         $users = $users->where('name', 'LIKE', '%' . $request['name']. '%');
        //     }
        //     if(isset($requestData['email']) && $requestData['email']) {
        //         $users = $users->where('email', 'LIKE', '%' . $request['email']. '%');
        //     }
        //     if(isset($requestData['created_at']) && $requestData['created_at']) {
        //         $users = $users->where('created_at', 'LIKE', '%' . $request['created_at']. '%');
        //     }
        //     return response()->json($users);
        // }
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
