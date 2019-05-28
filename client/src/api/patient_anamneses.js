import request from "../common/request";

const prefix = "/patient_anamnesis";
//既往史
export function getAnamneses(data) {
    return request({
        url: `${prefix}`,
        method: "get",
        params: data
    });
}

export function addAnamneses(data) {
    return request({
        url: `${prefix}`,
        method: "post",
        data: data
    });
}

export function delAnamneses(data) {
    return request({
        url: `${prefix}/:id`,
        method: "delete",
        params: data
    });
}
