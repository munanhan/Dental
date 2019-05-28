import request from "../common/request";

const prefix = "/patient_teeth_habits";
//洁牙习惯
export function getTeethHabits(data) {
    return request({
        url: `${prefix}`,
        method: "get",
        params: data
    });
}

export function addTeethHabits(data) {
    return request({
        url: `${prefix}`,
        method: "post",
        data: data
    });
}

export function delTeethHabits(data) {
    return request({
        url: `${prefix}/:id`,
        method: "delete",
        params: data
    });
}
