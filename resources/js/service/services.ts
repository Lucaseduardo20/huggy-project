import {api} from './api'
import {Client} from "../type/client";
import {AxiosResponse} from "axios";

export const store = async (client: Client) => {
    return await api.post('/clients', client).then((res: AxiosResponse<any, any>) => {
        return res.data
    }).catch((err) => {
        console.log(err.response);
        return err.response
    })
}
