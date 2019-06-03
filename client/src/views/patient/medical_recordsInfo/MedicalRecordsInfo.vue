<template>
    <div class="medical-content">
        <el-form
            ref="form"
            :model="form"
            label-width="80px"
        >
            <div class="medical-top">
                <div
                    class="background"
                    @dblclick="int_diagn"
                >
                    <div class="medical-top-title">
                        <div>2019-05-14 &nbsp; 14:56 &nbsp; 初诊 &nbsp;&nbsp; &nbsp; 医生：1212</div>
                        <div style="margin-left:530px">
                            <i class="el-icon-edit medical-top-i"></i>
                            <i class="el-icon-edit medical-top-i"></i>
                            <i class="fa fa-capsules medical-top-i"></i>
                            <i class="el-icon-delete-solid medical-top-i"></i>
                        </div>
                    </div>

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
                                <div> 主诉：</div>
                                <div style="color:#000;margin-left:200px">sadsad</div>
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
                                <div style="color:#000;margin-left:50px">asdsadsadsad</div>
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
                                <div style="color:#000;margin-left:50px">asdsadsadsad</div>
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
                                <div style="color:#000;margin-left:50px">asdsadsadsad</div>
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
                                <div style="color:#000;margin-left:65px">asdsadsadsad</div>
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
                                <div style="color:#000;margin-left:65px">asdsadsadsad</div>
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
                                <div style="color:#000;margin-left:65px">asdsadsadsad</div>
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
                                <div style="color:#000;margin-left:65px">asdsadsadsad</div>
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
                                <div style="color:#000;margin-left:65px">asdsadsadsad</div>
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
                                <div style="color:#000;margin-left:65px">asdsadsadsad</div>
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
                    style="margin-left:10px;width: 90px;"
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
        <initial-diagnosis :show.sync="intdiag_show"></initial-diagnosis>
        <subsequent-visit :show.sync="subvisit_show"></subsequent-visit>
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
        refresh: {
            type: Boolean,
            required: true
        }
    },
    data() {
        return {
            FormArr: [
                {
                    index: 0,
                    value: ""
                }
            ],
            // others: [
            //   {
            //     value: "选项1",
            //     label: "全部打印"
            //   },
            //   {
            //     value: "选项2",
            //     label: "打印设置"
            //   }
            // ],
            // other:"",

            // risk: [
            //   {
            //     value: "选项1",
            //     label: "SAC外科病例评估"
            //   },
            //   {
            //     value: "选项2",
            //     label: "SAC修复病例评估"
            //   },
            //   {
            //     value: "选项3",
            //     label: "牙周病危险评估"
            //   }
            // ],
            // risk_assessment:"",
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
            subvisit_show: false
        };
    },
    created() {},
    mounted() {},
    watch: {
        refresh(newValue, oldValue) {
            let that = this;

            if (newValue) {
                that.getMedicalRecordsInfo();
            }
        }
    },
    computed: {},
    methods: {
        getMedicalRecordsInfo() {},

        getDataDone() {
            setTimeout(() => {
                that.$emit("update:refresh", false);
            }, 6e3);
        },

        //初诊
        int_diagn() {
            this.intdiag_show = true;
        },
        //复诊
        sub_visit() {
            this.subvisit_show = true;
        },
        // 阿斯顿发射点发生都杀都还塞的还是丢啊是
        AddForm() {
            this.FormArr.push({
                index: this.FormArr.length,
                value: ""
            });
            console.log(this.FormArr);
        },
        Delete(index) {
            this.FormArr.splice(index, 1);
            for (let i in this.FormArr) {
                this.FormArr[i].index = i;
            }
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
            background-color: #f8f8f8;
            border: 2px solid #88cdec;
            border-left-width: 10px;
            padding: 10px;
            color: #989797;

            .medical-top-title {
                font-size: 22px;
                display: flex;
                // border: 1px solid red;
                width: 100%;
            }
            .patient-left {
                margin-bottom: 100px;
                margin-left: -25px;
                // border: 1px solid red;
                font-size: 15px;
                color: #5e5e5e;
                .patient-left-col {
                    display: flex;
                    margin-bottom: -20px;
                    // border: 1px solid red;
                }
            }
            .medical-top-i {
                cursor: pointer;
                margin-left: 20px;
            }
            &:hover {
                border-color: #6ac2eb;
                color: #484848;
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