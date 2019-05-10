import request from '../common/request';

const prefix = '/patients';

export function addPatient(data) {
    return request({
        url: `${prefix}`,
        method: 'post',
        data: data
    })
}