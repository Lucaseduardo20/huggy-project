import axios, {AxiosInstance} from "axios";

export const api: AxiosInstance = axios.create({
    baseURL: "https://8c9e-2804-1b1-f800-5f83-713f-e064-f80c-e8fd.ngrok-free.app/api/",
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
