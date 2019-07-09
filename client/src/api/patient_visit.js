import request from '../common/request';

const prefix = '/patient_visits';

//患者访问信息

export function get(data) {
    return request({
        url: `${prefix}/get_by_id`,
        method: "get",
        params: data
    });
}

export function visitInfo(data) {
    return request({
        url: `${prefix}/visit_info`,
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

export function update(data) {
    return request({
        url: `${prefix}`,
        method: "put",
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