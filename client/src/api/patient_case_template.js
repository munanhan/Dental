import request from '../common/request';

const prefix = '/patient_cases';

//获取所有
export function index(data) {
    return request({
        url: `${prefix}/get_template`,
        method: "get",
        params: data
    });
}
//根据id获取
export function show(data) {
    return request({
        url: `${prefix}/get_template_by_id`,
        method: "get",
        params: data
    });
}
//
// export function show(data) {
//     return request({
//         url: `${prefix}/get_template_by_id`,
//         method: "get",
//         params: data
//     });
// }
