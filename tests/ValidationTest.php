<?php

declare(strict_types=1);

use CuyZ\Valinor\Mapper\TreeMapper;
use HSkrasek\LaravelValinor\Tests\Fixtures\Answer;
use Workbench\App\Http\Requests\CreateUserRequest;

describe('Validation', function () {
    it('requires values for properties', function () {
//        /** @var TreeMapper $mapper */
//        $mapper = resolve(TreeMapper::class);
//        $answer = $mapper->map(Answer::class, [
//            'user' => '',
//            'message' => '',
//            'date' => '1992-06-18'
//        ]);
//
//        dd($answer);
        $request = new CreateUserRequest(
            name: '',
            email: '',
            password: ''
        );

        dd($request->parsedRules());
    });
});
