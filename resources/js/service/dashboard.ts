import {api} from "./api";

export const getDashboard = async () => {
    return api.get('/dashboard/data').then((res) => {
        return res;
    }).catch((err) => {
        return err;
    })
}
