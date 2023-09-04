<?php

namespace App\Helpers;

use App\Models\Token;
use Illuminate\Http\Resources\Json\JsonResource;
use Dompdf\Dompdf;

class Helpers
{
    public static function BackResponse( $result, $message, int $code, bool $state)
    {
        if ($result == null) {
            return response([
                'state' => $state,
                'code' => $code,
                'message' => $message
            ])->setStatusCode($code);
        }else
        {
            return $result
            ->additional([
                'state' => $state,
                'code' => $code,
                'message' => $message
            ])
            ->response()->setStatusCode($code);
        }
    }
    public static function respuesta( $result, $message, int $code, bool $state)
    {
        return response()->json([
                'data' => $result,
                'state' => $state,
                'code' => $code,
                'message' => $message
            ]);
    }

    //usuario logueado
    public static function user_log($token)
    {
        // $tokenFormateado = str_replace('Bearer ', '',$token);
        $tok = Token::where('token', $token)->first();
        return $tok->user_id;
    }

    //Exportar a PDF
    public static function exp_pdf($html, $nombre)
    {
        // Establece opciones personalizadas.
        $options = new \Dompdf\Options();
        $options->setIsRemoteEnabled(true);

        // Crear objeto DOMPDF e inicializarlo.
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);

        $dompdf->setPaper('11x17', 'landscape');

        // Renderizar HTML como PDF.
        $dompdf->render();

        $fecha = date('d-m-Y');
        // Enviar respuesta HTTP con archivo PDF descargable.
        return response()->streamDownload(
            fn () => print($dompdf->output()),
            $nombre."($fecha)".".pdf"
        );
    }
}

