import request from '../common/request';

const prefix = '/arrearage_statistics';

export function get(data) {
    return request({
        url: `${prefix}`,
        method: 'get',
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
