@extends('layouts.app')

@section('title', 'Login')

@section('extra_head')
    @vite(['resources/css/signin.css'])
@endsection

@section('content')
    <main class="form-signin">
        <form id="form-login">
            <img class="mb-4" src="{{ asset('logo-company.jpg') }}" alt="" width="72" height="57">
            <h1 class="h3 mb-3 fw-normal">Ingresar</h1>

            <div class="form-floating">
                <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com">
                <label for="email">Correo Electronico</label>
            </div>
            <div class="form-floating">
                <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                <label for="password">Clave</label>
            </div>

            <a href="javascript:void(0)" class="w-100 btn btn-lg btn-primary" onclick="loginUser()">Ingresar</a>
        </form>
        <a href="{{ route('register_user') }}" class="btn btn-link">Registrar Usuario</a>
    </main>
@endsection

@push('scripts')
    <script>
        const loginUser = (event) => {
            let email = document.getElementById('email').value;
            let password = document.getElementById('password').value;

            axios.post(`/auth/login`,{
                'email': email,
                'password': password
            })
                .then(function(response) {
                    localStorage.setItem('token',response.data.data.access_token);
                    window.location.href = "/validate";
                })
                .catch(function(error) {
                    alert("Ha ocurrido un error:" + error)
                    console.log('error', error);
                });
        }
    </script>
@endpush
