import axios, {AxiosInstance} from "axios";

export const api: AxiosInstance = axios.create({
    baseURL: "http://localhost:8000/api",
    headers: {
        "Content-Type": "application/json"
    },
    withCredentials: true
});

api.interceptors.request.use(config => {
    const token: string = localStorage.getItem("token");
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
}, error => Promise.reject(error));
