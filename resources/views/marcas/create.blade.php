@extends('templates.template')
@yield('title', 'Crear marca')
@push('css')
<style>
#descripcion{
    resize: none;
}
</style>
@endpush
@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Marcas</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item" ><a href="{{route('panel')}}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{route('marcas.index')}}">Marcas</a></li>
        <li class="breadcrumb-item active">Crear categoria</li>
    </ol>
    <div class="container w-100 border border-3 border-primary rounded p-4 mt-3">
        <form action="{{route('marcas.store')}}" method="POST" autocomplete="off">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nombre" class="form-label">Nombre: </label>
                    <input type="text" name="nombre" id="nombre" class="form-control" value="{{old('nombre')}}">
                    @error('nombre')
                    <small class="text-danger">{{'* '.$message}}</small>
                    @enderror
                </div>
                <div class="col-md-12">
                    <label for="descripcion" class="form-label">descripcion: </label>
                    <textarea name="descripcion" id="descripcion" rows="3" class="form-control"> {{old('descripcion')}}</textarea>
                </div>
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="reset" class="btn btn-danger m-2">Borrar</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@push('js')

@endpush

