<template>
    <div class="login-container">

        <div class="content">
            <div class="left-bg">
            </div>
            <el-form
                ref="form"
                :model="form"
                class="login-form"
            >
                <div class="login-title">医云智能</div>
                <el-input
                    :disabled="loading"
                    v-model.trim="form.username"
                    placeholder="用户名/手机号"
                    auto-complete="off"
                ></el-input>
                <el-input
                    :disabled="loading"
                    @keyup.native.enter="submitHandler"
                    v-model.trim="form.password"
                    type="password"
                    placeholder="用户密码"
                    autocomplete="off"
                ></el-input>

                <div>
                    <span class="forget-pass">忘记密码?</span>
                </div>

                <el-button
                    type="primary"
                    :loading="loading"
                    @click="submitHandler"
                >登录</el-button>
            </el-form>
        </div>

    </div>
</template>

<script>
import { setCookie, getCookie } from "@common/util";

export default {
    name: "login",

    data() {
        return {
            form: {
                username: "",
                password: ""
            },

            loading: false
        };
    },

    methods: {
        submitHandler() {
            let that = this;

            if (!that.form.username) {
                this.$message.error("请输入用户名.");
                return;
            }

            if (!that.form.password) {
                this.$message.error("请输入密码.");
                return;
            }

            that.loading = true;

            that.$api.base
                .login(that.form)
                .then(res => {
                    if (res.code == 200) {                        
                        this.$message({
                            message: "登录成功",
                            type: "success",
                            duration: 800
                        });

                        setCookie(
                            "token",
                            res.data.token_type + " " + res.data.access_token,
                            res.data.expires_in * 1000
                        );
                        
                        setCookie(
                            "refresh_token",
                            res.data.refresh_token,
                            res.data.expires_in * 1000
                        );
                        
                        setTimeout(() =>{
                            window.location.href = '/home';
                        }, 1000);

                        // that.$store.commit("setUserInfo", res.data);

                        // setTimeout(() => {
                        //     let redirect = decodeURIComponent(
                        //         that.$route.query.redirect || "/home"
                        //     );

                        //     that.$router.push({
                        //         //你需要接受路由的参数再跳转
                        //         path: redirect
                        //     });
                        // }, 1200);
                    } else {
                        that.$message.error(
                            res.msg || "用户或密码错误,请重试."
                        );
                        that.loading = false;
                    }
                })
                .catch(res => {
                    that.$message.error("用户或密码错误,请重试.");
                    that.loading = false;
                });
        }
    }
};
</script>
<style lang='less'>
//导入全局的颜色
@import "~@css/var";

.login-container {
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;

    .el-button--primary,
    .el-pagination.is-background .el-pager li:not(.disabled).active {
        background: @color;
        border-color: @color;

        &:focus,
        &:hover {
            background: @hover-color;
            border-color: @hover-color;
        }
    }

    .content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        border: 1px solid #d2cece;
        display: flex;
        align-items: center; /*垂直居中*/

        .forget-pass {
            font-size: 14px;
            color: @color;
            cursor: pointer;

            &:hover {
                color: @hover-color;
            }
        }

        .left-bg {
            width: 260px;
            height: 360px;
            background-image: url("../assets/img/login-left-bg.png");
            background-size: 100% 100%;
            flex: 1 auto;
        }

        .login-form {
            padding: 35px 15px;
            border-radius: 6px;
            max-width: 300px;
            flex: 1 auto;

            input,
            div {
                margin-bottom: 10px;
            }

            button {
                width: 100%;
            }

            .login-title {
                text-align: center;
                font-size: 1.2em;
            }
        }
    }
}
</style>