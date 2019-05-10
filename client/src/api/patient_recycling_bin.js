import request from '../common/request';

const prefix = '/patient_recycling_bin';

export function get(data) {
    return request({
        url: `${prefix}`,
        method: 'get',
        params: data
    })
}
