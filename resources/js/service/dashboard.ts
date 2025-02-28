import {api} from "./api";

export const clientsByAge = async () => {
    return api.get('/dashboard/age').then((res) => {
        return res.data;
    }).catch((err) => {
        return err;
    })
}

export const clientsByCity = async () => {
    return api.get('/dashboard/city').then((res) => {
        return res.data;
    }).catch((err) => {
        return err;
    })
}
