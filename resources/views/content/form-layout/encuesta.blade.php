@extends('layouts/contentNavbarLayout')

@section('title', $encuesta->exists ? 'Actualizar Encuesta' : 'Crear Encuesta')

@section('content')

<div class="row">
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">{{ $encuesta->exists ? 'Actualizar Encuesta' : 'Crear Encuesta' }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('encuesta.guardar') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $encuesta->id }}">
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="fecha_creacion">Fecha de Creación</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="fecha_creacion" name="fecha_creacion" value="{{ old('fecha_creacion', $encuesta->fecha_creacion) }}" required />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="id_restaurante">ID Restaurante</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="id_restaurante" name="id_restaurante" value="{{ old('id_restaurante', $encuesta->id_restaurante) }}" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="comentarios">Comentarios</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="comentarios" name="comentarios">{{ old('comentarios', $encuesta->comentarios) }}</textarea>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">{{ $encuesta->exists ? 'Actualizar' : 'Crear' }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
