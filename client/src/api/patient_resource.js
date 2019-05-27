import request from '../common/request';

const prefix = '/patient_sources';


export function resources(data) {
    return request({
        url:`${prefix}`,
        method:'get',
        params: data
    })
}

export function addResource(data) {
    return request({
        url:`${prefix}`,
        method:'post',
        data: data
    })
}

export function delResource(data) {
    return request({
        url:`${prefix}/:id`,
        method:'delete',
        params: data
    })
}






