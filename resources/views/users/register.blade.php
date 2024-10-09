@extends('layouts.app')

@section('title', 'Registrar usuario')

@section('extra_head')
    @vite(['resources/css/signin.css'])
@endsection

@section('content')
    <main class="form-signin">
        <h1>Registro de usuario</h1>
        <form id="form-register">
            <div class="form-group">
                <label for="email">Correo Electronico</label>
                <input type="email" class="form-control" id="email" placeholder="j@gmail.com">
            </div>
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" class="form-control" id="name" placeholder="Jonh Doe">
            </div>
            <div class="form-group">
                <label for="password">Clave</label>
                <input type="password" class="form-control" id="password">
            </div>

            <a href="javascript:void(0)" class="w-100 btn btn-lg btn-primary" onclick="registerUser()">Ingresar</a>
        </form>
        <a href="{{ route('login') }}" class="btn btn-link">Iniciar Sesion</a>
    </main>
@endsection

@push('scripts')
    <script>
        const registerUser = (event) => {
            axios.post(`/users/register`, {
                    "email": document.getElementById("email").value,
                    "name": document.getElementById("name").value,
                    "password": document.getElementById("password").value
                })
                .then(function(response) {
                    console.log('d',response);
                    if (response.data.code == '201') {
                        alert("Se ha creado el usuario con exito.");
                        window.location.href = "/login";
                    } else {
                        alert("Error al guardar datos. Por favor verifique el formulario")
                    }
                })
                .catch(function(error) {
                    alert("Ha ocurrido un error al crear el usuario.");
                    console.log('error', error);
                });
        }
    </script>
@endpush
