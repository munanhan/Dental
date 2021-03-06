import Vue from "vue";
import VueRouter from "vue-router";
import store from "../store";
//组件模块登记
import components from "./components";
import { Loading } from "element-ui";

//因为全局路由守卫不能获取this，这里直接使用方法来获取是否登录
import { getUserInfo } from "../api/user";
import { getUserPrivilege } from '../api/privilege';


Vue.use(VueRouter);

//基础的路由
const routes = [
    {
        //登陆
        path: "/login",
        component: () => import("@views/login"),
        meta: {
            name: "登录"
        }
    },
    // {
    //     path: "/",
    //     component: () => import("@views/layout/Layout"),
    //     redirect: "/home",

    //     children: [
    //         {
    //             path: "home",
    //             component: () => import("@views/home/Index"),
    //             meta: {
    //                 name: "首页",
    //                 icon: "list-alt"
    //             }
    //         }
    //     ]
    // },
    {
        path: "/error",
        component: () => import("@views/error/Error"),
        meta: {
            notAuth: true
        }
    }
    //去除404页面，等待登陆后自动添加，未登录一直跳登录页面
    // {
    //     path: "/404",
    //     component: () => import("@views/error/NotFound"),
    //     meta: {
    //         notAuth: true
    //     }
    // }
];

//获取菜单按钮功能
//使用的数组一定要保持顺序
const getMenuData = data => {
    let quickTarget = {},
        //做多份，防止menu里面过多的数据，用于处理路由的
        routerQuickTarget = {},
        subMenu = {},
        menu = [
            // {
            //     url: "/home",
            //     name: "首页",
            //     icon: "fa fa-list-alt"
            // }
        ],
        routerArr = [];

    for (var i = 0; i < data.length; i++) {
        var item = data[i];

        if (item.p_type == 0) {
            //菜单
            quickTarget[item.id] = {
                url: item.url,
                name: item.p_name,
                icon: item.p_icon,
                parent_id: item.parent_id,
                isDialog: false //不是弹窗
            };

            //处理路由的 -------------------------------------
            routerQuickTarget[item.id] = {
                path: item.url,
                meta: {
                    name: item.p_name
                }
            };

            //普通菜单
            if (item.parent_id == 0) {
                //父
                routerQuickTarget[item.id]["component"] = resolve =>
                    require.ensure([], () =>
                        resolve(require("@views/layout/Layout"))
                    );

                //如果父组件有个组件的话，直接注入当中
                if (item.p_component) {
                    routerQuickTarget[item.id]["redirect"] = `${item.url}`;

                    routerQuickTarget[item.id].path = "";

                    var childItem = {
                        path: item.url,
                        meta: [{ name: item.p_name }],
                        component: components[item.p_component]
                    };

                    routerQuickTarget[item.id].children = [childItem];
                } else {
                    routerQuickTarget[item.id]["redirect"] = `${
                        item.url
                    }/index`;
                }
            } else {
                //子
                if (item.p_component) {
                    //如果子页面注册了组件，表示这个是个功能页面
                    //无法使用webpage的import的预编译,所以要预先定义组件列表
                    routerQuickTarget[item.id]["component"] =
                        components[item.p_component];
                }
            }
        } else if (item.p_type == 1) {
            //弹窗的菜单

            //菜单
            quickTarget[item.id] = {
                url: item.url,
                name: item.p_name,
                icon: item.p_icon,
                parent_id: item.parent_id,
                component: components[item.p_component],
                isDialog: true //是弹窗
            };
        } else if (item.p_type == 2) {
            //功能
            subMenu[item["p_act_name"]] = true;
        }
    }

    for (var key in quickTarget) {
        var item = quickTarget[key],
            parent_id = item.parent_id,
            routerItem = routerQuickTarget[key];

        if (item.isDialog) {
            if (parent_id == 0) {
                //处理dialog
                menu.push(item);
            } else {
                //处理菜单关联的子
                quickTarget[parent_id].children =
                    quickTarget[parent_id].children || [];
                quickTarget[parent_id].children.push(item);
            }
        } else {
            //处理普通的菜单
            if (item.parent_id == 0) {
                menu.push(item);

                //追加父路由
                routerArr.push(routerItem);
            } else if (parent_id != 0 && quickTarget[parent_id]) {
                //处理菜单关联的子
                quickTarget[parent_id].children =
                    quickTarget[parent_id].children || [];
                quickTarget[parent_id].children.push(item);

                //路由------------------------------------------
                routerQuickTarget[parent_id].children =
                    routerQuickTarget[parent_id].children || [];
                routerQuickTarget[parent_id].children.push(routerItem);

                //处理子路由
                if (parent_id != 0) {
                    //处理面包屑
                    var parentItem = routerQuickTarget[parent_id];
                    routerItem.meta.paths = [
                        ...(parentItem.meta.paths || []),
                        {
                            name: parentItem.meta.name
                        }
                    ];

                    //处理子路由
                    routerItem.path = routerItem.path.replace(
                        parentItem.path + "/",
                        ""
                    );
                }
            }

            //---------------------------------------------
        }
    }

    //最后追加404页面
    routerArr.push({
        path: "*",
        component: () => import("@views/error/NotFound"),
        meta: {
            notAuth: true
        }
    });

    return {
        subMenu,
        menu,
        routerArr
    };
};

//生成动态菜单
const genRoute = async (router, store) => {
    let suceess = true;
    try {
        //开启------------------
        //同步获取数据，锁死整个页面
        let resp = await getUserPrivilege(),
            pdata = resp.data;
        //-----------------------------

        // let resp = { code: 200 },
        //     pdata = [
        //         {
        //             id: 1,
        //             parent_id: 0,
        //             url: "/patient",
        //             p_type: 0,
        //             p_name: "患者",
        //             p_icon: "fa fa-user",
        //             p_component: "/patient/Index",
        //             api: ""
        //         },
        //         {
        //             id: 2,
        //             parent_id: 0,
        //             url: "/appointment",
        //             p_type: 0,
        //             p_name: "预约",
        //             p_icon: "fa fa-calendar-alt",
        //             p_component: "/appointment/Index",
        //             api: ""
        //         },
        //         {
        //             id: 3,
        //             parent_id: 0,
        //             url: "/communication",
        //             p_type: 0,
        //             p_name: "沟通",
        //             p_icon: "fa fa-play-circle",
        //             p_component: "/communication/Index",
        //             api: ""
        //         },
        //         {
        //             id: 4,
        //             parent_id: 0,
        //             url: "/statistics",
        //             p_type: 0,
        //             p_name: "统计",
        //             p_icon: "fa fa-calculator",
        //             p_component: "/statistics/Index",
        //             api: ""
        //         },
        //         // {
        //         //     id: 5,
        //         //     parent_id: 0,
        //         //     url: "/shop",
        //         //     p_type: 0,
        //         //     p_name: "商城",
        //         //     p_icon: "fa fa-shopping-cart",
        //         //     p_component: "/shop/Index",
        //         //     api: ""
        //         // },
        //         {
        //             id: 6,
        //             parent_id: 0,
        //             url: "/setting",
        //             p_type: 0,
        //             p_name: "管理",
        //             p_icon: "fa fa-user-cog",
        //             p_component: "/setting/Index",
        //             api: ""
        //         },

        //         {
        //             id: 7,
        //             parent_id: 0,
        //             p_name: "更多",
        //             p_icon: "fa fa-window-restore",
        //             api: "",
        //             p_type: 0,
        //             url: ""
        //         },

        //         // {
        //         //     id: 7,
        //         //     parent_id: 6,
        //         //     url: "/custom_service",
        //         //     p_type: 0,
        //         //     p_name: "客服",
        //         //     p_icon: "fa fa-user-clock",
        //         //     p_component: "/custom_service/Index",
        //         //     api: ""
        //         // },
        //         // {
        //         //     id: 8,
        //         //     parent_id: 6,
        //         //     url: "/warehouse",
        //         //     p_type: 0,
        //         //     p_name: "库房",
        //         //     p_icon: "fa fa-warehouse",
        //         //     p_component: "/warehouse/Index",
        //         //     api: ""
        //         // },
        //         {
        //             id: 9,
        //             parent_id: 7,
        //             url: "/return_visit",
        //             p_type: 0,
        //             p_name: "回访",
        //             p_icon: "fa fa-phone-volume",
        //             p_component: "/return_visit/Index",
        //             api: ""
        //         },
        //         // {
        //         //     id: 10,
        //         //     parent_id: 6,
        //         //     url: "/message",
        //         //     p_type: 0,
        //         //     p_name: "短信",
        //         //     p_icon: "fa fa-envelope",
        //         //     p_component: "/message/Index",
        //         //     api: ""
        //         // },
        //         {
        //             id: 11,
        //             parent_id: 7,
        //             url: "/inquiry",
        //             p_type: 1,
        //             p_name: "问诊",
        //             p_icon: "fa fa-stethoscope",
        //             p_component: "/inquiry/Index",
        //             api: ""
        //         },
        //         // {
        //         //     id: 12,
        //         //     parent_id: 6,
        //         //     url: "/micro_website",
        //         //     p_type: 0,
        //         //     p_name: "微官网",
        //         //     p_icon: "fa fa-university",
        //         //     p_component: "/micro_website/Index",
        //         //     api: ""
        //         // },
        //         {
        //             id: 13,
        //             parent_id: 7,
        //             url: "/expenditure",
        //             p_type: 0,
        //             p_name: "支出",
        //             p_icon: "fa fa-money-check-alt",
        //             p_component: "/expenditure/Index",
        //             api: ""
        //         },
        //         {
        //             id: 14,
        //             parent_id: 7,
        //             url: "/disinfect",
        //             p_type: 0,
        //             p_name: "消毒",
        //             p_icon: "fa fa-recycle",
        //             p_component: "/disinfect/Index",
        //             api: ""
        //         },
        //         {
        //             id: 15,
        //             parent_id: 7,
        //             url: "/attendance",
        //             p_type: 0,
        //             p_name: "考勤",
        //             p_icon: "fa fa-calendar-alt",
        //             p_component: "/attendance/Index",
        //             api: ""
        //         },
        //         {
        //             id: 16,
        //             parent_id: 7,
        //             url: "/recovery",
        //             p_type: 0,
        //             p_name: "回收",
        //             p_icon: "fa fa-box-open",
        //             p_component: "/recovery/Index",
        //             api: ""
        //         }
        //         // {
        //         //     id: 17,
        //         //     parent_id: 6,
        //         //     url: "/marketing",
        //         //     p_type: 0,
        //         //     p_name: "营销",
        //         //     p_icon: "fa fa-pen-nib",
        //         //     p_component: "/marketing/Index",
        //         //     api: ""
        //         // },
        //         // {
        //         //     id: 18,
        //         //     parent_id: 6,
        //         //     url: "/setting",
        //         //     p_type: 0,
        //         //     p_name: "管理",
        //         //     p_icon: "fa fa-user-cog",
        //         //     p_component: "/setting/Index",
        //         //     api: ""
        //         // }
        //     ];

        if (resp.code == 200) {
            let mdata = getMenuData(pdata, menu, subMenu),
                { menu, subMenu, routerArr } = mdata;

            store.commit("setMenu", menu);
            store.commit("setSubMenu", subMenu);

            router.addRoutes(routerArr);

            // router.addRoutes([{
            //         path: '/resume',
            //         component: () => import('@views/layout/Layout'),
            //         redirect: '/resume/index',
            //         meta: {
            //             name: '简历管理',
            //         },

            //         children: [{
            //             path: 'index',
            //             component: () =>
            //                 import('@views/resume/Index'),
            //             meta: {
            //                 name: '简历信息',
            //                 paths: [{
            //                     name: '简历管理'
            //                 }]
            //             }
            //         }]
            //     },
            //     {
            //         path: '/user',
            //         component: () => import('@views/layout/Layout'),
            //         redirect: '/user/index',

            //         children: [{
            //                 path: 'index',
            //                 component: () =>
            //                     import('@views/user/Index'),
            //                 meta: {
            //                     name: '用户信息',
            //                     paths: [{
            //                         name: '用户管理'
            //                     }]
            //                 }
            //             },
            //             {
            //                 path: 'role',
            //                 component: () =>
            //                     import('@views/role/Index'),
            //                 meta: {
            //                     name: '用户角色',
            //                     paths: [{
            //                         name: '用户管理'
            //                     }]
            //                 }
            //             },
            //             {
            //                 path: 'permission',
            //                 component: () =>
            //                     import('@views/permission/Index'),
            //                 meta: {
            //                     name: '用户权限',
            //                     paths: [{
            //                         name: '用户管理'
            //                     }]
            //                 }
            //             },
            //         ]
            //     },
            //     {
            //         path: '/report',
            //         component: () => import('@views/layout/Layout'),
            //         redirect: '/report/personal_recruitment',

            //         children: [{
            //             path: 'personal_recruitment',
            //             component: () =>
            //                 import('@views/report/PersonalRecruitment'),
            //             meta: {
            //                 name: '个人招聘统计',
            //                 paths: [{
            //                     name: '报表'
            //                 }]
            //             }
            //         }, ]
            //     }
            // ]);
        } else {
            suceess = false;
        }
    } catch (e) {
        suceess = false;
    } finally {
        return suceess;
    }
};

//初始化路由
const router = new VueRouter({
    routes,

    //增加html5的history的模式
    mode: "history"
});

//用于处理刷新后是否重新获取重新渲染页面
let initRouter = false;

router.beforeEach(async (to, from, next) => {
    let toPath = to.path;

    // //检查当前页面url是否存在, 在初始化后调用
    // if (initRouter && !urlArr[toPath]) {
    //     next({
    //         path: "/404"
    //     });
    //     return;
    // }

    //直接过滤掉的页面，不要验证
    if (to.meta.notAuth === true) {
        next();
        return;
    }

    //是否加载中
    let loadingInstance = null;

    //获取当前登录的用户
    let user = store.getters.userInfo;

    // // //TODO 测试使用 --------------------
    // let user = {
    //     id: 1,
    //     uname: "admin",
    //     avatar: "",
    //     personal_name: "",
    //     phone: "",
    //     status: 0,
    //     ct_user: "",
    //     ct_time: "2018-12-29 15:02:09",
    //     mfy_user: "admin",
    //     mfy_time: "2019-01-15 13:41:08",
    //     token:
    //         "232be93a32c229a03ed312e05c9c3feef8157e07f426c10abcdc258a31b2eff0"
    // };
    // store.commit("setUserInfo", user);

    // //---------------------------------------

    if (!user.name) {
        let checkError = false;

        //加载loading
        loadingInstance = Loading.service({
            fullscreen: true
        });

        try {
            //忽略这个接口的自动刷新页面，由当前的js接管
            let resp = await getUserInfo(true),
                udata = resp.data;

            if (resp.code == 200) {
                user = udata;
                store.commit("setUserInfo", udata);
            } else {
                store.commit("clearUserInfo");
            }
        } catch (e) {
            checkError = true;
        } finally {
            //关闭loading
            loadingInstance && loadingInstance.close();

            if (checkError) {
                router.push("/error");
                return;
            }
        }
    }

    //初始化路由成功后,如果当前用户没有登录的话，跳到登录
    if (user.name) {
        //初始化菜单------------------------

        if (!initRouter) {
            //加载loading
            loadingInstance = Loading.service({
                fullscreen: true
            });

            let suceess = await genRoute(router, store);

            if (suceess) {
                initRouter = true;
                //一定要写toPath, 用于等待数据返回再次刷新
                next({
                    path: toPath
                });
            } else {
                //跳到出错页面
                router.push("/error");
            }

            loadingInstance && loadingInstance.close();
        } else if (/^\/login\/*/.test(toPath)) {
            // //TODO：暂时开放登录
            // next();

            //登录后还想跳到登录页面的，直接跳首页
            router.replace("/home");
        } else {
            //menu都有了直接next
            next();
        }

        //---------------------------
    } else if (toPath != "/login") {
        //没有登录,并且想跳到其他地方，直接跳到登录
        router.replace("/login");
    } else {
        //登录页面直接跳转
        next();
    }
});

export default router;
