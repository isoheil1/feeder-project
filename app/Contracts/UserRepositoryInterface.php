<?php

namespace App\Contracts;

interface UserRepositoryInterface
{
    public function create(array $data);
    public function findUser(string $email);
}
