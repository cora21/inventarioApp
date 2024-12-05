{{-- @extends('layouts.dashboard') --}}
@extends('layouts.app')


@section('title', 'Listado de los Usuarios')
@section('page')
    @php $currentPage = 'users' @endphp
@endsection

@section('contenido')

    <div class="row">
        <div class="col-lg-12">
            <h2 class="title-1 m-b-25">Listado de Usuarios</h2>
            <div class="card shadow-lg">
                <div class="card-body">
                    <div>
                        <table class="table table-hover response">
                            <thead>
                                <tr style="background-color: rgb(184, 182, 182); ">
                                    <th style="border-radius: 15px 0px 0px 0px;">Nombre</th>
                                    <th>Apellido</th>
                                    <th class="text-right">Correo</th>
                                    <th class="text-right">Telefono</th>
                                    <th class="text-right" style="border-radius: 0px 15px 0px 0px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td  class="border">{{ $user->first_name }}</td>
                                        <td  class="border">{{ $user->last_name }}</td>
                                        <td class="text-right border">{{ $user->email }}</td>
                                        <td class="text-right border">{{ $user->phone_number }}</td>
                                        <td class="border">
                                            <a class="btn btn-primary dropdown-toggle d-none d-sm-inline-block"
                                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <span class="text-light">Acciones</span>
                                            </a>
                                            @can('users.show')
                                                <div class="dropdown-menu dropdown-menu-tod">
                                                    <div class="dropdown-item text-center">
                                                        <a href="{{ route('users.show', $user->id) }}"
                                                            class="btn btn-primary w-100 d-flex align-items-center justify-content-center">
                                                            <i data-feather="eye" class="me-2"></i> <span>Ver</span>
                                                        </a>
                                                    </div>
                                                @endcan


                                                @can('users.edit')
                                                    <div class="dropdown-item text-center">
                                                        <a href="{{ route('users.edit', $user->id) }}"
                                                            class="btn btn-success w-100 d-flex align-items-center justify-content-center">
                                                            <i data-feather="edit-2" class="me-2"></i> <span>Editar</span>
                                                        </a>
                                                    </div>
                                                @endcan
                                                @can('users.destroy')
                                                <div class="dropdown-item text-center">
                                                        <form method="POST" action="{{ route('users.destroy', $user->id) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <a class="btn btn-danger w-100 d-flex align-items-center justify-content-center">
                                                                <i data-feather="trash" class="me-2"></i>
                                                                <span>Eliminar</span>
                                                            </a>
                                                        </form>
                                                    @endcan
                                                </div>
                                            </div>





                                            {{-- <div class="table-data-feature">

                                        @can('users.show')
                                        <a href="{{ route('users.show', $user->id) }}" class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="View">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        @endcan

                                        @can('users.edit')
                                        <a href="{{ route('users.edit', $user->id) }}" class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
                                            <i class="zmdi zmdi-edit"></i>
                                        </a>
                                        @endcan


                                        @can('users.destroy')
                                        <form method="POST" action="{{ route('users.destroy', $user->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
                                                <i class="zmdi zmdi-delete"></i>
                                            </button>
                                        </form>
                                        @endcan
                                    </div> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
