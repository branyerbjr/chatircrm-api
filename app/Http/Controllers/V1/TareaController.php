<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tarea;

class TareaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tareas = Tarea::all();
        return response()->json(['tareas' => $tareas], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'fechaLimite' => 'required|date',
            'estado' => 'required|string|max:255',
            'asignadoA' => 'required|exists:users,id',
        ]);

        $tarea = Tarea::create([
            'descripcion' => $request->descripcion,
            'fechaLimite' => $request->fechaLimite,
            'estado' => $request->estado,
            'asignadoA' => $request->asignadoA,
        ]);

        return response()->json(['tarea' => $tarea], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tarea = Tarea::findOrFail($id);
        return response()->json(['tarea' => $tarea], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tarea = Tarea::findOrFail($id);

        $request->validate([
            'descripcion' => 'string|max:255',
            'fechaLimite' => 'date',
            'estado' => 'string|max:255',
            'asignadoA' => 'exists:users,id',
        ]);

        $tarea->update([
            'descripcion' => $request->descripcion ?? $tarea->descripcion,
            'fechaLimite' => $request->fechaLimite ?? $tarea->fechaLimite,
            'estado' => $request->estado ?? $tarea->estado,
            'asignadoA' => $request->asignadoA ?? $tarea->asignadoA,
        ]);

        return response()->json(['tarea' => $tarea], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tarea = Tarea::findOrFail($id);
        $tarea->delete();
        return response()->json(['message' => 'Tarea eliminada correctamente'], 200);
    }
}
