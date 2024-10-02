@extends('layouts/contentNavbarLayout')

@section('title', 'Lista de Respuestas')
@section('content')
<div class="container mt-5">
    <div class="card">
        <h5 class="card-header">Lista de Respuestas</h5>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>ID Encuesta</th>
                        <th>ID Pregunta</th>
                        <th>Respuesta Cuantitativa</th>
                        <th>Respuesta Cualitativa</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @if($respuestas->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center">No hay respuestas disponibles.</td>
                        </tr>
                    @else
                        @foreach($respuestas as $respuesta)
                        <tr>
                            <td>{{ $respuesta->id }}</td>
                            <td>{{ $respuesta->id_encuesta }}</td>
                            <td>{{ $respuesta->id_pregunta }}</td>
                            <td>{{ $respuesta->respuesta_cuanti ?? 'N/A' }}</td>
                            <td>{{ $respuesta->respuesta_cuali ?? 'N/A' }}</td>
                            <td>
                                <!-- Dropdown para acciones -->
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('respuesta.editar', ['id' => $respuesta->id]) }}">
                                            <i class="bx bx-edit-alt me-1"></i> Editar
                                        </a>
                                        <form action="{{ route('respuesta.borrar', ['id' => $respuesta->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item" onclick="return confirm('¿Estás seguro de que deseas eliminar esta respuesta?')">
                                                <i class="bx bx-trash me-1"></i> Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
