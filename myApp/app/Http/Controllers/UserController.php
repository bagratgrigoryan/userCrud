<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function CreateUser(Request $req)
    {
        $validation = validator($req->all(), [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|unique:users|email',
            'phone' => 'required|unique:users',
            'password' => 'required|',
            'age' => 'required',
        ]);
        if ($validation->fails()) {
            return response()->json($validation->errors()->messages(), 400);
        }
        $user = new Users();
        $pass = md5($req->password);
        $user->first_name = $req->firstName;
        $user->last_name = $req->lastName;
        $user->email = $req->email;
        $user->phone = $req->phone;
        $user->password = $pass;
        $user->age = $req->age;
        $user->save();

        return response()->json([
            "status" => "success",
            "user" => $user
        ]);
    }

    public function ReadUser()
    {
        $user = Users::all();
        return response()->json(['data' => $user]);
    }

    public function UpdateUser(Request $req, $id)
    {
        $validation = validator($req->all(), [
            'firstName' => 'min:3|max:20',
            'lastName' => 'min:3|max:20',
            'email' => 'unique:users|email',
            'phone' => 'unique:users',
            'password' => 'min:6|max:40',
            "age"=>'number'
        ]);
        if ($validation->fails()) {
            return response()->json($validation->errors()->messages(), 400);
        }
        $user = Users::find($id);
        if (empty($user)){
            return response()->json(["status"=>"false", "message"=> "Something Went Wrong"]);
        }
        $pass = md5($req->password);
        if ($req->firstName) {
            $user->first_name = $req->firstName;
        }
        if ($req->lastName) {
            $user->last_name = $req->lastName;
        }
        if ($req->email) {
            $user->email = $req->email;
        }
        if ($req->phone) {
            $user->phone = $req->phone;
        }
        if ($req->password) {
            $user->password = $pass;
        }
        if ($req->age) {
            $user->age = $req->age;
        }
        $user->save();
        return response()->json(["status"=>"true", "message"=> "fields updated"]);

    }

    public function DeleteUser($id)
    {
        $user = Users::find($id);
        if ($user) {
            $user->delete();
            return response()->json(["status" => "deleted"]);
        } else return response()->json(["status" => "false", "message" => "User Not Found"], 400);
    }

    public function LogInUser(Request $req)
    {
        $password = md5($req->password);
        $user =  Users::where('email',$req->login)->
        where('password',$password)->first();
        if (empty($user)){
            return response()->json(["status"=>"false","message"=>"Invalid Username or Password"],400);
        }
        $user->remember_token = md5(time() . $user->first_name . $user->last_name . time());
        $user->save();
        return response()->json(["status"=>"success","user"=>[
            "remember_token" => $user->remember_token,
        ]]);
    }

    public function Authorization(Request $req)
    {
        $user = Users::where('remember_token',$req->header('Authorization'))->first();
        if (empty($user)){
            return response()->json(["status"=>"false","message"=>"Something Went Wrong"]);
        }
        return response()->json([
            "first_name" => $user->first_name,
            "last_name" => $user->last_name,
            "avatar" => asset('images/avatar/'.$user->avatar),
            "email"=>$user->email,
            "age" => $user->age,
        ]);

    }
}
