@extends('layouts.app')

@section('content')

          <div class="row">
                <div class="col-sm-12 mx-auto">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>NOMBRE DE USUARIO</th>
                                <th>CORREO ELECTRÓNICO</th>
                                <th>TIPO</th>
                                <th>GENERADO</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->user_id }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td>@if($user->is_admin == 1)
                                    Administrador
                                    @else
                                    Visitante
                                    @endif
                                </td>
                                <td>{{ $user->created_at }}</td>
                                <td>
                                    <form action="{{ route('users.destroy', $user->user_id) }}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button
                                            type="submit"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('¿Desea eliminar?...')"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                                <td><button data-bs-toggle="modal" data-bs-target="#PasswordModal-{{ $user->user_id }}" id = 'btnPassword' class='btn btn-warning btn-sm'><i class="fas fa-key" aria-hidden="true" data-toggle="tooltip" data-placement="top" title='Establecer Contraseña de Accesso'></i></button>
                            
                                <div class="modal fade" id="PasswordModal-{{ $user->user_id }}" tabindex="-1" role="dialog" aria-labelledby="PasswordModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 class="modal-title" id="PasswordModalLabel">ESTABLECER CONTRASEÑA</h5> {{ $user->username }} ({{ $user->user_id }})
                                            </div>
                                            <div class="modal-body">
                                            <form id ="frmPassword" method="POST" action="{{ route('users.password')}}">
                                            @method('PATCH')
                                            @csrf
                                            <div class="row">
                                            <div class="col-sm-6">
                                                <label for="id_password">CONTRASEÑA</label>
                                                <input type="password" class="form-control form-control-sm" id="id_password" name = "password" maxlength="20" required>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="id_repeat_password">REPETIR CONTRASEÑA</label>
                                                <input type="password" class="form-control form-control-sm" id="id_reapeat_password" name = "repeat_password" maxlength="20" required>
                                            </div>
                                        </div>
                                        
                                        <hr>
                                        <input type="hidden" value="{{ $user->user_id }}" id = "id_user_password" name="user_password">
                                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i></button>   
                                    </form>
                                            <hr>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-info" data-bs-dismiss="modal"><i class="fas fa-times"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    </div> 

                            </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex">
                {{ $users->links() }}
            </div>
                </div>
            </div>
            <div class="row">
        <div class="col"><hr></div>
    </div>
    <div class="row justify-content-center">
              <div class="col text-center">
              <a href="{{route('register')}}" class="btn btn-primary btn-sm active" role="button" aria-pressed="true"><i class="fas fa-user-plus fa-2x"></i></i></i></a>
    </div>
   </div> 
        </div>


@endsection