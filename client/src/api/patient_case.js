import request from '../common/request';

const prefix = '/patient_cases';

//病例信息

export function get(data) {
    return request({
        url: `${prefix}/get_by_id`,
        method: "get",
        params: data
    });
}