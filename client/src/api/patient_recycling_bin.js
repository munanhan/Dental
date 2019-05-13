import request from '../common/request';

const prefix = '/patient_recycling_bin';

export function get(data) {
    return request({
        url: `${prefix}`,
        method: 'get',
        params: data
    })
}

export function reduction(id) {
    return request({
        url: `${prefix}/:id`,
        method: 'put',
        
    })
}

export function del(data) {
    return request({
        url: `${prefix}`,
        method: 'delete',
        params: data
    })
}
