import request from '../common/request';

const prefix = '/appointment';

export function addAppointment(data) {
    return request({
        url: `${prefix}/add_appointment`,
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