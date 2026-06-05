<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Alien;
use Illuminate\Http\Request;

class AlienController extends Controller
{
    public function index()
    {
        return Alien::all();
    }

    public function store(Request $request)
    {
        return Alien::create([
            'name' => $request->name,
            'planet' => $request->planet,
            'age' => $request->age,
        ]);
    }

    public function show(string $id)
    {
        return Alien::findOrFail($id);
    }

    public function update(Request $request, string $id)
    {
        $alien = Alien::findOrFail($id);

        $alien->update([
            'name' => $request->name,
            'planet' => $request->planet,
            'age' => $request->age,
        ]);

        return $alien;
    }

    public function destroy(string $id)
    {
        Alien::destroy($id);

        return response()->json([
            'message' => 'Alien eliminado'
        ]);
    }
}
