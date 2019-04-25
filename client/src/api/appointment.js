import request from '../common/request';

const prefix = '/appointment';

export function addAppointment(data) {
    return request({
        url: `${prefix}/add_appointment`,
        method: 'post',
        data: data
    })
}