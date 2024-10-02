@extends('layouts/contentNavbarLayout')

@section('title', 'Lista Identificador Encuestas')
@section('content')
<div class="container mt-5">
    <div class="card">
        <h5 class="card-header">Lista de Encuestas</h5>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Fecha de Creación</th>
                        <th>Restaurante</th>
                        <th>Comentarios</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @if($encuestas->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center">No hay encuestas disponibles.</td>
                        </tr>
                    @else
                        @foreach($encuestas as $encuesta)
                        <tr>
                            <td>{{ $encuesta->id }}</td>
                            <td>{{ $encuesta->fecha_creacion }}</td>
                            <td>{{ $encuesta->id_restaurante }}</td>
                            <td>{{ $encuesta->comentarios }}</td>
                            <td>
                                <!-- Dropdown para acciones -->
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('nueva.encuesta', ['id' => $encuesta->id]) }}">
                                            <i class="bx bx-edit-alt me-1"></i> Editar
                                        </a>
                                        <form action="{{ route('encuesta.borrar', ['id' => $encuesta->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item" onclick="return confirm('¿Estás seguro de que deseas eliminar esta encuesta?')">
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
