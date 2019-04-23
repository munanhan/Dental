import request from '../common/request';

const prefix = '/';

export function login(data) {
    return request({
        url: `${prefix}/login`,
        method: 'post',
        params: data
    })
}
