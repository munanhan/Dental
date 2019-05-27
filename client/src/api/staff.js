import request from '../common/request';

const prefix = '/staff';


export function get(data){
    return request({
        url: `${prefix}/list`,
        method: 'get',
        params: data
    })
}

export function getByID(data){
    return request({
        url: `${prefix}/get_by_id`,
        method: 'post',
        data: data
    })
}

export function add(data){
    return request({
        url: `${prefix}/add`,
        method: 'post',
        data: data
    });
}


export function changeUserPasswd(data){
    return request({
        url: `${prefix}/change_user_passwd`,
        method: 'post',
        data: data
    });
}


export function getAll(data){
    return request({
        url: `${prefix}/all_list`,
        method: 'get',
        params: data
    })
}

//获取当前用户的权限
export function getUserPermission(data){
    return request({
        url: `${prefix}/get_user_permission`,
        method: 'get',
        params: data
    })
}

//更新用户自己的头像
export function updateUserAvatar(data){
    return request({
        url: `${prefix}/update_avatar`,
        method: 'post',
        data: data
    });
}

//更新用户的头像（管理员）
export function changeUserAvatar(data){
    return request({
        url: `${prefix}/change_user_avatar`,
        method: 'post',
        data: data
    });
}

//获取员工列表
export function user_list(data){
    return request({
        url: `${prefix}/user_list`,
        method: 'get',
        params: data
    })
}

//获取员工列表
export function get_role(data){
    return request({
        url: `${prefix}/get_role`,
        method: 'get',
        params: data
    })
}

//删除用户
export function del(data) {
    return request({
        url: `${prefix}/:id`,
        method: 'delete',
        params: data
    })
}
//修改密码
export function changePassword(data) {
    return request({
        url: `${prefix}/update_password`,
        method: 'post',
        data: data
    })
}
 
//修改用户信息

export function edit(data){
    return request({
        url: `${prefix}`,
        method: 'put',
        params: data
    });
}

//根据id获取
export function getById(data) {
    return request({
        url: `${prefix}/get_by_id`,
        method: 'get',
        params: data
    })
}
