<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Todo;
use Validator;
class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos=Todo::all();
        return response()->json([
            'Todos'=>$todos,
        ]);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $rules=[
            'name'=>'required|min:3',
        ];
        $validator= Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            return response()->json([
              'Errors' => $validator->errors(), 
               'status'=>400
            ]);
        }
        $todo = new Todo();
        $todo->name = $request->name;
        
        $todo->save();
        return response()->json([
           'Message'=> 'Todo Add Successfully', 
           'status' => 200
            ]);
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $todo=Todo::Find($id);
        if($todo){
            return response()->json([
                'Message' => 'Todo Found',
                'Todo' => $todo, 
                'status'=>200
              ]);
        }
        else{
            return response()->json([
                'Message' => 'Invalid Id', 
                 'status'=>400
              ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $todo=Todo::Find($id);
        if($todo){
            $rules=[
                'name'=>'required|min:3',
                'completed'=>'required',
            ];
            $validator= Validator::make($request->all(),$rules);
            if($validator->fails())
            {
                return response()->json([
                  'Errors' => $validator->errors(),
                  'Message'=>'Cannot Update Todo',
                   'status'=>400
                ]);
            }
            $todo->name=$request->name;
            if($request->completed==1)
            $todo->completed='true';
            else
            $todo->completed='false';
            $todo->save();
            $todo=Todo::Find($id);
            return response()->json([
               'Message'=>'Todo Updated Sucessfully with id: '.$id,
               'New Todo is :'=>$todo,
               'Status' =>200
              ]);
        }
        else{
            return response()->json([
                'Message' => 'Invalid Id', 
                 'status'=>400
              ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $todo=Todo::Find($id);
        if($todo){
            $todo->delete();
            return response()->json([
                'Message' => 'Todo With Id: '.$id.' deleted Successfully', 
                 'status'=>200
              ]);
        }
        else{
            return response()->json([
                'Message' => 'Invalid Id', 
                 'status'=>400
              ]);
        }
    }
}
