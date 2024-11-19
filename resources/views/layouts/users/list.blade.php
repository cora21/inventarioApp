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
        <div class="card shadow-lg" style="width: 54rem;">
            <div class="card-body">
                <div>
                    <table class="table table-hover">
                        <thead>
                            <tr style="background-color: rgb(201, 201, 201); ">
                                <th style="border-radius: 15px 0px 0px 0px;" >Nombre</th>
                                <th>Apellido</th>
                                <th class="text-right">Correo</th>
                                <th class="text-right">Telefono</th>
                                <th class="text-right" style="border-radius: 0px 15px 0px 0px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($users as $user)
                            <tr>
                                <td>{{ $user->first_name }}</td>
                                <td>{{ $user->last_name}}</td>
                                <td class="text-right">{{ $user->email }}</td>
                                <td class="text-right">{{ $user->phone_number }}</td>
                                <td>
                                    <div class="table-data-feature">
                                        {{-- con estos can limito quien puede ser la vista dependiendo del rol --}}
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
                                    </div>
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
