import request from '../common/request';

const prefix = '/patient_recycling_bin';

export function get(data) {
    return request({
        url: `${prefix}`,
        method: 'get',
        params: data
    })
}

export function reduction(data) {
    return request({
        url: `${prefix}/:id`,
        method: 'put',
        params: data
    })
}

export function del(data) {
    return request({
        url: `${prefix}/:id`,
        method: 'delete',
        params: data
    })
}

export function delAll(data) {
    return request({
        url: `${prefix}`,
        method: 'post',
        data
    })
}