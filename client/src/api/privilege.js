import request from '../common/request';

const prefix = '/privilege';

export function add(data){
    return request({
        url: `${prefix}`,
        method: 'post',
        data: data
    });
}

export function get(data) {
    return request({
        url: `${prefix}`,
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

export function del(data) {
    return request({
        url: `${prefix}/:id`,
        method: 'delete',
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


//根据类型获取
export function getByType(data) {
    return request({
        url: `${prefix}/get_by_type`,
        method: 'get',
        params: data
    })
}

//获取当前用户的权限
export function getUserPrivilege(data){
    return request({
        url: `${prefix}/get_user_privilege`,
        method: 'get',
        params: data
    })
}

