import request from '../common/request';

const prefix = '/patient_cases';

export function index(data) {
    return request({
        url: `${prefix}/get_medical`,
        method: "get",
        params: data
    });
}

export function show(data) {
    return request({
        url: `${prefix}/get_medical_by_id`,
        method: "get",
        params: data
    });
}