<template>
    <div class="medical-content">
        <el-form
            ref="form"
            :model="form"
            label-width="80px"
        >
            <div class="medical-top">
                <div
                    v-for="(item,index) in medicals"
                    :key="index"
                    class="background"
                    @dblclick="int_diagn"
                >
                    <!-- <div class="background-1"> -->
                    <div class="medical-top-title">
                        <div style="flex: 1;">
                            <div class="top">{{item.medical_date}}</div>
                            <div class="top">{{item.medical_time}}</div>
                            <div class="top">{{item.medical_diagnosis_judgment}}</div>
                            <div class="top2"> {{item.medical_doctor}}：<span>11</span></div>
                        </div>
                        <div style="text-align:right;">
                            <i
                                style="font-size:20px;"
                                class="el-icon-printer medical-top-i"
                            ></i>
                            <i class="fa fa-newspaper medical-top-i"></i>
                            <i class="fa fa-pen medical-top-i"></i>
                            <i class="fa fa-capsules medical-top-i"></i>
                            <i class="fa fa-comments medical-top-i"></i>
                        </div>
                    </div>
                    <!-- <div class="medical-top-title">
                        <div>
                            <span>{{item.medical_date}}</span>
                            <span>{{item.medical_time}}</span>
                            <span>{{item.medical_diagnosis_judgment}}</span>
                            <span> {{item.medical_doctor}}</span>
                        </div>
                        <div style="margin-left:530px">
                            <i class="el-icon-edit medical-top-i"></i>
                            <i class="el-icon-edit medical-top-i"></i>
                            <i class="fa fa-capsules medical-top-i"></i>
                            <i class="el-icon-delete-solid medical-top-i"></i>
                        </div>
                    </div> -->

                    <!-- 水水水水水水水水水水水水水水水水水水水 -->
                    <!-- <el-main>
                            <el-col
                            :span="24"
                            class="warp-main"
                            v-loading=""
                        >
                            <el-form
                                :inline="true"
                                class="demo-form-inline"
                                v-for="(item, i) in FormArr"
                                :key="i"
                            >
                                        <el-form-item>
                                              <el-input v-model="item.value"></el-input>
                                            </el-form-item>
                                        <el-button
                                    type="primary"
                                    @click="Delete(item.index)"
                                >删除</el-button>
                            </el-form>
                                  <el-button
                                type="primary"
                                @click="AddForm"
                            >增加更多</el-button>
                               
                        </el-col>
                          </el-main> -->
                    <!-- 水水水水水水水水水水水水水水水水水水水 -->
                    <div class="patient-left">
                        <el-row
                            :gutter="24"
                            style="margin:20px"
                        >
                            <el-col
                                :span="24"
                                class="patient-left-col"
                            >
                                <div> 主诉:</div>
                                <div class="form-content">{{item.medical_complain}}</div>
                            </el-col>

                        </el-row>
                        <el-row
                            :gutter="24"
                            style="margin:20px"
                        >
                            <el-col
                                class="patient-left-col"
                                :span="24"
                            >
                                <div> 现病史:</div>
                                <div style="color:#000;margin-left:50px">{{item.medical_hpi}}</div>
                            </el-col>

                        </el-row>
                        <el-row
                            :gutter="24"
                            style="margin:20px"
                        >
                            <el-col
                                class="patient-left-col"
                                :span="24"
                            >
                                <div>既往史:</div>
                                <div style="color:#000;margin-left:50px">{{item.medical_anamnesis}}</div>
                            </el-col>

                        </el-row>
                        <el-row
                            :gutter="24"
                            style="margin:20px"
                        >
                            <el-col
                                class="patient-left-col"
                                :span="24"
                            >
                                <div>过敏史:</div>
                                <div style="color:#000;margin-left:50px">{{item.medical_allergy}}</div>
                            </el-col>
                        </el-row>
                        <el-row
                            :gutter="24"
                            style="margin:20px"
                        >
                            <el-col
                                class="patient-left-col"
                                style="margin-top:5px;margin-bottom:10px;"
                                :span="24"
                            >
                                <div>检查:</div>
                                <div class="form-content">{{item.medical_check}}</div>
                            </el-col>
                        </el-row>
                        <el-row
                            :gutter="24"
                            style="margin:20px"
                        >
                            <el-col
                                class="patient-left-col"
                                style="margin-top:5px;margin-bottom:10px;"
                                :span="24"
                            >
                                <div>辅助检查:</div>
                                <div style="margin-left:35px;color:#000">{{item.medical_auxiliary}}</div>
                            </el-col>
                        </el-row>
                        <el-row
                            :gutter="24"
                            style="margin:20px"
                        >
                            <el-col
                                class="patient-left-col"
                                style="margin-bottom:5px;"
                                :span="24"
                            >
                                <div>诊断:</div>
                                <div class="form-content">{{item.medical_diagnosis}}</div>
                            </el-col>
                        </el-row>
                        <el-row
                            :gutter="24"
                            style="margin:20px"
                        >
                            <el-col
                                class="patient-left-col"
                                style="margin-bottom:5px;"
                                :span="24"
                            >
                                <div>治疗方案:</div>
                                <div
                                    style="margin-left:35px"
                                    class="form-content"
                                >{{item.medical_treatment_options}}</div>
                            </el-col>
                        </el-row>
                        <el-row
                            :gutter="24"
                            style="margin:20px"
                        >
                            <el-col
                                class="patient-left-col"
                                style="margin-bottom:5px;"
                                :span="24"
                            >
                                <div>治疗:</div>
                                <div class="form-content">{{item.medical_treatment}}</div>
                            </el-col>
                        </el-row>
                        <el-row
                            :gutter="24"
                            style="margin:20px"
                        >
                            <el-col
                                class="patient-left-col"
                                style="margin-bottom:5px;"
                                :span="24"
                            >
                                <div>医嘱:</div>
                                <div class="form-content">{{item.medical_doctor_advice}}</div>
                            </el-col>
                        </el-row>
                    </div>
                </div>
            </div>
        </el-form>

        <div class="medical-bottom">
            <div class="image-bottom">

                <el-button
                    type="primary"
                    style="margin-left:10px;width:90px;"
                    @click="int_diagn"
                >初诊</el-button>
                <el-button
                    class="medical-button"
                    @click="sub_visit"
                >复诊</el-button>

                <el-select
                    v-model="form.vaOral_cavitylue"
                    class="medical-button"
                    style="width:120px"
                    placeholder="口腔检查"
                >
                    <el-option
                        v-for="item in form.oral"
                        :key="item.value"
                        :label="item.label"
                        :value="item.value"
                    >
                    </el-option>
                </el-select>
                <el-button class="medical-button">正畸病历</el-button>
            </div>
        </div>
        <initial-diagnosis
            :show.sync="intdiag_show"
            :addInitial="medicalInfo"
        ></initial-diagnosis>
        <subsequent-visit
            :show.sync="subvisit_show"
            :addSubsequent="medicalInfo"
        ></subsequent-visit>
    </div>
</template>

<script>
import InitialDiagnosis from "./InitialDiagnosis";
import SubsequentVisit from "./SubsequentVisit";
export default {
    name: "MedicalRecordsInfo",
    components: {
        InitialDiagnosis,
        SubsequentVisit
    },
    props: {
        medicalInfo: {},
        selectID:{},
    },
    data() {
        return {

            form: {
                oral: [
                    {
                        value: "选项1",
                        label: "口腔检查"
                    },
                    {
                        value: "选项2",
                        label: "治疗计划"
                    },
                    {
                        value: "选项3",
                        label: "牙周检查"
                    }
                ]
            },
            vaOral_cavitylue: "",
            value: "",
            intdiag_show: false,
            subvisit_show: false,
            medicals: [
                {
                    medical_date: "2019-05-08",
                    medical_time: "23:30",
                    medical_diagnosis_judgment: "初诊",
                    medical_doctor: "马医生",
                    medical_complain: "痛痛痛",
                    medical_hpi: "发病了",
                    medical_anamnesis: "无既往史",
                    medical_allergy: "无过敏史",
                    medical_check: "病病病病病病病病",
                    medical_auxiliary: "有病有病有病有病",
                    medical_diagnosis: "复诊",
                    medical_treatment_options: "用刀用刀用刀用刀",
                    medical_treatment: "用刀用刀用刀用刀",
                    medical_doctor_advice: "喝水喝水喝水喝水喝水"
                }
            ]
        };
    },
    created() {},
    mounted() {},
    watch: {

    },
    computed: {},
    methods: {

        //初诊
        int_diagn() {
            let that = this;
            if (that.selectID) {
                that.intdiag_show = true;
            } else {
                that.$message.warning("请选择一个患者");
            }
        },
        //复诊
        sub_visit() {
            let that = this;
            if (that.selectID) {
                this.subvisit_show = true;
            } else {
                that.$message.warning("请选择一个患者");
            }
        }

        //  增删改查

        // AddForm() {
        //     this.FormArr.push({
        //         index: this.FormArr.length,
        //         value: ""
        //     });
        //     console.log(this.FormArr);
        // },
        // Delete(index) {
        //     this.FormArr.splice(index, 1);
        //     for (let i in this.FormArr) {
        //         this.FormArr[i].index = i;
        //     }
        // }
    }
};
</script>
<style lang="less" scoped>
//导入全局的颜色
@import "~@css/var";

.transition-2 {
    transition: all 0.2s;
}

.medical-content {
    .medical-top {
        border: 1px solid #dadada;
        position: absolute;
        top: 0;
        right: 0;
        left: 0;
        bottom: 0;
        height: 100%;
        background-color: #f3f1f1;

        .background {
            cursor: pointer;
            height: 380px;
            margin-top: 5px;
            font-weight: bold;
            margin-right: 10px;
            margin-left: 20px;
            background-color: #fafafa;
            border: 2px solid #88cdec;
            border-left-width: 10px;
            padding: 10px;
            color: #989797;

            .medical-top-title {
                display: flex;
                justify-content: space-around;
                font-size: 22px;
                // border: 1px solid red;
                .top {
                    display: inline-block;
                    margin-right: 20px;
                }
                .top2 {
                    display: inline-block;
                }
                .medical-top-i {
                    cursor: pointer;
                    margin-left: 10px;
                }
            }
            .patient-left {
                margin-bottom: 100px;
                margin-left: -10px;
                // border: 1px solid red;
                font-size: 15px;
                color: #5e5e5e;
                .patient-left-col {
                    display: flex;
                    margin-bottom: -20px;
                    // border: 1px solid red;
                    .form-content {
                        color: #000;
                        margin-left: 65px;
                    }
                }
            }

            &:hover {
                border-color: #6ac2eb;
                color: #484848;
                background-color: #f5f5f5;
            }
        }
    }

    .medical-bottom {
        background-color: #dedede;
        position: absolute;
        left: 0;
        bottom: 0;
        width: 100%;
        height: 61px;
        .medical-button {
            margin-left: 10px;
            margin-top: 10px;
            width: 100px;
        }
    }
}
</style>