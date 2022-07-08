<?php

namespace App\Services;

interface TodoService {
    
    public function saveTodo($todo);
    public function showAllTodo($idUser);
    public function updateTodo($todo, $id);
    public function showTodoDetail($id);
    public function deleteTodo($id);
}