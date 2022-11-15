<?php

namespace Domain\Auth\Contracts;


interface RegisterNewUserContract
{
    public function __invoke(array $data);
}