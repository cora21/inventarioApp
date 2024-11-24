@extends('layouts.app')




@section('title', 'Editar método de pago')

@section('contenido')
    <h1>estoy editando</h1>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('metodoPago.update', $metPago->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <label for="nombreMetPago" class="text-dark" style="font-size: 1.2rem;">
                            Método de Pago: <span class="text-danger" style="font-size: 1.2rem;">*</span>
                        </label>
                        <input type="text" name="nombreMetPago" id="nombreMetPago" maxlength="50" class="form-control"
                            value="{{ $metPago->nombreMetPago }}">
                            @error('nombreMetPago')
                            <small> <span class="text-danger">{{$message}}</span></small>
                            @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="imageMetodo" class="text-dark" style="font-size: 1.2rem;">Selecciona una
                            imagen: </label>
                        <input type="file" name="imageMetodo" id="imageMetodo" class="form-control" accept="image/*">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="observacionesMetPago" class="text-dark"
                            style="font-size: 1.2rem;">Observaciones:</label>
                        <textarea name="observacionesMetPago" id="observacionesMetPago" class="form-control" aria-label="With textarea"
                            style="height: 100%; resize: none;">{{ $metPago->observacionesMetPago }}</textarea>
                    </div>
                    <div class="col-sm-12 col-md-6 d-flex align-items-start">
                        <div>
                            <label for="previewImage" class="text-dark" style="font-size: 1.2rem;">Previsualización:</label>
                            <img id="previewImage" src="{{ $metPago->imagenMetPago }}" alt="Previsualización de la imagen"
                                style="max-width: 150px; height: auto; display: block; border: 1px solid #ccc; padding: 5px; margin-top: 8px;">
                        </div>
                    </div>
                </div>
                <div>

                <div class="modal-footer">
                    <a href="{{route('metodo.index')}}" type="button" class="btn btn-outline-success mx-1">Cancelar</a>
                    <button type="submit" class="btn btn-success text-gray mx-1">Guardar</button>
                </div>
            </form>
        </div>
        <script>
            const imageInput = document.getElementById('imageMetodo');
            const previewImage = document.getElementById('previewImage');

            imageInput.addEventListener('change', function(event) {
                const file = event.target.files[0];

                if (file) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        previewImage.style.display = 'block'; // Muestra la imagen
                    };

                    reader.readAsDataURL(file); // Lee el archivo y genera una URL base64
                } else {
                    previewImage.style.display = 'none'; // Oculta la imagen si no hay archivo seleccionado
                }
            });
        </script>
        <br><br>
    </div>
@endsection
