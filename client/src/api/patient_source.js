import request from '../common/request';

const prefix = '/patient_sources';


export function get(data) {
    return request({
        url:`${prefix}`,
        method:'get',
        params: data
    })
}

export function store(data) {
    return request({
        url:`${prefix}`,
        method:'post',
        data: data
    })
}

export function del(data) {
    return request({
        url:`${prefix}/:id`,
        method:'delete',
        params: data
    })
}

export function update(data) {
    return request({
        url:`${prefix}`,
        method:'put',
        params: data
    })
}






