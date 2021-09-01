<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserPostRequest;
use App\Http\Requests\UserPutRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller{

    public function search(Request $request) {
        $requestData = $request->only('name', 'email', 'created_at');

        $keyword_name = $requestData['name'];
        $keyword_email = $requestData['email'];
        $keyword_created_at = $requestData['created_at'];

        if(!empty($keyword_name) && empty($keyword_email) && empty($keyword_created_at)) {
            $query = User::query();
            $users = $query->where('name','like','%' .$keyword_name. '%')->get();
            return response()->json($users);
        }

        elseif(empty($keyword_name) && !empty($keyword_email) && empty($keyword_created_at)) {
            $query = User::query();
            $users = $query->where('email','like','%' .$keyword_email. '%')->get();
            return response()->json($users);
        }

        elseif(empty($keyword_name) && empty($keyword_email) && !empty($keyword_created_at)) {
            $query = User::query();
            $users = $query->where('created_at','>=', $keyword_created_at)->get();
            return response()->json($users);
        }

        elseif(!empty($keyword_name) && !empty($keyword_email) && empty($keyword_created_at)) {
            $query = User::query();
            $users = $query->where('name','like','%' .$keyword_name. '%')->where('email','like','%' .$keyword_email. '%')->get();
            return response()->json($users);
        }

        elseif(!empty($keyword_name) && empty($keyword_email) && !empty($keyword_created_at)) {
            $query = User::query();
            $users = $query->where('name','like','%' .$keyword_name. '%')->where('created_at','>=', $keyword_created_at)->get();
            return response()->json($users);
        }

        elseif(empty($keyword_name) && !empty($keyword_email) && !empty($keyword_created_at)) {
            $query = User::query();
            $users = $query->where('email','like','%' .$keyword_email. '%')->where('created_at','>=', $keyword_created_at)->get();
            return response()->json($users);
        }

        elseif(!empty($keyword_name) && !empty($keyword_email) && !empty($keyword_created_at)) {
            $query = User::query();
            $users = $query->where('name','like','%' .$keyword_name. '%')->where('email','like','%' .$keyword_email. '%')->where('created_at','>=', $keyword_created_at)->get();
            return response()->json($users);
        }

        elseif(empty($keyword_name) && empty($keyword_email) && empty($keyword_created_at)) {
            $users = User::all();
            return response()->json($users);
        }
    }
}