import request from '../common/request';

const prefix = '/home';

export function get(data) {
    return request({
        url: `${prefix}/get`,
        method: 'get',
        params: data
    })
}
