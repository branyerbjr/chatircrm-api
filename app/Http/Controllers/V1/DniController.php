<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; 

class DniController extends Controller
{
    public function consultarDni($dni)
    {
        $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxNDciLCJuYW1lIjoiQnJhbnllciIsImVtYWlsIjoia2FlbGRleHhAZ21haWwuY29tIiwiaHR0cDovL3NjaGVtYXMubWljcm9zb2Z0LmNvbS93cy8yMDA4LzA2L2lkZW50aXR5L2NsYWltcy9yb2xlIjoiY29uc3VsdG9yIn0.D3xHuyckYgtm2oDIeyU6WU79vpczvhoUasf454v6pdU';

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get("https://api.factiliza.com/pe/v1/dni/info/{$dni}");

            $data = $response->json();

            if ($data['status'] === 200) {
                $filteredData = [
                    'nombres' => $data['data']['nombres'],
                    'apellido_paterno' => $data['data']['apellido_paterno'],
                    'apellido_materno' => $data['data']['apellido_materno'],
                ];
                return response()->json(['data' => $filteredData], 200);
            } else {
                return response()->json(['message' => 'Error al consultar el DNI'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al procesar la solicitud'], 500);
        }
    }
}
