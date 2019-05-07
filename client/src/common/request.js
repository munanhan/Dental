import axios from "axios";
import { Notification } from "element-ui";
import { setCookie, getCookie } from "./util";

let instance = null;

//development模式下使用
try {
    instance = axios.create({
        baseURL: apiBaseURL, // api的base_url
        timeout: 6000, // 请求超时时间
        withCredentials: true //允许携带cookie
    });
} catch (e) {
    instance = axios.create({
        baseURL: "/api", // api的base_url
        timeout: 6000 // 请求超时时间
        // withCredentials: true, //允许携带cookie
    });
}

// const instance = axios.create({
//     baseURL: "/api", // api的base_url
//     timeout: 6000, // 请求超时时间
//     // withCredentials: true, //允许携带cookie
// });

let oauthToken = getCookie("token");

// state.token = value.token;
// state.refreshToke = value.refreshToke;

//检查token是否过期
const repeatRequest = async (refresh_token, config) => {
    let result = {
        error: 0,
        data: {}
    };

    try {
        let rdata = (await axios.post(`/api/refreshment`, { refresh_token }))
                .data,
            ntoken = "",
            nRefToken = "";

        if (rdata.code == 200) {
            ntoken = rdata.data.token_type + " " + rdata.data.access_token;
            nRefToken = rdata.data.refresh_token;

            oauthToken = ntoken;

            setCookie("token", ntoken, rdata.data.expires_in * 1000);
            setCookie("refresh_token", nRefToken, rdata.data.expires_in * 1000);

            config.headers.Authorization = ntoken;

            let resData = (await axios.request(config)).data;

            result.data = resData;
        } else {
            //设置 -1 是错误
            result["error"] = -1;
        }
    } catch (e) {
        //设置 -1 是错误
        result["error"] = -1;
    }

    return result;
};

const rejectParams = (url, data) => {
    let complieUrl = url;

    for (var key in data) {
        if (RegExp(":" + key).test(complieUrl)) {
            url.replace(":" + key, data[key]);

            delete data[key];
        }
    }

    return complieUrl;
};

// request拦截器
// 默认是json格式的
instance.interceptors.request.use(
    config => {
        // console.log(proxy);

        if (
            config.method.toLocaleUpperCase() == "GET" ||
            config.method.toLocaleUpperCase() == "DELETE"
        ) {
            config.params = config.params || {};
            config.params["_d"] = Date.now();
        }

        config.url = rejectParams(config.url, config.params || config.data);

        //设置头
        if (oauthToken) {
            config.headers.Authorization = oauthToken;
        }

        //set 默认值
        return config;
    },
    error => ({
        code: 404,
        msg: error.message
    })
);

//刷新页面
let refreshPage = () => {
    //与服务器连接已经断开，6秒后自动刷新页面重连
    Notification.error({
        title: "错误",
        message: "系统已登出，6秒后自动刷新页面.",
        duration: 0 //设置不会自动关闭
    });

    setTimeout(() => {
        //重新刷新页面
        window.location && window.location.reload();
    }, 6e3);
};

// respone拦截器
instance.interceptors.response.use(
    response => {
        const resData = response.data;
        return resData;
    },
    error => {
        let res = error.response;

        // debugger

        //检测token,同时检测是否要跳过
        if (res.status == 401) {
            //token已经过期了
            let refreshToken = getCookie("refresh_token");

            if (refreshToken) {
                //尝试重发请求
                let result = repeatRequest(refreshToken, res.config);

                if (result.error) {
                    //刷新页面
                    refreshPage();
                } else {
                    resData = result.data;
                    
                    return resData;
                }
            } else {
                return {
                    code: 401,
                    data: {}
                };
            }
        } else {
            return Promise.reject(error);
        }
    }
);

export default instance;
