<template>
    <div class="con-content">
        <div class="con-top">
            <div
                @dblclick="add_cons"
                class="background"
            >
                <!-- <div class="top-title">
                    <div style="margin-right:60px"> &nbsp;&nbsp; 2019-05-16 &nbsp;&nbsp; 14:00 &nbsp;&nbsp;</div>
                    <div style="margin-right:200px">接诊医生:12121212</div>
                    <div>录入:1212</div>
                </div> -->
                <div
                    class="top-title"
                    v-for="(item,index) in consultingList"
                    :key="index"
                >
                    <div class="top-content">
                        <div class="top-text">{{item.appointment_date}}</div>
                        <div class="top-text">{{item.patient_time}}</div>
                        <div class="top-text">接诊医生：<span>{{item.patient_doctor}}</span></div>
                    </div>
                    <div class="top-i-content">

                        <i class="fa fa-pen top-i"></i>
                        <i class="fa fa-trash-alt top-i"></i>
                    </div>
                </div>
                <div class="bottom-title">
                    <el-row
                        :gutter="24"
                        style="margin:20px"
                    >
                        <el-col
                            class="bottom-title-col"
                            :span="24"
                        >
                            <div
                                style="width:80px"
                                class="font-left"
                            > 主 诉:</div>
                            <div
                                style="flex:1"
                                class="font-right"
                            >asdsadsadsad</div>
                        </el-col>

                    </el-row>
                    <el-row
                        :gutter="24"
                        style="margin:20px"
                    >
                        <el-col
                            class="bottom-title-col"
                            :span="24"
                        >
                            <div
                                style="width:80px"
                                class="font-left"
                            > 基本需要:</div>
                            <div
                                style="flex:1"
                                class="font-right"
                            >asdsadsadsad</div>
                        </el-col>

                    </el-row>
                    <el-row
                        :gutter="24"
                        style="margin:20px"
                    >
                        <el-col
                            class="bottom-title-col"
                            :span="24"
                        >
                            <div
                                style="width:80px"
                                class="font-left"
                            >潜在需求:</div>
                            <div
                                style="flex:1"
                                class="font-right"
                            >asdsadsadsad</div>
                        </el-col>

                    </el-row>
                    <el-row
                        :gutter="24"
                        style="margin:20px"
                    >
                        <el-col
                            class="bottom-title-col"
                            :span="24"
                        >
                            <div
                                style="width:80px"
                                class="font-left"
                            >医生方案:</div>
                            <div
                                style="flex:1"
                                class="font-right"
                            >asdsadsadsad</div>
                        </el-col>
                    </el-row>
                    <el-row
                        :gutter="24"
                        style="margin:20px"
                    >
                        <el-col
                            class="bottom-title-col"
                            :span="24"
                        >
                            <div
                                style="width:80px"
                                class="font-left"
                            >沟通记录:</div>
                            <div
                                style="flex:1"
                                class="font-right"
                            >asdsadsadsad</div>
                        </el-col>
                    </el-row>
                    <el-row
                        :gutter="24"
                        style="margin:20px"
                    >
                        <el-col
                            class="bottom-title-col"
                            :span="24"
                        >
                            <div
                                style="width:80px"
                                class="font-left"
                            >服务建议:</div>
                            <div
                                style="flex:1"
                                class="font-right"
                            >asdsadsadsad</div>
                        </el-col>
                    </el-row>

                </div>
            </div>
        </div>
        <div dis-bottom>
            <div class="con-bottom">
                <el-button
                    class="con-button"
                    type="primary"
                    @click="add_cons"
                >新增</el-button>
            </div>
        </div>
        <add-consulting
            :show.sync="addcons_show"
            :addConsult="consultInfo"
        ></add-consulting>
    </div>

</template>

<script>
import AddConsulting from "./AddConsulting";

export default {
    name: "ConsultingInfo",
    components: {
        AddConsulting
    },
    props: {
        refresh: {
            type: Boolean,
            required: true
        },
        consultInfo: {
            type: Object,
            required: true
        },
    },
    data() {
        return {
            addcons_show: false,
            consultingList: [
                {
                    case_id: "150301012",
                    appointment_date: "2019-06-03",
                    patient_time: "10:00",
                    patient_phone: "13925814457",
                    patient_doctor: "马医生"
                }
            ]
        };
    },
    created() {},
    mounted() {},
    watch: {
        refresh(newValue, oldValue) {
            let that = this;

            if (newValue) {
                that.getDisposalRecords();
            }
        }
    },
    computed: {},
    methods: {
        getDisposalRecords() {},

        getDataDone() {
            setTimeout(() => {
                that.$emit("update:refresh", false);
            }, 6e3);
        },
        add_cons() {
            this.addcons_show = true;
        }
    }
};
</script>
<style lang="less" scoped>
//导入全局的颜色
@import "~@css/var";
.con-content {
    .con-top {
        // border: 1px solid red;
        position: absolute;
        right: 0;
        left: 0;
        top: 0;
        height: 100%;
        bottom: 0;
        .background {
            cursor: pointer;
            border: 1px solid #c4c4c4;
            margin: 10px 20px;
            height: 200px;
            border-left-width: 10px;
            &:hover {
                color: @color;
                border-color: @color;
            }
            .top-title {
                justify-content: space-around;
                display: flex;
                color: #6d6d6d;
                font-size: 20px;
                font-weight: bold;
                margin: 10px 0;
                color: #000;

                // border: 1px solid red;
                .top-content {
                    flex: 1 auto;
                    text-align: left;
                    margin-right: 20px;
                    .top-text {
                        margin-left: 3px;
                        margin-right: 20px;
                        display: inline-block;
                    }
                }
                .top-i-content {
                    // border:1px solid red;
                    margin-right: 10px;
                    .top-i {
                        margin-right: 5px;
                        cursor: pointer;
                        color: #696969;
                        &:hover {
                            color: #000;
                        }
                    }
                }
            }
            .bottom-title {
                margin-bottom: 100px;
                // border: 1px solid red;
                font-size: 16px;
                color: #8f8f8f;
                .bottom-title-col {
                    display: flex;
                    margin-bottom: -20px;
                    // border: 1px solid red;
                    .font-left {
                        font-weight: bold;
                        margin-right: 50px;
                        margin-bottom: 5px;
                    }
                    .font-right {
                        color: #000;
                    }
                }
            }
        }
    }
    .con-bottom {
        border: 1px solid #e4e4e4;
        background-color: #e3e3e3;
        position: absolute;
        left: 0;
        bottom: 0;
        width: 100%;
        height: 59px;
        .con-button {
            width: 130px;
            margin-left: 10px;
            margin-top: 10px;
        }
    }
}
</style>