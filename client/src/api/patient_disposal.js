import request from  '../common/request'

const prefix='patient_disposal';

//患者处置记录信息

export function get(data) {
    return request({
        url: `${prefix}/get_by_id`,
        method: 'get',
        params: data
    })
}