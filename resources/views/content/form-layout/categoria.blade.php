@extends('layouts/contentNavbarLayout')

@section('title', $categoria->exists ? 'Actualizar Categoria' : 'Crear Categoria')

@section('content')

<div class="row">
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">{{ $categoria->exists ? 'Actualizar Categoria' : 'Crear Categoria' }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('categoria.guardar') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $categoria->id }}">
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="nombre">Nombre</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $categoria->nombre) }}" required />
                            @error('nombre')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="descripcion">Descripción</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="descripcion" name="descripcion">{{ old('descripcion', $categoria->descripcion) }}</textarea>
                            @error('descripcion')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">{{ $categoria->exists ? 'Actualizar' : 'Crear' }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
