<?php

namespace App\Http\Controllers;

use App\Services\TodoService;
use Exception;
use Illuminate\Http\Request;

class TodoController extends Controller
{

    private TodoService $todoService;

    public function __construct(TodoService $todoService)
    {
        $this->middleware('auth:api');

        $this->todoService = $todoService;
    }

    public function store(Request $request)
    {
        $data = $request->only([
            'title',
            'description',
        ]);

        $data['user_id'] = auth()->id();

        try{
            $result = $this->todoService->saveTodo($data);
        } catch(Exception $exception) {
            return response()->json([
                'status' => $exception->getCode(),
                'message' => $exception->getMessage()
            ]);
        }

        return response()->json([
            "status" => 'success',
            "message" => "Todo Created Successfully",
            "todo" => $result   
        ]);
    }

    public function show() {
        $idUser = auth()->id();

        try {
            $result = $this->todoService->showAllTodo($idUser);
        } catch(Exception $exception) {
            return response()->json([
                'status' => $exception->getCode(),
                'message' => $exception->getMessage()
            ]);
        }
        if($result == null) {
            return response()->json([
                "status" => 'success',
                "message" => 'NO TODO'
            ]);
        }

        return response()->json([
            "status" => 'success',
            "todos" => $result   
        ]);
    }

    public function showDetail($id) {
        
        try{
            $result = $this->todoService->showTodoDetail($id);
        } catch(Exception $exception) {
            return response()->json([
                'status' => $exception->getCode(),
                'message' => $exception->getMessage()
            ]);
        }

        return response()->json([
            "status" => 'success',
            "todos" => $result
        ]);
    }

    public function update(Request $request, $id) 
    {
        $todo = $request->only(["title", "description"]);

        try{
            $result = $this->todoService->updateTodo($todo, $id);
        }catch(Exception $exception) {
            return response()->json([
                'status' => $exception->getCode(),
                'message' => $exception->getMessage()
            ]);
        }

        if($result == null) {
            return response()->json([
                'status' => "Failed",
                'message' => 'No Todo with id = ' . $id,
            ]);
        };

        return response()->json([
            'status' => "success",
            'message' => 'Todo has been updated',
            'todos' => $result
        ]);
    }

    public function destroy($id) {

        try{
            $result = $this->todoService->deleteTodo($id);
        }catch(Exception $exception) {
            return response()->json([
                'status' => $exception->getCode(),
                'message' => $exception->getMessage()
            ]);
        }

        return response()->json([
            'status' => 'success',
            'todo' => $result
        ]);
    }


}
