import request from "../common/request";

const prefix = "/base_demands";
//基本需求
export function get(data) {
    return request({
        url: `${prefix}`,
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
