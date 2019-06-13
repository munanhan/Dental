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
        url: `${prefix}/:id`,
        method: "delete",
        params: data
    });
}

export function update(data) {
    return request({
        url: `${prefix}`,
        method: 'put',
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

export function getAttendDoctor(data) {
    return request({
        url: `${prefix}/attend_doctor`,
        method: 'get',
        params: data
    })
}
export function searchAll(data) {
    return request({
        url: `${prefix}/searchAll`,
        method: 'get',
        params: data
    })
}
//当前工作

export function todayWork(data) {
    return request({
        url: `${prefix}/today_work`,
        method: 'get',
        params: data
    })
}

//全部患者
export function index(data) {
    return request({
        url: `${prefix}`,
        method: 'get',
        params: data
    })
}




