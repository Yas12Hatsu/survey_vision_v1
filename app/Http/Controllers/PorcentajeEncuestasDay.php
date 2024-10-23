<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Respuesta;
use App\Models\Pregunta;
use App\Models\Categoria;
use Carbon\Carbon;

class PorcentajeEncuestasDay extends Controller
{
    public function index()
    {
        // Fecha de hoy
        $hoy = Carbon::today();

        // Obtener el número total de preguntas en una encuesta
        $totalPreguntas = Pregunta::count();

        // Contar el número total de respuestas registradas hoy
        $totalRespuestasHoy = Respuesta::whereDate('created_at', $hoy)->count();

        // Calcular el número de encuestas completadas hoy
        $encuestasCompletadasHoy = ($totalPreguntas > 0) ? intval($totalRespuestasHoy / $totalPreguntas) : 0;

        // Número total de encuestas posibles
        // Puedes ajustar este valor según tus necesidades
        $totalEncuestas = 10; // Suponiendo que el total posible es 10

        // Calcular el porcentaje de encuestas completadas hoy
        $porcentajeEncuestasHoy = ($totalEncuestas > 0) ? ($encuestasCompletadasHoy / $totalEncuestas) * 100 : 0;

        // Obtener el total de respuestas recibidas
        $totalRespuestasRecibidas = Respuesta::count(); // Total de respuestas

        // Calcular el promedio de calificaciones para la categoría "Calidad-Precio"
        $promedioCalificacionesCalidadPrecio = Respuesta::whereHas('pregunta', function ($query) {
            $query->where('id_categoria', function ($subQuery) {
                $subQuery->select('id')
                    ->from('categoria')
                    ->where('nombre', 'Calidad-Precio');
            });
        })
        ->avg('respuesta_cuanti');

        // Calcular el promedio de calificaciones para la categoría "Ambiente"
        $promedioCalificacionesAmbiente = Respuesta::whereHas('pregunta', function ($query) {
                $query->where('id_categoria', function ($subQuery) {
                    $subQuery->select('id')
                        ->from('categoria')
                        ->where('nombre', 'Ambiente'); // Filtrar por el nombre de la categoría "Ambiente"
                });
            })
            ->avg('respuesta_cuanti');
        
        // Calcular el promedio de calificaciones para la categoría "Atención del Personal"
        $promedioCalificacionesAtencion = Respuesta::whereHas('pregunta', function ($query) {
                $query->where('id_categoria', function ($subQuery) {
                    $subQuery->select('id')
                        ->from('categoria')
                        ->where('nombre', 'Atención del Personal'); // Filtrar por el nombre de la categoría "Atención del Personal"
                });
            })
            ->avg('respuesta_cuanti');
        
        // Obtener las últimas 5 respuestas cualitativas
        $ultimosComentariosCualitativos = Respuesta::whereNotNull('respuesta_cuali')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Contar la cantidad de respuestas por cada nivel de satisfacción
        // Obtener las categorías
        $categorias = Categoria::all();

        // Inicializar un array para almacenar las respuestas por categoría
        $respuestasPorCategoria = [];

        // Recorrer cada categoría y contar las respuestas
        foreach ($categorias as $categoria) {
            // Inicializar la estructura para la categoría
            $respuestasPorCategoria[$categoria->nombre] = [
                1 => 0, // Muy Insatisfecho
                2 => 0, // Insatisfecho
                3 => 0, // Neutral
                4 => 0, // Satisfecho
                5 => 0, // Muy Satisfecho
            ];

            // Contar las respuestas para cada nivel de satisfacción en la categoría
            $respuestas = Respuesta::whereHas('pregunta', function ($query) use ($categoria) {
                $query->where('id_categoria', $categoria->id);
            })->get();

            foreach ($respuestas as $respuesta) {
                if ($respuesta->respuesta_cuanti) {
                    $respuestasPorCategoria[$categoria->nombre][$respuesta->respuesta_cuanti]++;
                }
            }
        }
        // Pasar los datos a la vista
        return view('content.dashboard.dashboards-analytics', compact(
            'porcentajeEncuestasHoy', 
            'totalRespuestasRecibidas', 
            'promedioCalificacionesCalidadPrecio', 
            'promedioCalificacionesAmbiente',
            'promedioCalificacionesAtencion',
            'ultimosComentariosCualitativos',
            'respuestasPorCategoria' // Agregar esta variable
        ));
    }
}
