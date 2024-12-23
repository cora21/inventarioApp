<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use App\Models\TasasCambios;
use Carbon\Carbon;
use Illuminate\Database\QueryException;

class PrincipalController extends Controller{

    public function index(){
        $tasas = TasasCambios::all();
        $url = 'https://ve.dolarapi.com/v1/dolares/oficial';
        try {
            // Usa cURL para obtener la respuesta
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            $response = curl_exec($ch);
            curl_close($ch);

            // Decodificar el JSON
            $data = json_decode($response, true);

            // Verifica si la clave "promedio" y "fechaActualizacion" están presentes
            $promedio = isset($data['promedio']) ? $data['promedio'] : 'No disponible';
            $fechaActualizacion = isset($data['fechaActualizacion']) ? $data['fechaActualizacion'] : 'No disponible';
        } catch (\Exception $e) {
            // Manejo de errores
            $promedio = 'No disponible';
        }

        // Convertir fechaActualizacion a formato adecuado
        $fechaActualizacion = Carbon::parse($fechaActualizacion)->format('Y-m-d H:i:s'); // Fecha en formato adecuado para comparación

        $tasaCambio = TasasCambios::find(2); // Cambia el ID según necesites
        $fechaDelRegistro = $tasaCambio->created_at;
        $dolarDesdeBase = $tasaCambio->valorMoneda;
        $fechaDelRegistro = Carbon::parse($fechaDelRegistro)->format('Y-m-d H:i:s');



        // aqui realizo la consulta para obtener las tasas de cambio bien sea VES o USD
        $vesBaseMoneda = DB::table('tasas_cambios')->where('id', 2)->value('baseMoneda');
        $vesBaseMoneda = (int) $vesBaseMoneda;

        return view('layouts.inicioDashboard.index', compact('promedio', 'fechaActualizacion', 'tasas', 'fechaDelRegistro', 'dolarDesdeBase', 'vesBaseMoneda'));
    }


public function actualizarTasaCambio(Request $request)
{
    try {
        // Obtiene los datos enviados desde el frontend
        $id = $request->input('id');
        $valorMoneda = $request->input('valorMoneda');
        $created_at = $request->input('created_at');

        // Convierte la fecha a un formato adecuado (Y-m-d H:i:s)
        $created_at = Carbon::parse($created_at)->format('Y-m-d H:i:s');  // Asegúrate de que esté en el formato correcto

        // Actualiza el registro con el id = 2
        DB::table('tasas_cambios')
            ->where('id', $id)
            ->update([
                'valorMoneda' => $valorMoneda,
                'created_at' => $created_at,  // Se guarda en el formato adecuado
            ]);

        // Retorna una respuesta exitosa
        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        // En caso de error, regresa una respuesta con el error
        return response()->json(['success' => false, 'error' => $e->getMessage()]);
    }
}








public function updateBaseMoneda(Request $request)
    {
        // Obtener la moneda seleccionada (USD o VES)
        $moneda = $request->input('moneda');

        // Validar que se haya recibido la moneda correctamente
        if (!$moneda) {
            return response()->json(['success' => false, 'message' => 'Moneda no proporcionada.']);
        }

        try {
            // Primero, asegurarnos de que todos los registros tengan baseMoneda = 0
            DB::table('tasas_cambios')->update(['baseMoneda' => 0]);

            // Ahora, establecemos baseMoneda = 1 en el registro correspondiente
            // Aquí asumimos que el primer registro será el que se debe actualizar para USD
            // y el segundo para VES. Si no es así, ajusta la lógica según tu estructura.
            if ($moneda == 'USD') {
                // Establecer baseMoneda = 1 en el registro correspondiente a USD
                DB::table('tasas_cambios')
                    ->where('id', 1)  // Asumimos que el primer registro es para USD
                    ->update(['baseMoneda' => 1]);
            } elseif ($moneda == 'VES') {
                // Establecer baseMoneda = 1 en el registro correspondiente a VES
                DB::table('tasas_cambios')
                    ->where('id', 2)  // Asumimos que el segundo registro es para VES
                    ->update(['baseMoneda' => 1]);
            }

            return response()->json(['success' => true]);

        } catch (QueryException $e) {
            // Capturar cualquier error de base de datos y devolver un mensaje detallado
            return response()->json(['success' => false, 'message' => 'Error en la base de datos: ' . $e->getMessage()]);
        } catch (\Exception $e) {
            // Capturar cualquier otro error y devolver un mensaje general
            return response()->json(['success' => false, 'message' => 'Error desconocido: ' . $e->getMessage()]);
        }
    }














}
