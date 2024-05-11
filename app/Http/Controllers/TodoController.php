<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $todos = Todo::all();

        if($todos->count() > 0){

            return response()->json([
                'status' => 200,
                'todos' => $todos
            ], 200);

        }else {
            return response()->json([
                'status' => 404,
                'message' => 'No Records Found'
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $validattor = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        if($validattor->fails()) {

            return response()->json([
                'status' => 422,
                'errors' => $validattor->messages()
            ], 422);

        }else {

            $todo = Todo::create([
                'title' => $request->title,
                'description' => $request->description,
            ]);

            if($todo) {

                return response()->json([
                    'status' => 200,
                    'message' => "Todo created successfully"
                ], 200);

            }else {

                return response()->json([
                    'status' => 500,
                    'message' => "Something Went Wrong"
                ], 500);
            }
        }
    }

    public function show($id)
    {
        $todo = Todo::find($id);

        if($todo) {
            return response()->json([
                'status' => 200,
                'todo' => $todo
            ], 200);

        }else {

            return response()->json([
                'status' => 404,
                'message' => "No Such Todo Found!"
            ], 404);

        }
    }

    public function edit($id)
    {
        $todo = Todo::find($id);

        if($todo) {
            return response()->json([
                'status' => 200,
                'todo' => $todo
            ], 200);

        }else {

            return response()->json([
                'status' => 404,
                'message' => "No Such Todo Found!"
            ], 404);

        }
    }

    public function update(Request $request, $id)
    {
        $validattor = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        if($validattor->fails()) {

            return response()->json([
                'status' => 422,
                'errors' => $validattor->messages()
            ], 422);

        }else {

            $todo = Todo::find($id);

            if($todo) {

                $todo->update([
                    'title' => $request->title,
                    'description' => $request->description,
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => "Todo Updated Successfully"
                ], 200);

            }else {

                return response()->json([
                    'status' => 404,
                    'message' => "No Such Todo Found!"
                ], 404);
            }
        }

    }

    public function destroy($id)
    {
        $todo = Todo::find($id);

        if($todo) {

            $todo->delete();

            return response()->json([
                'status' => 200,
                'message' => "Todo Deleted Successfully"
            ], 200);

        }else {

            return response()->json([
                'status' => 404,
                'message' => "No Such Todo Found!"
            ], 404);

        }
    }
}
