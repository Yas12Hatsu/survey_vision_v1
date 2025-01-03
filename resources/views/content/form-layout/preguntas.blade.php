@extends('layouts/contentNavbarLayout')

@section('title', 'Lista de Preguntas Registradas')

@section('content')
<div class="container mt-5">
    <div class="card">
        <h5 class="card-header">Lista de Preguntas</h5>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Texto de la Pregunta</th>
                        <th>Tipo</th>
                        <th>Categoría</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @if($preguntas->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center">No hay preguntas disponibles.</td>
                        </tr>
                    @else
                        @php
                            // Inicializar la variable para guardar la categoría anterior
                            $categoriaAnterior = null;
                            // Agrupar preguntas por categoría y luego ordenar cada grupo por ID
                            $preguntasAgrupadas = $preguntas->groupBy(function($pregunta) {
                                return $pregunta->categoria->nombre;
                            })->map(function($group) {
                                return $group->sortBy('id');
                            });
                        @endphp
                        @foreach($preguntasAgrupadas as $categoria => $preguntasGrupo)
                            <tr>
                                <td colspan="5" class="table-secondary text-center"><strong>{{ $categoria }}</strong></td>
                            </tr>
                            @foreach($preguntasGrupo as $pregunta)
                                <tr>
                                    <td>{{ $pregunta->id }}</td>
                                    <td>{{ $pregunta->texto }}</td>
                                    <td>{{ $pregunta->tipo }}</td>
                                    <td>{{ $pregunta->categoria->nombre ?? 'Sin categoría' }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('nueva.pregunta', ['id' => $pregunta->id]) }}">
                                                    <i class="bx bx-edit-alt me-1"></i> Editar
                                                </a>
                                                <form action="{{ route('pregunta.borrar', ['id' => $pregunta->id]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item" onclick="return confirm('¿Estás seguro de que deseas eliminar esta pregunta?')">
                                                        <i class="bx bx-trash me-1"></i> Eliminar
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3 text-end">
        <a href="{{ route('nueva.pregunta') }}" class="btn btn-primary">Crear Nueva Pregunta</a>
    </div>
</div>
@endsection
