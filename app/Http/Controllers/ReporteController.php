<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use Illuminate\Support\Facades\View;

class ReporteController extends Controller
{
    //Exportar todas las personas a Pdf
    public static function export_personas($persona){
        $html = View::make('persona', compact('persona'))->render();
        return Helpers::exp_pdf($html,'Personas');
    }

    // Exportar todas las lineas a Pdf
    public static  function export_lineas($linea){
        $html = View::make('linea', compact('linea'))->render();
        return Helpers::exp_pdf($html, 'Lineas');
    }

    // Exportar todas las trazas del usuario a Pdf
    public static  function export_auditoria($auditoria){
        $html = View::make('auditoria', compact('auditoria'))->render();
        return Helpers::exp_pdf($html, 'auditoria');
    }
}
