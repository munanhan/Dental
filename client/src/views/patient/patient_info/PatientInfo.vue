<template>
    <div class="patient-info">

        <el-collapse
            class="patien-content"
            style="overflow:auto"
        >

            <template slot="title">
                <span class="base-fz">基本信息</span>
            </template>

            <div
                class="patient-body"
                style="display:flex"
            >
                <div class="patient-left">
                    <el-row
                        :gutter="24"
                        style="margin:20px;"
                    >
                        <el-col :span="6">
                            <div> 患者姓名：{{data.patient_name}}</div>
                        </el-col>
                        <el-col :span="6">
                            <div>患者分组：{{data.patient_group}}</div>
                        </el-col>
                        <el-col :span="6">
                            <div>电 话：{{data.patient_phone}}</div>
                        </el-col>
                    </el-row>
                    <el-row
                        :gutter="24"
                        style="margin:20px"
                    >
                        <el-col :span="6">
                            <div>病 历 号：{{data.case_id}}</div>
                        </el-col>
                        <el-col :span="6">
                            <div>介 绍 人：{{data.introducer}}</div>
                        </el-col>
                        <el-col :span="6">
                            <div>职 业：{{data.patient_profession}}</div>
                        </el-col>
                    </el-row>
                    <el-row
                        :gutter="24"
                        style="margin:20px"
                    >
                        <el-col :span="6">
                            <div>出生年月：{{data.patient_birthday}}</div>
                        </el-col>
                        <el-col :span="6">
                            <div>年 龄：{{data.patient_age}}</div>
                        </el-col>
                        <el-col :span="6">
                            <div>社 保 号：{{society_no}}</div>
                        </el-col>
                    </el-row>
                    <el-row
                        :gutter="24"
                        style="margin:20px"
                    >
                        <el-col :span="6">
                            <div>会员等级：{{data.member_level}}</div>
                        </el-col>
                        <el-col :span="6">
                            <div>会员卡号：{{data.member_card}}</div>
                        </el-col>

                    </el-row>
                    <el-row
                        :gutter="24"
                        style="margin:20px"
                    >
                        <el-col :span="6">
                            <div>电子邮箱：{{data.patient_email}}</div>
                        </el-col>

                    </el-row>
                    <el-row
                        :gutter="24"
                        style="margin:20px"
                    >
                        <el-col :span="6">
                            <div>联系地址：{{data.patient_address}}</div>
                        </el-col>

                    </el-row>
                    <el-row
                        :gutter="24"
                        style="margin:20px"
                    >
                        <el-col :span="6">
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
                            <el-radio-group v-model="data.patient_sex">
                                <el-radio :label="3">男</el-radio>
                                <el-radio :label="6">女</el-radio>
                            </el-radio-group>
                        </template>
                    </div>

                </div>
            </div>

            <div class="patient-footer">

            </div>

            <div class="patient-bottom">
                <el-row
                    :gutter="24"
                    style="margin:20px"
                >
                    <el-col :span="6">
                        <div>咨 询 师：{{data.counselor}}</div>
                    </el-col>
                    <el-col :span="6">
                        <div>初诊医生：{{data.attend_doctor}}</div>
                    </el-col>
                    <el-col :span="6">
                        <div>初诊时间：{{data.treatment_date}}</div>
                    </el-col>
                </el-row>
                <el-row
                    :gutter="24"
                    style="margin:20px"
                >
                    <el-col :span="6">
                        <div>患者来源：{{data.patient_source}}</div>
                    </el-col>

                </el-row>
                <el-row
                    :gutter="24"
                    style="margin:20px"
                >
                    <el-col :span="6">
                        <div>患者分类：{{data.patient_category}}</div>
                    </el-col>
                </el-row>
                <el-row
                    :gutter="24"
                    style="margin:20px"
                >
                    <el-col :span="10">
                        <div>过 敏 史：{{data.allergy}}</div>
                    </el-col>
                </el-row>
                <el-row
                    :gutter="24"
                    style="margin:20px"
                >
                    <el-col :span="10">
                        <div>既 往 史：{{data.anamnesis}}</div>
                    </el-col>
                </el-row>

            </div>
        </el-collapse>
        <div style="border:1px solid #e4e4e4;
                    background-color:#e3e3e3;
                    position:absolute;left;0;
                    bottom:0;width:100%;
                    height:59px">

            <el-button
                style="width:110px;margin-top:10px;margin-left:10px"
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
        }
    },
    data() {
        return {
            data:{},
            modinfo_show: false
        };
    },
    created() {},
    mounted() {},
    watch: {
        refresh(newValue, oldValue) {
            let that = this;

            if (newValue) {
                that.getPatientInfo();
            }
        }
    },
    computed: {},
    methods: {
        getPatientInfo() {
            let that = this;

            that.$api.aaaa.aaaa
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
    .el-collapse {
        position: absolute;
        top: 0;
        right: 0;
        left: 0;
        bottom: 0;
        height: 100%;
        .base-fz {
            font-size: 18px;
            margin-left: 10px;
        }
        .patient-body {
            .patient-left {
                height: 100%;
                width: 850px;
            }
            .patient-right {
                margin-left: 10px;
                margin-right: 30px;
                margin-left: -40px;
                flex: 1 auto;
                padding: 5px;
                .image {
                    position: relative;
                    border: 1px solid red;
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
        .patient-bottom {
            margin-top: 30px;
        }
    }
}
.patient-footer {
    border: 0.5px solid #e3e3e3;
    width: 980px;
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