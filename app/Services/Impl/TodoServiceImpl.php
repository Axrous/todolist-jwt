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
        
    }

    public function showTodoDetail($id)
    {
        
    }

    public function updateTodo($id)
    {
        
    }

    public function deleteTodo($id)
    {
        
    }

}