@extends('layouts.app')

@section('title', 'Registro de Almacen')

@section('contenido')
    <h4 class="card-title">Nuevo Almacén</h4>
    <p class="card-text">Aqui puedes registras los diferentes almacenes de tu empresa</p>


    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Registra nuevo almacén
      </button>

<div class="container center">
<!-- Button trigger modal -->

  <!-- Modal para registrar el almacen -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header no-border">
          <h1 class="modal-title fs-1 text-blue-200" id="exampleModalLabel">Nuevo Almacén</h1>
        </div>

        <div class="modal-body">
            <p class="card-text fs-4 text-dark">Aqui puedes registras los diferentes almacenes de tu empresa</p>
            <div class="mx-auto" style="width: 70%;">
                <div class="card">
                    <div class="card-body rounded shadow-lg">

                        <div class="container">
                            <div class="row">
                              <!-- Columna para los inputs -->
                              <div class="col-md-6">
                                <label for="basic-url" class="form-label text-dark"><strong>Nombre: </strong><span class="text-danger">*</span></label>
                                <div class="input-group mb-4">
                                    <div class="input-group input-group-lg">
                                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                                    </div>
                                </div>

                                <div class="input-group mb-4">
                                    <label for="basic-url" class="form-label"><strong>Dirección:</strong></label>
                                    <div class="input-group input-group-lg">
                                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                                    </div>
                                </div>
                              </div>

                              <!-- Columna para el textarea -->
                              <div class="col-md-6">
                                <label for="basic-url" class="form-label rounded"><strong>Observaciones:</strong></label>
                                <div class="input-group h-100">
                                    <textarea class="form-control" aria-label="With textarea" style="height: 90%; resize: none;"></textarea>
                                </div>
                              </div>
                            </div>
                          </div>


                    </div>
                </div>
            </div>


        </div>
        <div class="modal-footer">
        <p class="card-text fs-4"> <strong>Los campos con </strong><span class="text-danger">*</span> <strong> son obligatorios</strong></p>
            <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary text-gray">Guardar</button>
        </div>
      </div>
    </div>
  </div>
</div>







@endsection
