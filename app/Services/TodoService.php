<?php

namespace App\Services;

interface TodoService {
    
    public function saveTodo($todo);
    public function showAllTodo($idUser);
    public function updateTodo($id, $data);
    public function showTodoDetail($id);
    public function deleteTodo($id);
}