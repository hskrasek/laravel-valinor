<?php

namespace Workbench\App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Workbench\App\Http\Requests\CreateUserRequest;

class WorkbenchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Route::post('/', function (CreateUserRequest $createUserRequest) {
            return [
                'name' => $createUserRequest->name,
                'email' => $createUserRequest->email,
                'password' => $createUserRequest->password,
            ];
        });
    }
}
