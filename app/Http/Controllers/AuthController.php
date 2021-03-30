<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Validator;


class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api',['except' => ['login','register']]);
    }

    /**
     * Login action using post method.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return  result  jwt token
     */

    public function login(Request $request) {
        $validator =Validator::make($request->all(),[
            'email' => 'required|email',
            'password' =>'required|string|min:6'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }

        $token_validity = 24*60;
        $this->guard()->factory()->setTTL($token_validity);
        if(!$token =$this->guard()->attempt($validator->validated())){
            return response()->json(['error'=>'Unauthorized'],401);
        }

        return $this->respondwithToken($token);

    }


     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return  result as json response
     */

    public function register(Request $request) {
        
        $validator = Validator::make(
            $request->all(),
            [
            'name' => 'required|string|between:2,100',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            ]
        );

        if($validator->fails()){
            return response()->json([
                $validator->errors()],422);
        }

        $user = User::create(array_merge(
            $validator->validated(),
            ['password'=>bcrypt($request->password)]      

        ));

        return response()->json(['messge' =>'user created','user'=>$user]);
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \$token
     * @return  result as json response
     */

    protected function respondWithToken($token){

        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'token_validity'=>$this->guard()->factory()->getTTL()*60

        ]);
    }

    public function logout()
    {

        $this->guard()->logout();
        return response()->json(['messge'=>'User logged out']);
    }

    public function  refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }


    protected function guard()
    {
        return Auth::guard();
    }

}
