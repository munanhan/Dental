<template>
    <div>
        <el-dialog
            title="问诊交流"
            :visible.sync="show"
            :before-close="closeDialog"
            class="custom-dialog inquiry"
            :close-on-click-modal="false"
            v-dialog-drag
            width="800px"
            top="3vh"
        >
            <div class="contanier">
                <div class="left-container">
                    <ul class="msg-list">
                        <li
                            class="list-manage"
                            @click.stop.prevent="activeName = 'housekeeperReminder'"
                            :class="{ 'active': activeName == 'housekeeperReminder' }"
                        >
                            <div class="icon-content">
                                <i class="fa fa-tooth"></i>
                            </div>
                            <div class="message">
                                <div class="pull-left">管家提醒</div>
                                <div class="time pull-right">昨天&nbsp;14:10</div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="right-container">
                    <ul class="msg-list">
                        <li class="list-manage">
                            <div class="icon-content">
                                <i class="fa fa-tooth"></i>
                            </div>
                            <div class="message">
                                <div class="title">管家提醒</div>
                                <div class="message-content">
                                    <div class="tip">
                                        <a
                                            href="#"
                                            @click.stop.prevent="showAppointmentDialog = true"
                                        >预约到期提醒</a>
                                        <i class="fa fa-calendar-alt"></i>
                                    </div>
                                    <div>
                                        诊所预约快到期。。。。。。。。。。
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

        </el-dialog>

        <appointment-reminder :show.sync="showAppointmentDialog">
        </appointment-reminder>
    </div>
</template>

<script>
import DialogForm from "../base/DialogForm";
import AppointmentReminder from "./AppointmentReminder";

export default {
    name: "Inquiry",
    mixins: [DialogForm],

    components: { AppointmentReminder },
    props: {},
    data() {
        return {
            showAppointmentDialog: false,
            activeName: "housekeeperReminder"
        };
    },
    created() {},
    mounted() {},
    watch: {
        show(newValue, oldValue) {
            let that = this;

            if (newValue) {
                that.getData();
            }
        }
    },
    computed: {},
    methods: {
        getData() {
            let that = this;
        }
    }
};
</script>
<style lang="less" scoped>
//导入全局的颜色
@import "~@css/var";

.transition-2 {
    transition: all 0.2s;
}

.inquiry {
    /deep/ .el-dialog__body {
        padding: 0;
    }

    .contanier {
        display: flex;
        height: 500px;

        ul,
        li {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .left-container {
            width: 300px;
            border-right: 1px solid #e3e3e3;

            .list-manage {
                margin: 10px;
                display: flex;
                border: 1px solid #e3e3e3;
                padding: 8px;
                border-radius: 4px;
                cursor: pointer;
                .transition-2;

                &.active {
                    background-color: @linght-background-color;
                }

                &:hover {
                    background-color: @linght-background-color;
                }

                .icon-content {
                    height: 48px;
                    width: 48px;
                    background-color: orange;
                    border: 1px solid #e3e3e3;
                    padding: 9px;
                    box-sizing: border-box;
                    border-radius: 4px;
                    margin-right: 6px;

                    i {
                        text-align: center;
                        font-size: 30px;
                        color: white;
                    }
                }

                .message {
                    flex: 1;
                    font-size: 20px;

                    .time {
                        font-size: 14px;
                    }
                }
            }
        }

        .right-container {
            flex: 1;
            background-color: #f5f5f5;

            .list-manage {
                margin: 10px;
                display: flex;
                padding: 2px;
                border-radius: 4px;

                .icon-content {
                    height: 48px;
                    width: 48px;
                    background-color: orange;
                    border: 1px solid #e3e3e3;
                    padding: 9px;
                    box-sizing: border-box;
                    border-radius: 4px;
                    margin-right: 6px;

                    i {
                        text-align: center;
                        font-size: 30px;
                        color: white;
                    }
                }

                .message {
                    flex: 1;

                    .title {
                        font-size: 18px;
                    }

                    .message-content {
                        border: 1px solid #e3e3e3;
                        background-color: white;
                        border-radius: 4px;
                        padding: 10px;
                        line-height: 24px;

                        .tip {
                            font-size: 18px;

                            a {
                                margin-right: 6px;
                            }
                        }
                    }
                }
            }
        }
    }
}
</style>