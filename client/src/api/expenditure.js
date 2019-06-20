import request from '../common/request';

const prefix = '/expenditure';

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

export function add(data){
    return request({
        url: `${prefix}`,
        method: 'post',
        data: data
    });
}

export function del(data) {
    return request({
        url: `${prefix}/:id`,
        method: 'delete',
        params: data
    })
}


export function exportData(data) {
    return request({
        url: `${prefix}/export`,
        method: 'get',
        params: data
    })
}

export function getSelect(data) {
    return request({
        url: `${prefix}/get_select`,
        method: 'get',
        params: data
    })
}