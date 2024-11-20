@extends('layouts.app')


@section('estilos')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
@endsection

@section('title', 'Nuevo Metodo de pago')

@section('contenido')
<h2 class="title-1 m-b-25">Métodos de Pago</h2>
{{-- boton del nuevo almacen --}}
<div style="display: flex; justify-content: flex-end;">
    <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#exampleModalRegistroMetodo">
      <i class="align-middle" data-feather="plus"></i> Nuevo Método de Pago
    </button>
  </div>















  <!-- Modal que da incio al registro de un nuevo metodo de pago -->
  <div class="modal fade" id="exampleModalRegistroMetodo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-2" id="exampleModalLabel">Nuevo Metodo de Pago</h1>
        </div>
        <div class="modal-body"  style="background-color: rgb(236, 236, 236)">
            {{-- aqui comienza el modal del registro de los metodos de pago --}}
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <label for="nombreMetPago" class="text-dark" style="font-size: 1.2rem;">
                      Método de Pago: <span class="text-danger" style="font-size: 1.2rem;">* </span></label>
                    <input type="text" name="nombreMetPago" id="nombreMetPago" maxlength="50" class="form-control" placeholder="">
                  </div>
                  <div class="col-md-6">
                    <label for="imageMetodo" class="text-dark" style="font-size: 1.2rem;">Selecciona una imagen: </label>
                    <input type="file" name="imageMetodo" id="imageMetodo" class="form-control" accept="image/*">
                  </div>
                </div>
                
                <div class="row mt-3">
                  <div class="col-md-6">
                    <label for="observacionesMetPago" class="text-dark" style="font-size: 1.2rem;">Observaciones:</label>
                    <textarea name="observacionesMetPago" id="observacionesMetPago" class="form-control" aria-label="With textarea" style="height: 100%; resize: none;"></textarea>
                  </div>
                  <div class="col-sm-12 col-md-6 d-flex align-items-start">
                    <div>
                      <label for="previewImage" class="text-dark" style="font-size: 1.2rem;" >Previsualización:</label>
                      <img id="previewImage" src="" alt="Previsualización de la imagen" 
                           style="max-width: 150px; height: auto; display: none; border: 1px solid #ccc; padding: 5px; margin-top: 8px;">
                    </div>
                  </div>
                </div>
            </div>
            <script>
              const imageInput = document.getElementById('imageMetodo');
              const previewImage = document.getElementById('previewImage');
            
              imageInput.addEventListener('change', function (event) {
                const file = event.target.files[0];
            
                if (file) {
                  const reader = new FileReader();
            
                  reader.onload = function (e) {
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
            </div>
            
        {{-- de aqui para arriba es el final del modal registro-metodos --}}
        <div class="modal-footer">
            <p class="card-text fs-4"> <strong>Los campos con </strong><span class="text-danger" style="font-size: 1.7rem;">* </span>
                <strong> son obligatorios</strong>
            </p>
            <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary text-gray">Guardar</button>
        </div>
      </div>
    </div>
  </div>
@endsection


{{-- utilidades
    plus<i class="align-middle" data-feather="grid"></i>
    
    --}}


{{-- AREAS DE  SCRIPT --}}
