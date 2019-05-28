import request from "../common/request";

const prefix = "/patient_Allergies";
//过敏史
export function getAllergy(data) {
    return request({
        url: `${prefix}`,
        method: "get",
        params: data
    });
}

export function addAllergy(data) {
    return request({
        url: `${prefix}`,
        method: "post",
        data: data
    });
}

export function delAllergy(data) {
    return request({
        url: `${prefix}/:id`,
        method: "delete",
        params: data
    });
}
