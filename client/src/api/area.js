import request from '../common/request';

const prefix = '/areas';


export function get(data) {
    return request({
        url: `${prefix}/province`,
        method: 'get',
        params: data
    })
}

//根据id获取
export function getById(data) {
    return request({
        url: `${prefix}/get_by_id`,
        method: 'get',
        params: data
    })
}
