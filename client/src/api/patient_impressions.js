import request from "../common/request";

const prefix = "/patient_impressions";
//过敏史
export function getImpressions(data) {
    return request({
        url: `${prefix}`,
        method: "get",
        params: data
    });
}

export function addImpressions(data) {
    return request({
        url: `${prefix}`,
        method: "post",
        data: data
    });
}

export function delImpressions(data) {
    return request({
        url: `${prefix}/:id`,
        method: "delete",
        params: data
    });
}
