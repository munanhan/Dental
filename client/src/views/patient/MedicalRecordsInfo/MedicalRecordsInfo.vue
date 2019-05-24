<template>
    <div class="medical-content">
        <div class="medical-top">
            <div
                class="diagnose-item"
                @dblclick.stop.prevent="addReturnDialog = true"
            >
                <div class="diagnose-item-title is-current-day">
                    <div>张飞</div>
                    <div>昨天 &nbsp; 13:52</div>
                    <div>复诊</div>
                    <div>貂蝉</div>
                    <div>
                        <i
                            class="fa fa-comment-dots"
                            @click.stop.prevent="addReturnDialog = true"
                        ></i>
                    </div>
                </div>

                <div class="diagnose-detail">
                    <div class="tooth">
                        <div class="tooth-row">
                            <div class="tooth-left">12345678</div>
                            <div class="tooth-right">12345678</div>
                        </div>
                        <div class="tooth-row">
                            <div class="tooth-left">123456789</div>
                            <div class="tooth-right">123456789</div>
                        </div>
                    </div>

                    <div class="detail">
                        <div class="detail-row">维生C片</div>
                        <div class="detail-row">口服一日三次</div>
                    </div>

                </div>
            </div>
        </div>
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
                    v-model="vaOral_cavitylue"
                    class="medical-button"
                    style="width:120px"
                    placeholder="口腔检查"
                >
                    <el-option
                        v-for="item in oral"
                        :key="item.value"
                        :label="item.label"
                        :value="item.value"
                    >
                    </el-option>
                </el-select>

                <!-- <el-select
          v-model="risk_assessment"
          class="medical-button"
          style="width:120px"
          placeholder="风险评估"
        >
          <el-option
            v-for="item in risk"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          >
          </el-option>
        </el-select> -->
                <!-- <el-select
          v-model="other"
          class="medical-button"
          style="width:90px"
          placeholder="其他"
        >
          <el-option
            v-for="item in others"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          >
          </el-option>
        </el-select> -->
                <!-- <el-button class="medical-button">知情同意书</el-button> -->
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
            ],
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
        position: relative;
        height: 799px;
        background-color: #f3f1f1;
        .diagnose-item {
            .transition-2;
            border: 2px solid #e3e3e3;
            border-left-width: 10px;
            cursor: pointer;
            padding: 10px;
            box-sizing: border-box;
            margin-bottom: 10px;
            .diagnose-item-title {
                > div {
                    display: inline-block;
                    width: 160px;
                    font-size: 18px;
                    font-weight: bolder;
                }

                i {
                    font-size: 22px;
                }

                i:hover {
                    color: @color;
                }
            }
            .diagnose-detail {
                display: flex;

                .tooth {
                    width: 220px;

                    .tooth-row {
                        display: flex;
                        font-size: 16px;

                        &:not(:last-of-type) {
                            border-bottom: 2px solid #e3e3e3;
                            transition: border 0.2s;
                        }

                        &:last-of-type {
                            .tooth-left,
                            .tooth-right {
                                padding-top: 6px;
                            }
                        }

                        > div {
                            flex: 1 auto;
                        }

                        .tooth-left {
                            border-right: 2px solid #e3e3e3;
                            text-align: right;
                            transition: border 0.2s;
                        }

                        .tooth-right {
                            padding: 0 0 6px 6px;
                        }

                        .tooth-left,
                        .tooth-right {
                            letter-spacing: 2px;
                        }
                    }
                }
            }
            .detail,
            .tooth {
                margin: 16px 20px 0 0;
            }
            //设置间隔
            .detail .detail-row:first-of-type,
            .tooth .tooth-row .tooth-left {
                padding: 0 6px 6px 0;
            }
            //设置间隔
            .detail .detail-row:last-of-type,
            .tooth .tooth-row:last-of-type .tooth-left,
            .tooth .tooth-row:last-of-type .tooth-right {
                padding-top: 6px;
            }
            //当天
            &.is-current-day {
                border-color: #8c8c8c;
                color: #777474;

                .diagnose-detail {
                    .tooth {
                        .tooth-row {
                            &:not(:last-of-type) {
                                border-color: #989797;
                            }

                            .tooth-left {
                                border-color: #989797;
                            }
                        }
                    }
                }
            }
            &:hover {
                border-color: @color;
                color: #484848;

                .diagnose-detail {
                    .tooth {
                        .tooth-row {
                            &:not(:last-of-type) {
                                border-color: #989797;
                            }

                            .tooth-left {
                                border-color: #989797;
                            }
                        }
                    }
                }
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