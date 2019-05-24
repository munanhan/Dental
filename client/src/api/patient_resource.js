import request from '../common/request';

const prefix = '/patient_sources';


export function resources(data) {
    return request({
        url:`${prefix}`,
        method:'get',
        params: data
    })
}


