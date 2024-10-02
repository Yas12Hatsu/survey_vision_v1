@extends('layouts/contentNavbarLayout')

@section('title', 'Lista de categorias registradas')
@section('content')
<div class="container mt-5">
    <div class="card">
        <h5 class="card-header">Lista de Categorías</h5>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @if($categorias->isEmpty())
                        <tr>
                            <td colspan="4" class="text-center">No hay categorías disponibles.</td>
                        </tr>
                    @else
                        @foreach($categorias as $categoria)
                        <tr>
                            <td>{{ $categoria->id }}</td>
                            <td>{{ $categoria->nombre }}</td>
                            <td>{{ $categoria->descripcion }}</td>
                            <td>
                                <!-- Dropdown para acciones -->
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('nueva.categoria', ['id' => $categoria->id]) }}">
                                            <i class="bx bx-edit-alt me-1"></i> Editar
                                        </a>
                                        <form action="{{ route('categoria.borrar', ['id' => $categoria->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item" onclick="return confirm('¿Estás seguro de que deseas eliminar esta categoría?')">
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
