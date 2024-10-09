import axios from 'axios';
let axiosInstance = axios.create({
    baseURL: "https://backend-teal-psi.vercel.app",
    headers: {
        'Content-Type': 'application/json',
        "Access-Control-Allow-Origin": "*",
        "Access-Control-Expose-Headers": "authorization",
        "Access-Control-Allow-Headers": "*"
    }
});

axiosInstance.interceptors.response.use(
    (response) => response,
    (error) => {
        if (error.response.status === 401) {
            localStorage.clear();
            alert("El usuario no se encuentra autenticado");
            window.location.href = "/login";
        }

        if (error.response.status === 404) {
            console.error('errorResponse', {
                'message': error.response.data.errors.message,
                'url': error.response.request.responseURL
            })
            alert("Ha ocurriido un error consultando el servicio: " + error.response.config.url +
                ', Por favor contacte con el administrador');
        }

        return Promise.reject(error);
    }

);

window.axios = axiosInstance;
