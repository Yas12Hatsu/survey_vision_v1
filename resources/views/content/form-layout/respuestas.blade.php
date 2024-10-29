@extends('layouts/contentNavbarLayout')

@section('title', 'Lista de Respuestas')

@section('content')
<div class="container mt-5">
    <div class="card">
        <h5 class="card-header">Lista de Respuestas (¿Qué es lo que opinan tus clientes hoy?)</h5>
        
        <!-- Filtro por categoría -->
        <div class="card-body">
            <form method="GET" action="{{ route('respuestas.lista') }}" class="mb-3">
                <label for="categoria" class="form-label">Filtrar por Categoría:</label>
                <select id="categoria" name="categoria" class="form-select" onchange="this.form.submit()">
                    <option value="">Todas las Categorías</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ $categoriaSeleccionada == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
            </form>

            <!-- Tabla de respuestas -->
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-sm">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>ID Encuesta</th>
                            <th>Pregunta</th>
                            <th>Respuesta Cuantitativa</th>
                            <th>Respuesta Cualitativa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($respuestas->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center">No hay respuestas disponibles.</td>
                            </tr>
                        @else
                            @foreach($respuestas as $respuesta)
                            <tr>
                                <td>{{ $respuesta->id }}</td>
                                <td>{{ $respuesta->id_encuesta }}</td>
                                <td>{{ $respuesta->pregunta->texto ?? 'Pregunta no disponible' }}</td>
                                <td>
                                    @if (!is_null($respuesta->respuesta_cuanti))
                                        <span>
                                            @if ($respuesta->respuesta_cuanti === 1) 😠 Muy Insatisfecho @endif
                                            @if ($respuesta->respuesta_cuanti === 2) 😟 Insatisfecho @endif
                                            @if ($respuesta->respuesta_cuanti === 3) 😐 Neutral @endif
                                            @if ($respuesta->respuesta_cuanti === 4) 🙂 Satisfecho @endif
                                            @if ($respuesta->respuesta_cuanti === 5) 😃 Muy Satisfecho @endif
                                        </span>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ $respuesta->respuesta_cuali ?? 'N/A' }}</td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
