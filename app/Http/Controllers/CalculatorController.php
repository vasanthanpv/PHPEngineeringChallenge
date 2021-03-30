<?php

namespace App\Http\Controllers;
use App\Models\Calculator;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Validator;

class CalculatorController extends Controller
{

    protected $user;

    public function __construct()
    {
        $this->middleware('auth:api');
        $this->user = $this->guard()->user();
    }
    
    /**
     * function used for addition
     *  @parameters num1,num2
     */

    public function  addition(Request $request)
    {
      
        $validator =Validator::make($request->all(),[
         'num1' =>'required|integer',
         'num2' =>'required|integer',

        ]);

        if($validator->fails()){

            return response()->json([
                'status' =>false,
                'errors' => $validator->errors()
            ],400);
        }

        return response()->json([
            'status'=>true,
            'answer' =>$request->num1+$request->num2,
        ]);
         
    }
    
     /**
     * function used for subtraction
     *  @parameters num1,num2
     */

    public function  subtraction(Request $request)
    {
      
        $validator =Validator::make($request->all(),[
         'num1' =>'required|integer',
         'num2' =>'required|integer',

        ]);

        if($validator->fails()){

            return response()->json([
                'status' =>false,
                'errors' => $validator->errors()
            ],400);
        }

        return response()->json([
            'status'=>true,
            'answer' =>$request->num1-$request->num2,
        ]);
         
    }

    /**
     * function used for Multiplication
     *  @parameters num1,num2
     */

    public function  multiplication(Request $request)
    {
      
        $validator =Validator::make($request->all(),[
         'num1' =>'required|integer',
         'num2' =>'required|integer',

        ]);

        if($validator->fails()){

            return response()->json([
                'status' =>false,
                'errors' => $validator->errors()
            ],400);
        }

        return response()->json([
            'status'=>true,
            'answer' =>$request->num1*$request->num2,
        ]);
         
    }

    /**
     * function used for division
     *  @parameters num1,num2
     */

    public function  division(Request $request)
    {
      
        $validator =Validator::make($request->all(),[
         'num1' =>'required|integer',
         'num2' =>'required|integer',

        ]);

        if($validator->fails()){

            return response()->json([
                'status' =>false,
                'errors' => $validator->errors()
            ],400);
        }

        return response()->json([
            'status'=>true,
            'answer' =>($request->num1)/($request->num2),
        ]);
         
    }

     /**
     * function used to find square root
     *  @parameters num1
     */

    public function  squareRoot(Request $request)
    {
      
        $validator =Validator::make($request->all(),[
         'num1' =>'required|integer',
         
        ]);

        if($validator->fails()){

            return response()->json([
                'status' =>false,
                'errors' => $validator->errors()
            ],400);
        }

        return response()->json([
            'status'=>true,
            'answer' =>sqrt($request->num1),
        ]);
         
    }
    
     /**
     * function used to save value
     *  @parameters num1
     */

    public function saveValue(Request $request)
    {
      
        $validator =Validator::make($request->all(),[
         'num1' =>'required|integer',
         
        ]);

        if($validator->fails()){

            return response()->json([
                'status' =>false,
                'errors' => $validator->errors()
            ],400);
        }

        $savedata=new Calculator();
        $savedata->save_value = $request->num1;
         if($this->user->calc()->save($savedata)){
            return response()->json([
                'save'=>true,
                
            ]);
        }
       else {
        return response()->json([
            'status'=>false,
            'message' =>'Saving action not completed',
        ]);
       }
         
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    public function savedValue(Request $request)
    {
        $saveddata=$this->user->calc()->get(['id','save_value','created_by']);
        return response()->json($saveddata->toArray());
    }

    public function clearValue(Request $request)
    {

       $savedata = new Calculator();
       $savedata->save_value = '';
       if($this->user->calc()->save($savedata)){
           return response()->json([
                'value'=>'null',
                
            ]);
         }
    
    }


    protected function  guard()
    {
      return Auth::guard();

    }
}
