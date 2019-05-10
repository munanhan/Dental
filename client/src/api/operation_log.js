import request from '../common/request';

const prefix = '/operation_log';

/*
  操作日志列表
*/
export function get(data) {
    return request({
        url: `${prefix}`,
        method: 'get',
        params: data
    })
}

//获取用户列表下拉
export function get_user_list() {
    return request({
        url: `${prefix}/get_user_list`,
        method: 'get',
    })
}

//获取模块下拉
export function get_module_list() {
    return request({
        url: `${prefix}/get_module_list`,
        method: 'get',
    })
}