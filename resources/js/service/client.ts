import {api} from './api'
import {Client} from "../type/client";
import {AxiosResponse} from "axios";

export const store = async (client: Client) => {
    return await api.post('/clients', client).then((res: AxiosResponse<any, any>) => {
        return res
    }).catch((err) => {
        console.log(err.response);
        return err.response
    })
}

export const update = async (client: Client, id: number) => {
    return await api.patch(`/clients/${id}`, client).then((res: AxiosResponse<any, any>) => {
        return res
    }).catch((err) => {
        console.log(err.response);
        return err.response
    })
}
export const deleteClient = async (id: number) => {
    return await api.delete(`/clients/${id}`).then((res: AxiosResponse<any, any>) => {
        return res
    }).catch((err) => {
        console.log(err.response);
        return err.response
    })
}

export const getClients = async () => {
    return await api.get('/clients').then((res: AxiosResponse<any, any>) => {
        return res
    }).catch((err) => {
        console.log(err.response);
        return err.response
    })
}
