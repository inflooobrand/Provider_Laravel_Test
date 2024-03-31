<?php

namespace App\Repositories\contracts;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface CurdContracts
{
    function all();
    function getSingleRecord(Model $model);
    function store(array $data);
    function update(array $data,Model $model);
    function destroy(Model $model);
    
}
