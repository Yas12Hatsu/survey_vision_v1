@extends('layouts/contentNavbarLayout')

@section('title', $pregunta->exists ? 'Actualizar Pregunta' : 'Crear Pregunta')

@section('content')

<div class="row">
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">{{ $pregunta->exists ? 'Actualizar Pregunta' : 'Crear Pregunta' }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('pregunta.guardar') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $pregunta->id }}">
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="texto">Texto de la Pregunta</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="texto" name="texto" value="{{ old('texto', $pregunta->texto) }}" required />
                            @error('texto')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="tipo">Tipo de Pregunta</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="tipo" name="tipo" value="{{ old('tipo', $pregunta->tipo) }}" required />
                            @error('tipo')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="id_categoria">Categoría</label>
                        <div class="col-sm-10">
                            <select class="form-select" id="id_categoria" name="id_categoria" required>
                                <option value="">Selecciona una categoría</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id }}" {{ old('id_categoria', $pregunta->id_categoria) == $categoria->id ? 'selected' : '' }}>
                                        {{ $categoria->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_categoria')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">{{ $pregunta->exists ? 'Actualizar' : 'Crear' }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
