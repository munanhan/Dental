import request from '../common/request';

const prefix = '/appointment';

export function addAppointment(data) {
    return request({
        url: `${prefix}/add_appointment`,
        method: 'post',
        data: data
    })
}
export function getWeekAppointment(data) {
    return request({
        url: `${prefix}/getWeekAppointment`,
        method: 'post',
        data: data
    })
}
export function getMonthAppointment(data) {
    return request({
        url: `${prefix}/getMonthAppointment`,
        method: 'post',
        data: data
    })
}

export function getCaseNumber(data) {
    return request({
        url: `${prefix}/getCaseNumber`,
        method: 'get',
        data: data
    })
}
export function getTodayAppointment(data){
    return request({
        url:`${prefix}/getTodayAppointment`,
        method:'get',
        params:data,
    })
}
export function getByIdAppointment(data){
    return request({
        url:`${prefix}/getByIdAppointment`,
        method:'get',
        params:data,
    })
}
