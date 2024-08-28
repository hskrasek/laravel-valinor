<?php

use Illuminate\Support\Facades\Route;
use Workbench\App\Http\Requests\CreateUserRequest;

Route::post('/', function (CreateUserRequest $createUserRequest) {
    return [
        'name' => $createUserRequest->name,
        'email' => $createUserRequest->email,
        'password' => $createUserRequest->password,
    ];
});
