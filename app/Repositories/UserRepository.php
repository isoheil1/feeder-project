<?php

namespace App\Repositories;

use App\Contracts\UserRepositoryInterface;
use App\Models\User;
use Hash;

class UserRepository implements UserRepositoryInterface
{

    public function create($data)
    {
        $data['password'] = Hash::make($data['password']);
        return User::create($data);
    }

    public function findUser(string $email)
    {
        return User::whereEmail($email)->first();
    }
}
