import request from "../common/request";

const prefix = "/patients_class";
//患者分类
export function Class(data) {
    return request({
        url: `${prefix}`,
        method: "get",
        params: data
    });
}

export function addClass(data) {
    return request({
        url: `${prefix}`,
        method: "post",
        data: data
    });
}

export function delClass(data) {
    return request({
        url: `${prefix}/:id`,
        method: "delete",
        params: data
    });
}
