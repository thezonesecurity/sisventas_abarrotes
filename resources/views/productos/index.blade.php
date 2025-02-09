@extends('templates.template')
@yield('title', 'productos')
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
    <h1 class="mt-4 text-center">Productos</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item " ><a href="{{route('panel')}}">Inicio</a></li>
        <li class="breadcrumb-item active">Productos</li>
    </ol>
    <div class=" mb-4">
        <a href="{{route('productos.create')}}" >
            <button type="button" class="btn btn-primary" >Añadir registro</button>
        </a>
    </div>
  
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tabla Productos
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped">
                <thead>
                    <tr> 
                        <th>Nro.</th>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        {{--<th>Descripcion</th>--}}
                        <th>Marca</th>
                        <th>Presentacion</th>
                        <th>Categoria</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>  @php $i=0;  @endphp
                    @foreach ($productos as $producto)
                        <tr>
                            <td>{{++$i}}</td>
                            <td>{{$producto->codigo}}</td>
                            <td>{{$producto->nombre}}</td>
                            {{--<td>{{$producto->descripcion}}</td>--}}
                            <td>{{$producto->marca->caracteristica->nombre}}</td>
                            <td>{{$producto->presentacion->caracteristica->nombre}}</td>
                            <td>
                                @foreach ($producto->categorias as $categoria)
                                    <div class="container row">
                                        <span class="m-1 rounded-pill p-1 bg-secondary text-white text-center ">
                                            {{$categoria->caracteristica->nombre}}
                                        </span>
                                    </div>                                    
                                @endforeach
                            </td>
                            @if ($producto->estado == 'Habilitado')
                                <td class="text-success fw-bold">{{$producto->estado}}</td>
                            @else
                                <td class="text-danger fw-bold">{{$producto->estado}}</td>
                            @endif
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                    <form action="{{route('productos.edit',['producto' => $producto])}}" method="GET">
                                        <button type="submit" class="btn btn-success">Editar</button>
                                    </form>
                                </div>   
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalVer-{{$producto->id}}" style="margin-top: -15px;">Ver</button>
                                @if ($producto->estado == 'Habilitado')
                                    <button type="button" class="btn btn-danger " data-bs-toggle="modal" data-bs-target="#confirmarModal-{{$producto->id}}" style="margin-top: -15px;">Eliminar</button>
                                @else
                                    <button type="button" class="btn btn-warning " data-bs-toggle="modal" data-bs-target="#confirmarModal-{{$producto->id}}" style="margin-top: -15px;">Restaurar</button> 
                                @endif
                            </td>

                        </tr>
                        <!-- Modal ver-->
                        <div class="modal fade" id="ModalVer-{{$producto->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"> 
                            <div class="modal-dialog modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Detalle del producto</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                       <div class="row mb-3">
                                            <label for=""> <span class="fw-bolder">Descripcion: </span>{{$producto->descripcion}} </label>
                                       </div>
                                       <div class="row mb-3">
                                            <label for=""> <span class="fw-bolder">Fecha vencimiento: </span>{{$producto->fecha_vencimiento == ''? 'No tiene' : $producto->fecha_vencimiento}} </label>
                                        </div>
                                        <div class="row mb-3">
                                            <label for=""> <span class="fw-bolder">Stock: </span>{{$producto->stock}} </label>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="" class="fw-bolder">Imagen:</label>
                                            @if ($producto->imagen_path != null)
                                                <img src="{{asset('/storage/productos/'.$producto->imagen_path)}}" alt="{{$producto->nombre}}" class="img-fluid img-thumbnail border border-4 rounded">
                                                {{-- <img src="{{ Storage::url('public/productos/'.$producto->imagen_path) }}" alt="{{$producto->nombre}}" class="img-fluid img-thumbnail border border-4 rounded">--}}
                                            @else
                                            <img src="{{asset('/storage/productos/sinfoto.png')}}" alt="{{'Sin foto'}}" class="img-fluid img-thumbnail border border-4 rounded">
                                                
                                            @endif
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Modal eliminar-->
                        <div class="modal fade" id="confirmarModal-{{$producto->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Mensaje de confirmacion</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        {{$producto->estado == 'Habilitado'? 'Seguro que desea eliminar el producto... ?':'Seguro que desea restaurar el producto... ?' }}
                                        
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        <form action="{{route('productos.destroy',['producto'=> $producto->id])}}" method="POST">
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

