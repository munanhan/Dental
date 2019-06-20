import request from '../common/request';

const prefix = '/recon_calendar';

export function get(data) {
    return request({
        url: `${prefix}`,
        method: 'get',
        params: data
    })
}
