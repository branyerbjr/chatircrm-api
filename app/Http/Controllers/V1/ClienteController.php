<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = Cliente::all();
        return response()->json(['clientes' => $clientes], 200);
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
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'notas' => 'array',
        ]);

        $cliente = Cliente::create([
            'nombre' => $request->nombre,
            'telefono' => $request->telefono,
            'notas' => $request->notas ?? [],
        ]);

        return response()->json(['cliente' => $cliente], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cliente = Cliente::findOrFail($id);
        return response()->json(['cliente' => $cliente], 200);
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
        $cliente = Cliente::findOrFail($id);

        $request->validate([
            'nombre' => 'string|max:255',
            'telefono' => 'string|max:20',
            'notas' => 'array',
        ]);

        $cliente->update([
            'nombre' => $request->nombre ?? $cliente->nombre,
            'telefono' => $request->telefono ?? $cliente->telefono,
            'notas' => $request->notas ?? $cliente->notas,
        ]);

        return response()->json(['cliente' => $cliente], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();
        return response()->json(['message' => 'Cliente eliminado correctamente'], 200);
    }
}
