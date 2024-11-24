@extends('layouts.app')




@section('title', 'Mostrar el método de pago')


@section('contenido')
<h1>estoy mostrando</h1>
<div class="card">
    <div class="card-body">
        {{-- <form action="{{ route('metodo.store') }}" method="POST" enctype="multipart/form-data"> --}}
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <label for="nombreMetPago" class="text-dark" style="font-size: 1.2rem;">
                        Método de Pago:</label>
                    <input type="text" name="nombreMetPago" id="nombreMetPago" maxlength="50"
                        class="form-control" value="{{ $metPago->nombreMetPago }}">
                        @error('nombreMetPago')
                        <small> <span class="text-danger">{{$message}}</span></small>
                        @enderror
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <label for="observacionesMetPago" class="text-dark"
                        style="font-size: 1.2rem;">Observaciones:</label>
                    <textarea name="observacionesMetPago" id="observacionesMetPago" class="form-control" aria-label="With textarea"
                        style="height: 100%; resize: none;" value="{{ $metPago->observacionesMetPago }}">{{ $metPago->observacionesMetPago }}</textarea>
                </div>

            </div>
            <div class="row mt-3">
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="col-sm-12 col-md-6 d-flex align-items-start">
                            <div>
                                <label for="previewImage" class="text-dark"
                                    style="font-size: 1.2rem;">Visualización:</label>
                                    <br>
                                    <br>
                                <img src="{{ $metPago->imagenMetPago }}" alt="Previsualización de la imagen" width="150">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
    <div class="modal-footer">
        <a href="{{ route('metodo.index')}}" type="button" class="btn btn-outline-primary mt-3 mb-4 me-3">Cancelar</a>
    </div>
</form>
</div>
@endsection
