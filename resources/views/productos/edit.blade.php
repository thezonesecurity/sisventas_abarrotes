@extends('templates.template')
@yield('title', 'Editar producto')
@push('css')
<link href="{{asset('assetes/bootstrapSelect/css/bootstrap-select.min.css') }}" rel="stylesheet" >
<script src="{{asset('assetes/jquery/jquery-3.3.1.min.js') }}" type="text/javascript" crossorigin="anonymous"></script>

{{--<link href="{{asset('assetes/select2/css/select2.min.css') }}" rel="stylesheet" >
<script src="{{asset('assetes/jquery/jquery-3.3.1.min.js') }}" type="text/javascript" crossorigin="anonymous"></script>--}}
<style>
#descripcion{
    resize: none;
}
</style>
@endpush
@section('content')

<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Editar Producto</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item" ><a href="{{route('panel')}}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{route('productos.index')}}">Productos</a></li>
        <li class="breadcrumb-item active">Editar producto</li>
    </ol>
    <div class="container w-100 border border-3 border-primary rounded p-4 mt-3">
        <form action="{{route('productos.update', ['producto' => $producto])}}" method="POST" autocomplete="off" enctype="multipart/form-data">

            @method('PATCH')
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="codigo" class="form-label fw-bold">Codigo: </label>
                    <input type="text" name="codigo" id="codigo" class="form-control" value="{{old('codigo', $producto->codigo)}}">
                    @error('codigo')
                    <small class="text-danger">{{'* '.$message}}</small>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="nombre" class="form-label fw-bold">Nombre: </label>
                    <input type="text" name="nombre" id="nombre" class="form-control" value="{{old('nombre', $producto->nombre)}}">
                    @error('nombre')
                    <small class="text-danger">{{'* '.$message}}</small>
                    @enderror
                </div>
                <div class="col-md-12">
                    <label for="descripcion" class="form-label fw-bold">descripcion: </label>
                    <textarea name="descripcion" id="descripcion" rows="3" class="form-control"> {{old('descripcion', $producto->descripcion)}}</textarea>
                </div>
                <div class="col-md-6">
                    <label for="fecha_vencimiento" class="form-label fw-bold">Fecha vencimiento: </label>
                    <input type="date" name="fecha_vencimiento" id="fecha_vencimiento" class="form-control" value="{{old('fecha_vencimiento', $producto->fecha_vencimiento)}}">
                    @error('fecha_vencimiento')
                    <small class="text-danger">{{'* '.$message}}</small>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="imagen_path" class="form-label fw-bold">Imagen: </label>
                    <input type="file" name="imagen_path" id="imagen_path" class="form-control" value="{{old('imagen_path')}}">
                    @error('imagen_path')
                    <small class="text-danger">{{'* '.$message}}</small>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="marca" class="form-label fw-bold">Marca:</label>
                   
                    <select title="Seleccione una opcion" data-live-search="true" class="form-control selectpicker show-tick dropup" data-dropup-auto="false"  name='marca_id'  id='marca_id' data-size="4">{{--custom-select select2 form-select" style="width: 100%"--}}
                        {{--<option value="vacio" disabled selected>Selecione una opcion</option>--}}
                        @foreach ($marcas as $marca)
                            @if ($marca->id == $producto->marca_id && $marca->caracteristica && $marca->caracteristica->estado == 'Habilitado')
                                <option selected value="{{ $marca->id }}" {{old('marca_id') == $marca->id ? 'selected' : ''}} >{{ $marca->caracteristica->nombre }} </option>
                            @endif
                            @if($marca->caracteristica && $marca->caracteristica->estado == 'Habilitado')
                                <option value="{{ $marca->id }}" {{old('marca_id') == $marca->id ? 'selected' : ''}} >{{ $marca->caracteristica->nombre }} </option>
                            @endif
                        @endforeach
                    </select>
                    @error('marca_id')
                        <small class="text-danger">{{'* '.$message}}</small>
                    @enderror
                </div>
                  
                <div class="col-md-6" >
                    <label for="presentacion" class="form-label fw-bold">Presentacion:</label>
                    <select title="Seleccione una opcion" data-live-search="true" class="form-control selectpicker show-tick dropup" data-dropup-auto="false" style="width: 100%"  name='presentacion_id'  id='presentacion_id' data-size="4">
                        {{--<option value="vacio" disabled selected>Selecione una opcion</option>--}}
                        @foreach ($presentaciones as $presentacion)
                            @if ($presentacion->id == $producto->presentacion_id && $presentacion->caracteristica && $presentacion->caracteristica->estado == 'Habilitado')
                                <option selected value="{{ $presentacion->id }}" {{old('presentacion_id') == $presentacion->id ? 'selected' : ''}} >{{ $presentacion->caracteristica->nombre }} </option>
                            @endif
                            @if($presentacion->caracteristica && $presentacion->caracteristica->estado == 'Habilitado')
                                <option value="{{ $presentacion->id }}" {{old('presentacion_id') == $presentacion->id ? 'selected' : ''}} >{{ $presentacion->caracteristica->nombre }} </option>
                            @endif
                        @endforeach
                    </select>
                    @error('presentacion_id')
                        <small class="text-danger">{{'* '.$message}}</small>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="categoria" class="form-label fw-bold">Categoria:</label>
                    <select title="Seleccione las categorias" data-live-search="true" class="form-control selectpicker show-tick dropup" data-dropup-auto="false" style="width: 100%"  name='categorias[]'  id='categorias' data-size="4" multiple>
                        @foreach ($categorias as $categoria)
                            @if (in_array($categoria->id, $producto->categorias->pluck('id')->toArray() ) && $categoria->caracteristica && $presentacion->caracteristica->estado == 'Habilitado')
                                <option selected value="{{ $categoria->id }}" {{ (in_array($categoria->id, old('categorias', []))) ? 'selected' : '' }} >{{ $categoria->caracteristica->nombre }} </option>
                            @endif
                            @if ($categoria->caracteristica && $presentacion->caracteristica->estado == 'Habilitado')
                                 <option value="{{ $categoria->id }}" {{ (in_array($categoria->id, old('categorias', []))) ? 'selected' : '' }} >{{ $categoria->caracteristica->nombre }} </option>
                            @endif
                        @endforeach
                    </select>
                    @error('categorias')
                        <small class="text-danger">{{'* '.$message}}</small>
                    @enderror
                </div>
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                    <button type="reset" class="btn btn-danger m-2">Borrar</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@push('js')
<script src="{{asset('assetes/bootstrapSelect/js/bootstrap-select.min.js') }}" type="text/javascript" crossorigin="anonymous"></script>
{{--
<script src="{{asset('assetes/select2/js/select2.min.js') }}" type="text/javascript" crossorigin="anonymous"></script>

<script type="text/javascript">
    $('.select2').select2({
        placeholder: "Seleccione una opcion",
        allowClear: true,
        ancho : 'resolver'
    });
  </script>--}}
@endpush

