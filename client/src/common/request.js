import axios from "axios";
import { Notification } from "element-ui";
import { setCookie, getCookie } from "./util";

let instance = null,
    refreshTokenUrl = "/api/refreshment",
    oauthToken = getCookie("token");

//development模式下使用
try {
    refreshTokenUrl = apiBaseURL + refreshTokenUrl;

    instance = axios.create({
        baseURL: `${apiBaseURL}/api`, // api的base_url
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

//检查token是否过期
const repeatRequest = async (refresh_token, config) => {
    let result = {
        error: 0,
        data: {}
    };

    try {
        let res = await axios.post(refreshTokenUrl, { refresh_token }),
            rdata = res.data,
            ntoken = "",
            nRefToken = "";

        if (res.status == 200) {
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

        oauthToken = getCookie("token");

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
    // //如果当前的页面已经是登录页面，就不操作了
    // if (window.location.pathname == "/login") {
    //     return;
    // }else

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

        //织入成功状态码
        resData.code = response.status;
        return resData;
    },
    async error => {
        let res = error.response,
            result = {
                code: res.status,
                data: res.data.data,
                msg: res.data.msg
            },
            skipAuth = !!res.config.skipAuth,
            routerUse = !!res.config.routerUse;

        //检测token,同时检测是否要跳过
        //同时检查是不是要忽略刷新token的环节
        if (res.status == 401 && !skipAuth) {
            //token已经过期了
            let refreshToken = getCookie("refresh_token");

            if (refreshToken) {
                //尝试重发请求
                let reRes = await repeatRequest(refreshToken, res.config);

                if (reRes.error) {
                    //刷新页面，如果该接口是路由控制的，则不要继续刷新页面，避免一直刷新页面，路由会控制跳转
                    !routerUse && refreshPage();
                } else {
                    result.data = reRes.data.data;
                    result.msg = reRes.data.msg;
                }
            } else {
                //刷新页面，如果该接口是路由控制的，则不要继续刷新页面，避免一直刷新页面，路由会控制跳转
                !routerUse && refreshPage();
            }
        }

        return result;
    }
);

export default instance;
