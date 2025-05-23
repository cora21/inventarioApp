<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\TasasCambios;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
   
public function boot()
{
    View::composer('*', function ($view) {
        try {
            // Datos desde la API
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://ve.dolarapi.com/v1/dolares/oficial');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            $response = curl_exec($ch);
            curl_close($ch);

            $data = json_decode($response, true);
            $promedio = $data['promedio'] ?? 0;
            $fechaActualizacion = $data['fechaActualizacion'] ?? now();

            // Base de datos
            $tasaCambio = TasasCambios::find(2);
            $dolarDesdeBase = $tasaCambio?->valorMoneda ?? 0;
            $fechaDelRegistro = $tasaCambio?->created_at ?? now();

            $view->with([
                'dolarDesdeBase' => $dolarDesdeBase,
                'fechaDelRegistro' => Carbon::parse($fechaDelRegistro)->format('Y-m-d H:i:s'),
                'fechaActualizacion' => Carbon::parse($fechaActualizacion)->format('Y-m-d H:i:s'),
                'promedio' => $promedio,
            ]);
        } catch (\Exception $e) {
            $view->with([
                'dolarDesdeBase' => 0,
                'fechaDelRegistro' => now()->format('Y-m-d H:i:s'),
                'fechaActualizacion' => now()->format('Y-m-d H:i:s'),
                'promedio' => 0,
            ]);
        }
    });
}
}
