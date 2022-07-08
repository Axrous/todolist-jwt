<?php

namespace App\Services\Impl;

use App\Models\Todo;
use App\Services\TodoService;
use Exception;
use Illuminate\Support\Facades\Validator;

class TodoServiceImpl implements TodoService {

    private Todo $todo;


    public function __construct(Todo $todo)
    {
        $this->todo = $todo;
    }

    public function saveTodo($data)
    {
        $validation = Validator::make($data,[
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:255'
        ]);

        if($validation->fails()) {
            return new Exception($validation->errors()->first());
        }

        $todo = $this->todo::create([
            'user_id' => $data['user_id'],
            'title' => $data['title'],
            'description' => $data['description']
        ]);

        return $todo;

    }

    public function showAllTodo($idUser)
    {
        $todos = $this->todo::where('user_id', $idUser)->get();

        if($todos->isEmpty()) {
            return null;
        }

        return $todos;
    }

    public function showTodoDetail($id)
    {
        $todos = $this->todo::where('id', $id)->get();

        if($todos->isEmpty()) {
            return null;
        }

        return $todos;
        
    }

    public function updateTodo($todo, $id)
    {
        $validation = Validator::make($todo,[
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:255'
        ]);

        if($validation->fails()) {
            return new Exception($validation->errors()->first());
        }

        // $result = $this->todo::where('id', $id)
        //     ->update([
        //         "title" => $todo['title'],
        //         "description" => $todo['description']
        //     ]);

        $result = $this->todo::find($id);

        if($result == null) {
            return null;
        }

        $result->title = $todo['title'];
        $result->description = $todo['description'];
        $result->save();
        return $result;
    }

    public function deleteTodo($id)
    {
        $result = $this->todo::find($id);

        $result->delete();

        return $result;
    }

}