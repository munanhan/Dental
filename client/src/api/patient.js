import request from '../common/request';

const prefix = '/patients';
//传输数据

export function get(data) {
    return request({
        url: `${prefix}`,
        method: 'get',
        data: data
    })
};

export function store(data) {
    return request({
        url: `${prefix}`,
        method: 'post',
        data: data
    })
};

export function del(data) {
    return request({
        url: `${prefix}`,
        method: 'delete',
        data: data
    })
};

export function update(data) {
    return request({
        url: `${prefix}`,
        method: 'post',
        data: data
    })
};
//获取病历号
export function caseNo(data) {
    return request({
        url: `${prefix}/generate`,
        method: 'get',
        params: data
    })
}
//配置项
export function configData(data) {
    return request({
        url: `${prefix}/resource`,
        method: 'get',
        params: data
    })
}




