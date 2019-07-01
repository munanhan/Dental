//咨询信息

import request from '../common/request';

const prefix = '/patient_consults';

//全部患者
export function get(data) {
    return request({
        url: `${prefix}`,
        method: "get",
        params: data
    });
}

//根据患者id取
export function getById(data) {
    return request({
        url: `${prefix}/show`,
        method: "get",
        params: data
    });
}

export function store(data) {
    return request({
        url: `${prefix}`,
        method: "post",
        data: data
    });
}

export function del(data) {
    return request({
        url: `${prefix}/:id`,
        method: "delete",
        params: data
    });
}

export function update(data) {
    return request({
        url: `${prefix}/:id`,
        method: "put",
        params: data
    });
}

/*
接诊医生
 */
export function receptionDoctor(data) {
    return request({
        url: `${prefix}/doctor_or_record`,
        method: "get",
        params: data
    });
}

/*
默认录入人
 */
export function defaultRecorder(data) {
    return request({
        url: `${prefix}/default_record`,
        method: "get",
        params: data
    });
}
