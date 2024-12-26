@extends('layouts.app')

@section('title', 'Registro de las categorias')

@section('contenido')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('categoria.update', $categoria->id) }}" method="POST">
                <div class="container">
                    <div class="row">
                        @csrf
                        @method('put')
                        <!-- Columna para los inputs -->
                        <div class="col-md-12">
                            <label for="basic-url" class="text-dark" style="font-size: 1rem;"><strong>Nombre:
                                </strong><span class="text-danger" style="font-size: 1.2rem;">*</span></label>
                            <div class="input-group mb-4">
                                <div class="input-group input-group-lg">
                                    {{-- como puedo ver este lo uso de referencia para aplicar los estilos que necesito de las validaciones --}}
                                    <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                                        aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg"
                                        name="nombre" value="{{$categoria->nombre}}">
                                    {{-- este mensaje de error es que hace que aparezcan el mensaje abajo asi que pendiente, entre comillas simples va la variable  --}}
                                    {{-- usamos el value="{{ old('nombre') }}" para que las variables se mantengan asi el modal se cierre --}}
                                    @error('nombre')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <!-- Columna para el textarea -->
                            <div class="col-md-12">
                                <label for="basic-url" class="text-dark rounded"
                                    style="font-size: 1rem;"><strong>Observaciones:</strong></label>
                                <div class="input-group h-100">
                                    <textarea name="descripcion" class="form-control" aria-label="With textarea"
                                        style="withd: 100%; height: 150%; resize: none;" value="{{$categoria->descripcion}}">{{$categoria->descripcion}}</textarea>
                                    <br><br><br><br>
                                </div>
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
        <a href="{{ route('categoria.index') }}" type="button" class="btn btn-outline-primary mx-2">
            Cancelar
        </a>
        <button type="submit" class="btn btn-primary text-gray">Guardar</button>
    </div>
    </form>
@endsection
