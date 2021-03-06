import request from '../common/request';

const prefix = '/patient_order';


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