@extends('layouts.app')

@section('title', 'Dashboard')


@section('content')
    <main class="dashboard">
        <h1>Dashboard Hedera</h1>
        <hr />

        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Cerrar
            Sesión</button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Advertencia</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ¿Desea cerrar la sesion?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        <a href="{{ route('logout') }}" class="btn btn-primary" onclick="logout()">Cerrar sesión</a>
                    </div>
                </div>
            </div>
        </div>

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button onclick="getListToken()" class="nav-link active" id="home-tab" data-bs-toggle="tab"
                    data-bs-target="#list-tokens" type="button" role="tab" aria-controls="home"
                    aria-selected="true">Listado de Tokens</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#form-token" type="button"
                    role="tab" aria-controls="profile" aria-selected="false">Crear Token</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="list-tokens" role="tabpanel" aria-labelledby="home-tab">
                <table class="table table-hover table-bordered" id="table-list-token">
                    <thead class="table-primary">
                        <th>TokenId</th>
                        <th>Nombre</th>
                        <th>Suministro Inicial</th>
                    </thead>
                    <tbody id="tbody-list-token">

                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="form-token" role="tabpanel" aria-labelledby="profile-tab">
                <h2>Crear nuevo token</h2>
                <form id="form-token" style="width:50%; margin: 0 auto;">
                    <div class="form-group">
                        <label for="name"><b>Nombre</b></label>
                        <input type="text" class="form-control" id="name" placeholder="JONN">
                    </div>
                    <div class="form-group">
                        <label for="symbol"><b>Simbolo</b></label>
                        <input type="text" class="form-control" id="symbol" placeholder="SWQ">
                    </div>
                    <div class="form-group">
                        <label for="supply_initial"><b>Suministro inicial</b></label>
                        <input type="number" class="form-control" id="supply_initial">
                    </div>
                    <br />
                    <a href="javascript:void(0)" class="btn btn-primary" onclick="registerToken()">Guardar Token</a>
                    <br />
                    <div class="text-center" id="spinner-custom">

                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        const logout = () => {
            localStorage.clear();
        }
        const registerToken = (event) => {

            document.getElementById('spinner-custom').innerHTML = `
                <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
            `;
            axios.post(`/hedera/create-token-hedera`, {
                    "name": document.getElementById('name').value,
                    "symbol": document.getElementById('symbol').value,
                    "supply_initial": document.getElementById('supply_initial').value
                }, {
                    'headers': {
                        'Authorization': 'Bearer ' + localStorage.getItem('token')
                    }
                })
                .then(function(response) {
                    if (response.data.code == '201') {
                        document.getElementById('spinner-custom').innerHTML = '';
                        alert('Se ha creado el token de forma exitosa');
                        getListToken();
                    }

                    console.log('res', response);
                })
                .catch(function(error) {
                    console.log('error', error);
                });
        }

        const getListToken = () => {
            document.getElementById('tbody-list-token').innerHTML = `
                <div class="spinner-border m-5" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <strong>Loading...</strong>
            `;
            axios.get(`/hedera/list-tokens`, {
                    'headers': {
                        'Authorization': 'Bearer ' + localStorage.getItem('token')
                    }
                })
                .then(function(response) {
                    let data = response.data.data;
                    let html = '';
                    for (item in data) {
                        html += `
                        <tr>
                            <td>${data[item].id}</td>
                            <td>${data[item].name}</td>
                            <td>${data[item].totalSupply}</td>
                        </tr>`;
                    }
                    document.getElementById('tbody-list-token').innerHTML = html;
                    console.log('res', response);
                })
                .catch(function(error) {
                    console.log('error', error);
                });
        }

        window.onload = getListToken;
    </script>
@endpush
