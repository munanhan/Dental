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
export function changeAppointmentStatus(data) {
    return request({
        url: `${prefix}/changeAppointmentStatus`,
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
export function getListAppointment(data){
    return request({
        url:`${prefix}/getListAppointment`,
        method:'get',
        params:data,
    })
}
export function getPatientByPhone(data){
    return request({
        url:`${prefix}/getPatientByPhone`,
        method:'get',
        params:data,
    })
}
export function attendDoctor(data){
    return request({
        url:`PatientController/attendDoctor`,
        method:'get',
        params:data,
    })
}

export function clinicPatientSource(data){
    return request({
        url:`${prefix}/clinicPatientSource`,
        method:'get',
        params:data,
    })
}
export function clinicVisitData(data){
    return request({
        url:`${prefix}/clinicVisitData`,
        method:'get',
        params:data,
    })
}
export function clinicAppointData(data){
    return request({
        url:`${prefix}/clinicAppointData`,
        method:'get',
        params:data,
    })
}
export function clinicAppointItemData(data){
    return request({
        url:`${prefix}/clinicAppointItemData`,
        method:'get',
        params:data,
    })
}
export function clinicAppointStatusData(data){
    return request({
        url:`${prefix}/clinicAppointStatusData`,
        method:'get',
        params:data,
    })
}