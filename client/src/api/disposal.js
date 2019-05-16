import request from '../common/request';

const prefix = '/disposal';

export function get(data) {
    return request({
        url: `${prefix}`,
        method: 'get',
        params: data
    })
}

export function getById(data) {
    return request({
        url: `${prefix}/get_by_id`,
        method: 'get',
        params: data
    })
}

export function update(data) {
    return request({
        url: `${prefix}`,
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

