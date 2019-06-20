import request from '../common/request';

const prefix = '/flow_sheet';

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

export function getSelect(data) {
    return request({
        url: `${prefix}/get_select`,
        method: 'get',
        params: data
    })
}