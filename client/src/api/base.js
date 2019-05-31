import request from "../common/request";

const prefix = "/";

export function login(data) {
    return request({
        url: `${prefix}login`,
        method: "post",
        data,
        //跳过自动刷新token
        skipAuth: true
    });
}

export function logout(data) {
    return request({
        url: `${prefix}logout`,
        method: 'put',
        data: data,
        //跳过自动刷新token
        skipAuth: true
    })
}
