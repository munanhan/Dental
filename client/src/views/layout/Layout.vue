<template>
    <el-container class="content theme-purple">
        <el-header
            class="header title theme-title-backgroud-color"
            height="40px"
        >
            <div class="header-left">
                牙医管家
            </div>
            <div class="header-right"></div>
        </el-header>

        <el-container class="main">
            <div
                class="aside"
                :style="{
                width: navWidth
            }"
            >
                <el-aside :width="navWidth">
                    <div class="navbar theme-nav">
                        <menu-tree :menu="menu"></menu-tree>
                    </div>
                </el-aside>
            </div>
            <el-main class="main-content">
                <div
                    class="main-body"
                    ref="mainBody"
                >
                    <transition
                        name="fade"
                        mode="out-in"
                    >
                        <router-view :bodyHeight="bodyHeight"></router-view>
                    </transition>
                </div>
            </el-main>
        </el-container>

        <change-password :show.sync="changePasswordDialog">
        </change-password>

        <user-image
            :show.sync="userImageDialog"
            :avatar="userInfo.avatar"
        ></user-image>

    </el-container>
</template>

<script>
import MenuTree from "@components/menutree/MenuTree";
import ChangePassword from "./ChangePassword";
import UserImage from "./UserImage";
import { mapGetters } from "vuex";

export default {
    name: "Layout",
    components: {
        MenuTree,
        ChangePassword,
        UserImage
    },

    data() {
        return {
            bodyHeight: 500,

            menu: [
                {
                    url: "/home",
                    name: "首页",
                    icon: "fa fa-list-alt"
                },
                {
                    id: 88,
                    name: "简历管理",
                    icon: "fa fa-address-book",
                    children: [
                        {
                            url: "/resume/index",
                            name: "简历信息",
                            icon: "fa fa-address-card"
                        }
                    ]
                },
                {
                    id: "5",
                    name: "用户管理",
                    icon: "fa fa-users",
                    children: [
                        {
                            url: "/user/index",
                            name: "用户信息",
                            icon: "fa fa-user-friends"
                        },
                        {
                            url: "/user/role",
                            name: "用户角色",
                            icon: "fa fa-users-cog"
                        },
                        {
                            url: "/user/permission",
                            name: "用户权限",
                            icon: "fa fa-user-shield"
                        }
                    ]
                },
                {
                    id: "6",
                    name: "报表",
                    icon: "fa fa-database",
                    children: [
                        {
                            url: "/report/personal_recruitment",
                            name: "个人招聘统计",
                            icon: "fa fa-user-friends"
                        }
                    ]
                },
                {
                    url: "/test",
                    name: "测试",
                    icon: "fa fa-list-alt"
                }
            ],

            mainBodyTimer: null,

            changePasswordDialog: false,

            userImageDialog: false,

            navWidth: "80px",
            showNav: true
        };
    },

    computed: {
        ...mapGetters(["userInfo", "menu"])
    },

    created() {
        let that = this;
    },

    mounted() {
        const that = this,
            resize = () => {
                clearTimeout(that.mainBodyTimer);

                that.mainBodyTimer = setTimeout(() => {
                    that.bodyHeight = that.$refs.mainBody.offsetHeight;

                    //抛出事件
                    if (window.fireEvent) {
                        window.fireEvent("bodyChange");
                    } else {
                        let rzEvent = new Event("bodyChange");
                        window.dispatchEvent(rzEvent);
                    }
                }, 100);
            };

        resize();

        window.onresize = resize;
    },

    methods: {
        handleFullScreen() {
            let isFullscreen =
                    document.fullScreen ||
                    document.mozFullScreen ||
                    document.webkitIsFullScreen,
                element = document.documentElement;

            if (!isFullscreen) {
                //进入全屏,多重短路表达式
                //普通
                (element.requestFullscreen && element.requestFullscreen()) ||
                    //moz
                    (element.mozRequestFullScreen &&
                        element.mozRequestFullScreen()) ||
                    //webkit
                    (element.webkitRequestFullscreen &&
                        element.webkitRequestFullscreen()) ||
                    //ie
                    (element.msRequestFullscreen &&
                        element.msRequestFullscreen());
            } else {
                //退出全屏,三目运算符
                //普通
                document.exitFullscreen
                    ? document.exitFullscreen()
                    : //moz
                    document.mozCancelFullScreen
                    ? document.mozCancelFullScreen()
                    : //webkit
                    document.webkitExitFullscreen
                    ? document.webkitExitFullscreen()
                    : //ie
                    document.msExitFullscreen
                    ? document.msExitFullscreen()
                    : "";
            }
        },

        logout() {
            let that = this;
            that.$api.user
                .logout()
                .then(res => {
                    // that.$store.commit("clearUserInfo");

                    //直接重刷页面，清除所有的router
                    //因为vue-router不支持动态删除路由
                    window.location.reload();
                    // that.$router.replace("/login");
                })
                .catch(res => {
                    that.$message.error("退出登录失败，请重试.");
                });
        }
    }
};
</script>

<style lang="less" scoped>
.content {
    position: absolute;
    top: 0;
    width: 100%;
    height: 100%;

    .title {
        position: absolute;
        font-size: 18px;
        line-height: 40px;
    }

    .header {
        width: 100%;
        box-sizing: border-box;
        border-bottom: 1px solid #cacaca;

        .header-left {
            text-align: left;
        }

        .header-right {
            text-align: right;
        }

        .dropdown-link {
            line-height: 60px;
            font-size: 16px;
            color: white;
            cursor: pointer;
            padding: 0 6px;

            &:hover {
                background-color: rgba(0, 0, 0, 0.03);
            }
        }

        .user-image {
            height: 40px;
            width: 40px;
            vertical-align: middle;
            margin-right: 4px;
            border-radius: 50%;
            background-size: 100% 100%;
        }
    }

    .main {
        position: relative;

        .main-content {
            position: relative;
            padding: 0;            

            .main-header,
            .main-body,
            .main-footer {
                padding: 20px;
                position: absolute;
                left: 0;
                right: 0;
                box-sizing: border-box;
            }

            .main-header {
                background-color: #f7f7f7;
                border-bottom: 1px solid #dcdfe6;

                // .full-screen {
                //     position: absolute;
                //     top: 14px;
                //     right: 20px;
                //     i {
                //         font-size: 24px;
                //         color: #8a8d92;
                //         cursor: pointer;

                //         &:hover {
                //             color: @header-color;
                //         }
                //     }
                // }
            }

            .main-body {
                position: absolute;
                overflow: auto;
                top: 40px;
                bottom: 0px;
                background-color: #e2e2e2;
            }
        }
    }

    .aside {
        position: relative;
        overflow-x: hidden;
        transition: all 0.3s ease;

        .navbar {
            position: absolute;
            top: 40px;
            bottom: 0;
            width: 100%;
            overflow-x: hidden !important;
            box-sizing: border-box;
        }
    }
}
</style>