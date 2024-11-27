@extends('layouts.app')




@section('title', 'Editar a los proveedores')


@section('contenido')
<div class="card">
    <div class="card-body">
        <form action="{{ route( 'proveedor.update', $proveedor->id ) }}" method="POST">
        @csrf
        @method('put')
        <div>
            <div class="row align-items-center">
                <div class="col">
                    <label for=""><strong>Nombre de la empresa:</strong></label>
                </strong><span class="text-danger" style="font-size: 1.2rem;">*</span></label>
                    <input name="nombreProveedor" type="text" class="form-control mb-3 input-progreso @error('nombreProveedor') is-invalid @enderror" value="{{ $proveedor->nombreProveedor }}">
                    @error('nombreProveedor')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                    <div>
                        <small style="color: white"> hola </small>
                    </div>

                </div>

                <div class="col">
                    <label for=""><strong>Correo Electronico:</strong></label>
                </strong><span class="text-danger" style="font-size: 1.2rem;">*</span></label>
                    <input name="emailProveedor" type="email" class="form-control mb-3 input-progreso @error('emailProveedor') is-invalid @enderror" value="{{ $proveedor->emailProveedor }}">
                    <div>
                        <small style="color: rgb(197, 194, 194)">ejemplo@ejemplo.com</small>
                    </div>
                    @error('emailProveedor')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>
                <div class="col">
                    <label for=""><strong>Número Telf.</strong></label>
                </strong><span class="text-danger" style="font-size: 1.2rem;">*</span></label>
                    <input name="telefonoProveedor" type="text" class="form-control mb-3 input-progreso @error('telefonoProveedor') is-invalid @enderror" placeholder="(0000)-000-00-00" value="{{ $proveedor->telefonoProveedor }}">
                    <div>
                        <small style="color: rgb(197, 194, 194)">Favor ingrese un número de teléfono valido </small>
                    </div>
                    @error('telefonoProveedor')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>
            </div>
        </div>
        <br>
        <div>
            <div class="row align-items-center">
                <div class="col">
                    <label for="documento"><strong>Documento de identidad:</strong></label>
                </strong><span class="text-danger" style="font-size: 1.2rem;">*</span></label>
                    <div class="input-group">
                        <select class="form-control" name="nacionalidad" id="documento" style="width: auto;">
                            <option value="V" {{ $proveedor->nacionalidad == 'V' ? 'selected' : '' }}>V.-</option>
                            <option value="E" {{ $proveedor->nacionalidad == 'E' ? 'selected' : '' }}>E.-</option>
                            <option value="J" {{ $proveedor->nacionalidad == 'J' ? 'selected' : '' }}>J.-</option>
                            <option value="G" {{ $proveedor->nacionalidad == 'G' ? 'selected' : '' }}>G.-</option>
                        </select>
                        <input type="text" id="rif_cedula" name="rif_cedula" placeholder="Número de documento" class="form-control input-progreso @error('rif_cedula') is-invalid @enderror" style="width: 70%;" value="{{ $proveedor->rif_cedula }}" >
                        <div>
                            <small style="color: rgb(197, 194, 194)">Si es una empresa ingrese RIF</small>
                        </div>
                        @error('rif_cedula')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col">
                    <label for=""><strong>Dirección Corta:</strong></label>
                    <input type="text" id="" name="direccionProveedor" class="form-control input-progreso" value="{{ $proveedor->direccionProveedor }}">
                    <div>
                        <small style="color: rgb(255, 255, 255)">RIF</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <p class="card-text fs-4"> <strong>Los campos con </strong><span class="text-danger"
            style="font-size: 1.2rem;">*</span>
        <strong> son obligatorios</strong>
    </p>
    <a href="{{route('proveedor.index')}}" type="button" class="btn btn-outline-primary mx-1">Cancelar</a>
    <button type="submit" class="btn btn-primary text-gray mx-1">Guardar</button>
</div>
</form>
@endsection
