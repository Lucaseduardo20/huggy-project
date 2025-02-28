import {api} from './api'
import {Client} from "../type/client";
import {AxiosResponse} from "axios";

export const store = async (client: Client) => {
    return await api.post('client/store', client).then((res: AxiosResponse<any, any>) => {
        return res.data
    }).catch((err) => {
        console.log(err);
        return err.message
    })
}
