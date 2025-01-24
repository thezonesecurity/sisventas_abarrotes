@extends('templates.template')
@yield('title', 'categorias')
@push('css')
{{--<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">--}}
<link href="{{asset('templates/css/latest.css') }}" rel="stylesheet" type="text/css">

@endpush
@section('content')
@if (session('success'))
  <div class="alert alert-success" role="alert">
    {{session('success')}}
  </div>
@endif


<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Marcas</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item " ><a href="{{route('panel')}}">Inicio</a></li>
        <li class="breadcrumb-item active">Marcas</li>
    </ol>
    <div class=" mb-4">
        <a href="{{route('marcas.create')}}" >
            <button type="button" class="btn btn-primary" >Añadir registro</button>
        </a>
    </div>
  
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tabla Marcas
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped">
                <thead>
                    <tr> 
                        <th>Nro.</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>  @php $i=0;  @endphp
                    @foreach ($marcas as $marca)
                        <tr>
                            <td>{{++$i}}</td>
                            <td>{{$marca->caracteristica->nombre}}</td>
                            <td>{{$marca->caracteristica->descripcion}}</td>
                        
                            @if ($marca->caracteristica->estado == 'Habilitado')
                                <td class="text-success fw-bold">{{$marca->caracteristica->estado}}</td>
                            @else
                                <td class="text-danger fw-bold">{{$marca->caracteristica->estado}}</td>
                            @endif
                            <td>
                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                <form action="{{route('marcas.edit',['marca' => $marca])}}" method="GET">
                                    <button type="submit" class="btn btn-success">Editar</button>
                                </form>
                            </div>   
                                @if ($marca->caracteristica->estado == 'Habilitado')
                                <button type="button" class="btn btn-danger " data-bs-toggle="modal" data-bs-target="#exampleModal-{{$marca->id}}" style="margin-top: -15px;">Eliminar</button>
                                @else
                                <button type="button" class="btn btn-warning " data-bs-toggle="modal" data-bs-target="#exampleModal-{{$marca->id}}" style="margin-top: -15px;">Restaurar</button> 
                                @endif
                            </td>
                        </tr>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal-{{$marca->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Mensaje de confirmacion</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        {{$marca->caracteristica->estado == 'Habilitado'? 'Seguro que desea eliminar la marca... ?':'Seguro que desea restaurar la marca... ?' }}
                                        
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        <form action="{{route('marcas.destroy',['marca'=> $marca->id])}}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Contirmar</button>
                                        </form>
                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@push('js')
{{--<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>--}}
<script src="{{asset('templates/js/latest.js') }}" type="text/javascript"></script>
<script src="{{asset('templates/js/datatables-simple-demo.js') }}"></script> 

@endpush

