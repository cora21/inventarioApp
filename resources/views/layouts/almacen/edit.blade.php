@extends('layouts.app')

@section('title', 'Editar los almacener los almacenes')

@section('contenido')



<div class="card">
    <div class="card-body">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabeleditar">Editar el almace {{$almacen->nombre}}</h1>
        </div>
        <div class="">
            {{-- da inicio al modal de edicion de los almacenes --}}
            <p class="card-text fs-4 text-dark">Aqui puedes editar el almacen de tu empresa</p>
            <div class="mx-auto" style="width: 70%;">
                    <div class="card-body rounded shadow-lg">
                        <form action="{{ route('almacen.update', $almacen->id) }}" method="POST">
                            <div class="container">
                                <div class="row">
                                    @csrf
                                    @method('put')
                                    <!-- Columna para los inputs -->
                                    <div class="col-md-6">
                                        <label for="basic-url" class="form-label text-dark"><strong>Nombre:
                                            </strong><span class="text-danger">*</span></label>
                                        <div class="input-group mb-4">
                                            <div class="input-group input-group-lg">
                                                <input type="text"
                                                                        class="form-control @error('nombre') is-invalid @enderror"
                                                                        aria-label="Sizing example input"
                                                                        aria-describedby="inputGroup-sizing-lg"
                                                                        name="nombre"
                                                                        value="{{$almacen->nombre}}">
                                            </div>
                                            @error('nombre')
                                            <small> <span class="text-danger">{{$message}}</span></small>
                                            @enderror
                                        </div>
                                        <div class="input-group mb-4">
                                            <label for="basic-url"
                                                class="form-label"><strong>Dirección:</strong></label>
                                            <div class="input-group input-group-lg">
                                                <input type="text" class="form-control"
                                                    aria-label="Sizing example input"
                                                    aria-describedby="inputGroup-sizing-lg" name="direccion" value="{{$almacen->direccion}}">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Columna para el textarea -->
                                    <div class="col-md-6">
                                        <label for="basic-url"
                                            class="form-label rounded"><strong>Observaciones:</strong></label>
                                        <div class="input-group h-100">
                                            <textarea name="observaciones" class="form-control" value="{{$almacen->observaciones}}" aria-label="With textarea" style="height: 90%; resize: none;">{{$almacen->observaciones}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>


                    </div>
                    <br><br><br><br>
            </div>
        </div>
        <div class="modal-footer">
            <p class="card-text fs-4 mx-1"> <strong>Los campos con </strong><span class="text-danger">*</span>
                <strong> son obligatorios</strong>
            </p>
            <a href="{{ route('almacen.index') }}" type="button" class="btn btn-outline-success mx-1">Cancelar</a>
            <button type="submit" class="btn btn-success text-gray mx-1">Guardar</button>
        </div>
    </div>
</div>
@endsection

