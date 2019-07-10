import request from '../common/request';

const prefix = '/patients';
//传输数据

export function get(data) {
    return request({
        url: `${prefix}`,
        method: 'get',
        data: data
    })
};

export function store(data) {
    return request({
        url: `${prefix}`,
        method: 'post',
        data: data
    })
};

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
        method: 'put',
        data: data
    })
};
//获取病历号
// export function caseNo(data) {
//     return request({
//         url: `${prefix}/generate`,
//         method: 'get',
//         params: data
//     })
// }

//获取主治医师
// export function getAttendDoctor(data) {
//     return request({
//         url: `${prefix}/attend_doctor`,
//         method: 'get',
//         params: data
//     })
// }
export function searchAll(data) {
    return request({
        url: `${prefix}/search_by_name`,
        method: 'get',
        params: data
    })
}
//当前工作

export function todayWork(data) {
    return request({
        url: `${prefix}/today_work`,
        method: 'get',
        params: data
    })
}

//全部患者
export function index(data) {
    return request({
        url: `${prefix}/all_patient`,
        method: 'get',
        params: data
    })
}

//最近访问
export function recentVisit(data) {
    return request({
        url: `${prefix}/recent_visit`,
        method: 'get',
        params: data
    })
}

//患者信息
export function getPatientByID(data) {
    return request({
        url: `${prefix}/get_by_id`,
        method: 'get',
        params: data
    })
}

export function getPatientResource(data) {
    return request({
        url: `${prefix}/resource`,
        method: 'get',
        params: data
    })
}

//获取预约信息
export function appoint(data) {
    return request({
        url: `${prefix}/appoint`,
        method: 'get',
        params: data
    })
}

//获取就诊信息
export function treat(data) {
    return request({
        url: `${prefix}/treat`,
        method: 'get',
        params: data
    })
}




