<?php

namespace App\Repositories\contracts;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface ApiContracts
{
    function get();
    function store(array $data);
    function destroy();
    function login(array $data);

}
