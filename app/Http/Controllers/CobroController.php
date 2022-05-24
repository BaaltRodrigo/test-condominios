<?php

namespace App\Http\Controllers;

use App\Models\Cobro;
use App\Http\Requests\Cobro\UpdateCobroRequest;
use App\Http\Requests\Cobro\StoreCobroRequest;
use Illuminate\Http\Request;

class CobroController extends Controller
{
    public function index(Request $request)
    {
        return Cobro::all();
    }

    public function show(Cobro $cobro)
    {
        return $cobro;
    }

    public function store(StoreCobroRequest $request)
    {
        $cobro = Cobro::create($request->validated() );
        return $cobro;
    }

    public function update(Cobro $cobro, UpdateCobroRequest $request)
    {
        $cobro->update($request->validated());
        return $cobro;
    }

    public function destroy(Cobro $cobro)
    {
        abort(403);
    }
}
