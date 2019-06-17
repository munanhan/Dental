<template>
    <div class="patient-info">
        <div class="patien-content">
            <!-- <template slot="title">
                <span class="base-fz">基本信息</span>
            </template> -->

            <div
                class="patient-body"
                style="display:flex"
            >
                <div class="patient-left">
                    <el-row
                        :gutter="24"
                        style="margin:20px"
                    >
                        <el-col :span="8">
                            <div> 患者姓名：<span style="color:#000">{{data.patient_name}}</span></div>
                        </el-col>
                        <el-col :span="8">
                            <div>患者分组：<span style="color:#000">{{data.patient_group}}</span></div>
                        </el-col>
                        <el-col :span="8">
                            <div>电 话：<span style="color:#000">{{data.patient_phone}}</span></div>
                        </el-col>
                    </el-row>
                    <el-row
                        :gutter="24"
                        style="margin:20px"
                    >
                        <el-col :span="8">
                            <div>病 历 号：<span style=""></span>{{data.case_id}}</div>
                        </el-col>
                        <el-col :span="8">
                            <div>介 绍 人：{{data.introducer}}</div>
                        </el-col>
                        <el-col :span="8">
                            <div>职 业：{{data.patient_profession}}</div>
                        </el-col>
                    </el-row>
                    <el-row
                        :gutter="24"
                        style="margin:20px"
                    >
                        <el-col :span="8">
                            <div>出生年月：{{data.patient_birthday}}</div>
                        </el-col>
                        <el-col :span="8">
                            <div>年 龄：{{data.patient_age}}</div>
                        </el-col>
                        <el-col :span="8">
                            <div>社 保 号：{{data.society_no}}</div>
                        </el-col>
                    </el-row>
                    <el-row
                        :gutter="24"
                        style="margin:20px"
                    >
                        <el-col :span="8">
                            <div>会员等级：{{data.member_level}}</div>
                        </el-col>
                        <el-col :span="8">
                            <div>会员卡号：{{data.member_card}}</div>
                        </el-col>
                        <el-col :span="8">
                            <div>电子邮箱：{{data.patient_email}}</div>
                        </el-col>
                    </el-row>
                    <el-row
                        :gutter="24"
                        style="margin:20px"
                    >
                        <el-col :span="8">
                            <div>联系地址：{{data.patient_address}}</div>
                        </el-col>

                    </el-row>
                    <el-row
                        :gutter="24"
                        style="margin:20px"
                    >
                        <el-col :span="8">
                            <div>备 注：{{data.patient_content}}</div>
                        </el-col>

                    </el-row>
                </div>

                <div class="patient-right">
                    <div
                        class="image"
                        style="background-image: url(404.jpg);"
                    >
                    </div>
                    <div style="display:flex;margin-bottom:5px">
                        <template>
                            <el-radio-group v-model="patient_sex">
                                <el-radio :label="0">男</el-radio>
                                <el-radio :label="1">女</el-radio>
                            </el-radio-group>
                        </template>
                    </div>

                </div>
            </div>

            <div class="underline">

            </div>

            <div class="patient-middle">
                <el-row
                    :gutter="24"
                    style="margin:20px"
                >
                    <el-col :span="7">
                        <div>民族：{{data.nition}}</div>
                    </el-col>
                    <el-col :span="8">
                        <div>咨 询 师：{{data.counselor}}</div>
                    </el-col>
                    <el-col :span="8">
                        <div>患者来源：{{data.patient_source}}</div>
                    </el-col>

                    <!-- <el-col :span="8">
                        <div>初诊时间：{{data.treatment_date}}</div>
                    </el-col> -->
                </el-row>
                <el-row
                    :gutter="24"
                    style="margin:20px"
                >
                    <el-col :span="7">
                        <div>吸 烟 史：{{data.anamnesis}}</div>
                    </el-col>
                    <el-col :span="8">
                        <div>洁牙习惯：{{data.anamnesis}}</div>
                    </el-col>
                    <el-col
                        :span="8"
                        style="display:flex"
                    >
                        <div>刷牙次数：{{data.anamnesis}}</div>
                        <div style="color:black;display:flex">
                            <div>5</div>次/天<div style="margin-left:20px">5</div>分钟/次
                        </div>
                    </el-col>
                </el-row>
                <el-row
                    :gutter="24"
                    style="margin:20px"
                >
                    <el-col :span="24">
                        <div>过 敏 史：{{data.allergy}}</div>
                    </el-col>
                </el-row>
                <el-row
                    :gutter="24"
                    style="margin:20px"
                >
                    <el-col :span="24">
                        <div>既 往 史：{{data.anamnesis}}</div>
                    </el-col>
                </el-row>

            </div>
        </div>
        <div class="patient-bottom">
            <el-button
                class="patient-bottom-button"
                type="primary"
                porp="modify-inormation"
                @click="Modify_info"
            >修改信息</el-button>

        </div>
        <modify-info :show.sync="modinfo_show"></modify-info>
    </div>
</template>

<script>
import ModifyInfo from "./ModifyInfo";
export default {
    name: "PatientInfo",

    components: {
        ModifyInfo
    },
    props: {
        refresh: {
            type: Boolean,
            required: true
        },
        selectPatient:{
            type:Object,
            required:true,
        }
    },
    data() {
        return {
            data: {},
            modinfo_show: false,
            patient_sex: 0
        };
    },
    created() {},
    mounted() {

    },
    watch: {
        refresh(newValue, oldValue) {
            let that = this;

            if (newValue) {
               
            }
        },
        selectPatient(newValue,oldValue){
            let that = this;
            if(newValue){
                console.log(that.selectPatient);
            }
        }

    },
    computed: {},
    methods: {
        getPatientInfo() {
            let that = this;

            that.$api.patient.aaaa
                .then(res => {
                    that.getDataDone();
                })
                .catch(res => {
                    that.getDataDone();
                });
        },

        getDataDone() {
            setTimeout(() => {
                that.$emit("update:refresh", false);
            }, 6e3);
        },
        handleChange(val) {
            console.log(val);
        },
        Modify_info() {
            this.modinfo_show = true;
        }
    }
};
</script>
<style lang="less" scoped>
//导入全局的颜色
@import "~@css/var";

.patient-info {
    .patien-content {
        position: absolute;
        top: 0;
        right: 0;
        left: 0;
        bottom: 0;
        height: 100%;
        // .base-fz {
        //     font-size: 18px;
        //     margin-left: 10px;
        // }
        .patient-body {
            width: 100%;
            // border:1px solid red;
            .patient-left {
                height: 100%;
                width: 100%;
            }
            .patient-right {
                flex: 1 auto;
                margin-right: 50px;
                padding: 5px;
                .image {
                    position: relative;
                    border: 1px solid rgb(189, 189, 189);
                    width: 170px;
                    margin-bottom: 10px;
                    margin-left: -30px;
                    height: 180px;
                }
                .block {
                    margin-left: -4px;
                }
            }
        }
        .patient-middle {
            margin-top: 30px;
        }
    }
    .patient-bottom {
        border: 1px solid #e4e4e4;
        background-color: #e3e3e3;
        position: absolute;
        left: 0;
        bottom: 0;
        width: 100%;
        height: 59px;
        .patient-bottom-button {
            width: 110px;
            margin-top: 10px;
            margin-left: 10px;
        }
    }
}
.underline {
    border: 0.5px solid #e3e3e3;
    width: 100%;
    margin-top: 70px;
    margin-bottom: 10px;
}

.el-row {
    color: #7a7979;
}

.patient-button {
    margin-right: 20px;
    width: 120px;
    margin-left: 10px;
    margin-top: 10px;
}

.sliding-one {
    width: 1000px;
    margin-left: 10px;
    margin-bottom: 10px;
}
.sliding-two {
    width: 1000px;
    margin-left: 10px;
    margin-bottom: 10px;
}
.sliding-three {
    width: 1000px;
    margin-left: 10px;
    margin-bottom: 10px;
}
</style>