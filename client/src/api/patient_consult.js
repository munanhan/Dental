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
export function getByPatientId(data) {
    return request({
        url: `${prefix}/patient_id`,
        method: "get",
        params: data
    });
}

export function getById(data) {
    return request({
        url: `${prefix}/get_by_id`,
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
        url: `${prefix}`,
        method: "put",
        params: data
    });
}

/*
接诊医生
 */
export function consultInfo(data) {
    return request({
        url: `${prefix}/consult_info`,
        method: "get",
        params: data
    });
}






