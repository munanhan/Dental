<template>
    <el-container class="patient">
        <div class="content-left">
            <div class="left_top">
                <el-tabs
                    v-model="activeName"
                    class="left_tab"
                >
                    <el-tab-pane
                        label="最近访问"
                        name="first"
                        class="visit-content"
                    >
                        <div class="visit-top-content">
                            <!-- <el-input
                                style="width:300px;margin-left:10px;"
                                v-model="search"
                                placeholder="姓名、拼音、电话"
                                suffix-icon="el-icon-search"
                            ></el-input> -->
                        </div>
                        <div class="visit-bottom-content">
                            <el-button
                                type="primary"
                                @click="add_patient"
                            >新增患者</el-button>
                            <el-button @click="app_visit">复诊预约</el-button>
                        </div>
                    </el-tab-pane>
                    <!-- <el-tab-pane
                        label="最近访问"
                        name="visit"
                        class="visit-content"
                    >
                        <div class="visit-top-content">
                            <el-input
                                style="width:300px;margin-left:10px;"
                                v-model="search"
                                placeholder="姓名、拼音、电话"
                                suffix-icon="el-icon-search"
                            ></el-input>
                        </div>
                        <div class="visit-bottom-content">
                            <el-button
                                type="primary"
                                @click="add_patient"
                            >新增患者</el-button>
                            <el-button @click="app_visit">复诊预约</el-button>
                        </div>
                    </el-tab-pane> -->

                    <el-tab-pane
                        label="全部患者"
                        name="patient"
                        class="patient-content"
                    >
                        <div style="position:relative;
                                    background-color: rgba(255,255,255,.5);">
                            <div
                                class="top-content"
                                style="border:1px solid #e3e3e3;
                                       padding:5px 0px;
                                       display:flex"
                            >
                                <el-select
                                    v-model="value"
                                    placeholder="患者信息"
                                    style="width:105px;padding-left:5px"
                                >
                                    <el-option
                                        v-for="item in options"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value"
                                    >
                                    </el-option>
                                </el-select>
                                <el-input
                                    v-model="input"
                                    style="width:200px;padding-left:5px"
                                    placeholder="姓名、拼音、电话"
                                    suffix-icon="el-icon-search"
                                ></el-input>
                                <i
                                    class="fa fa-sort-alpha-down"
                                    style="margin-left:5px;
                                           margin-top:5px;
                                           color:#8f8f8f;
                                           font-size:30px;
                                           cursor:pointer"
                                ></i>
                            </div>

                            <div>
                                <el-tree
                                    style="height:100%;
                                           font-weight:bold;
                                           background-color:#efefef"
                                    :data="data"
                                    :props="defaultProps"
                                ></el-tree>
                            </div>
                        </div>

                        <div
                            class="botton-content"
                            style="
                                  position:absolute;
                                  left;0;bottom:0; 
                                  width: 100%;
                                  height: 60px;
                                  background-color:white;
                                   "
                        >
                            <div class="visit-bottom-content">
                                <el-button
                                    type="primary"
                                    @click="add_patient"
                                >新增患者</el-button>
                                <el-button @click="app_visit">复诊预约</el-button>
                            </div>
                        </div>

                    </el-tab-pane>

                    <el-tab-pane
                        label="最近访问"
                        name="visit"
                        class="visit-content"
                    >
                        <div class="visit-top-content">
                            <el-input
                                style="width:300px;margin-left:10px;"
                                v-model="search"
                                placeholder="姓名、拼音、电话"
                                suffix-icon="el-icon-search"
                            ></el-input>
                        </div>
                        <div class="visit-bottom-content">
                            <el-button
                                type="primary"
                                @click="add_patient"
                            >新增患者</el-button>
                            <el-button @click="app_visit">复诊预约</el-button>
                        </div>
                    </el-tab-pane>
                    <!-- <div class="visit-bottom-content" >
                       <el-button
                        type="primary"
                         @click="add_patient"
                       >新增患者</el-button>
                       <el-button>复诊预约</el-button>
                    </div> -->
                </el-tabs>
            </div>
        </div>

        <div class="content-right">
            <!-- tab -->

            <el-tabs
                v-model="curTab"
                class="right_top"
            >

                <el-tab-pane
                    label="患者信息"
                    name="pationInfo"
                >
                    <patient-info :refresh.sync="pationInfo"></patient-info>

                </el-tab-pane>

                <el-tab-pane
                    label="就诊信息"
                    name="11"
                >
                    <div>asdasdas</div>
                </el-tab-pane>
                <el-tab-pane
                    label="预约信息"
                    name="12"
                >

                </el-tab-pane>
                <el-tab-pane
                    label="处置记录"
                    name="disposalRecords"
                >
                    <disposal-records
                        v-if="disposalRecords"
                        :refresh.sync="disposalRecords"
                    ></disposal-records>
                </el-tab-pane>

                <el-tab-pane
                    label="收费信息"
                    name="chargeInfo"
                >
                    <charge-info
                        v-if="chargeInfo"
                        :refresh.sync="chargeInfo"
                    ></charge-info>
                </el-tab-pane>

                <!-- <el-tab-pane
          label="影像信息"
          name="imageInfo"
        >
          <image-info v-if="imageInfo" :refresh.sync="imageInfo"></image-info>
        </el-tab-pane> -->

                <el-tab-pane
                    label="病历信息"
                    name="medicalRecordsInfo"
                >
                    <medical-records-info
                        v-if="medicalRecordsInfo"
                        :refresh.sync="medicalRecordsInfo"
                    ></medical-records-info>
                </el-tab-pane>

                <!-- <el-tab-pane
          label="外加工"
          name="outsideProcessing"
        >
          <outside-processing v-if="outsideProcessing" :refresh.sync="outsideProcessing"></outside-processing>
        </el-tab-pane> -->

                <el-tab-pane
                    label="回访信息"
                    name="returnVisitInfo"
                >
                    <return-visit-info
                        v-if="returnVisitInfo"
                        :refresh.sync="returnVisitInfo"
                    ></return-visit-info>
                </el-tab-pane>

                <el-tab-pane
                    label="咨询信息"
                    name="consultingInfo"
                >
                    <consulting-info
                        v-if="consultingInfo"
                        :refresh.sync="consultingInfo"
                    ></consulting-info>
                </el-tab-pane>
            </el-tabs>
        </div>
        <!-- 新增患者 -->
        <add-patient :show.sync="addp_show"></add-patient>

        <!-- 复诊预约 -->
        <appointment-visit :show.sync="appvisit_show"></appointment-visit>
    </el-container>
</template>

<script>
import PatientInfo from "@/views/patient/patient_info/PatientInfo";
import DisposalRecords from "@/views/patient/disposal_records/DisposalRecords";
import ChargeInfo from "@/views/patient/charge_info/ChargeInfo";
// import ImageInfo from "./ImageInfo";
import MedicalRecordsInfo from "@/views/patient/medical_recordsInfo/MedicalRecordsInfo";
// import OutsideProcessing from "./OutsideProcessing";
import ReturnVisitInfo from "@/views/patient/ReturnVisitInfo/ReturnVisitInfo";
// import ConsultingInfo from "./ConsultingInfo";
import AddPatient from "@/views/patient/add_patient/AddPatient";
import ConsultingInfo from "@/views/patient/consulting_info/ConsultingInfo";
import AppointmentVisit from "./AppointmentVisit";

export default {
    name: "Patient",

    components: {
        PatientInfo,
        DisposalRecords,
        ChargeInfo,
        // ImageInfo,
        MedicalRecordsInfo,
        // OutsideProcessing,
        ReturnVisitInfo,
        // ConsultingInfo,
        AddPatient,
        AppointmentVisit,
        ConsultingInfo
    },

    props: {},

    data() {
        return {
            input: "",
            search: "",
            curTab: "pationInfo",
            activeName: "patient",
            addp_show: false,
            appvisit_show: false,
            //   pationRefresh: false,
            //   disposalRecordsRefresh: false,

            //   quickFind: {
            // 	pationInfo: "pationRefresh",
            // 	disposalRecords: "disposalRecordsRefresh"

            //   },
            options: [
                {
                    value: "选项1",
                    label: "患者信息"
                },
                {
                    value: "选项2",
                    label: "病历号"
                },
                {
                    value: "选项3",
                    label: "会员号"
                },
                {
                    value: "选项4",
                    label: "检查医生"
                },
                {
                    value: "选项5",
                    label: "高级查询..."
                }
            ],
            value: "",

            pationInfo: false,
            disposalRecords: false,
            chargeInfo: false,
            // imageInfo: false,
            medicalRecordsInfo: false,
            // outsideProcessing: false,
            returnVisitInfo: false,
            consultingInfo: false,

            data: [
                {
                    label: "最近患者(0)",
                    children: [
                        {
                            label: "二级 1-1"
                        }
                    ]
                },
                {
                    label: "黑名单(0)",
                    children: [
                        {
                            label: "二级 1-1"
                        }
                    ]
                },
                {
                    label: "治疗完成(0)",
                    children: [{}]
                }
            ],
            defaultProps: {
                children: "children",
                label: "label"
            }
        };
    },
    created() {},
    mounted() {},
    watch: {
        // refresh(newValue, oldValue) {
        //         let that = this;

        //         if (newValue) {
        //             for (var key in that.content) {
        //                 if (that.content[key]) {
        //                     that[key + "Update"] = true;
        //                 }
        //             }

        //             //更新原来的refresh, 防止下次点击时不通知更新
        //             that.$emit("update:refresh", false);
        //         }
        //     },
        //     selectHandler(index) {
        //         let that = this;
        //         that.content.chargeDetail = "ChargeInfo" == index;
        //         that.chargeDetailUpdate = "ChargeInfo" == index;

        //     },
        curTab(newValue, oldValue) {
            let that = this;

            // target = that.quickFind[newValue];
            // that[target] = true;

            that[newValue] = true;
        }
    },
    computed: {},
    methods: {
        //tab选中事件
        tabSelectHandler(tabInstance) {
            let that = this;

            console.log(tabInstance);
        },

        handleClick(tab, event) {
            console.log(tab, event);
        },
        //新增患者
        add_patient() {
            this.addp_show = true;
        },
        //
        app_visit() {
            this.appvisit_show = true;
        }

        // maskMouseHandler(evt) {
        //   let that = this;

        //   //调整移动的区间范围
        //   that.maxMoveWidth = that.outerWidth - that.maskWidth;
        //   that.maxMoveHeight = that.outerHeight - that.maskHeight;

        //   //点击鼠标点击的位置
        //   that.disX = evt.clientX;
        //   that.disY = evt.clientY;

        //   //记录原来的mask的位置，从这个位置开始计算左右移动距离，- 0 是为了复制值
        //   that.orginTop = that.top - 0;
        //   that.orginLeft = that.left - 0;

        //   // 如果存在可移动的范围的时候才绑定
        //   // 全局监听松开事件，放在在内容选择框外松开
        //   document.addEventListener("mouseup", that.onMouseUp);
        //   document.addEventListener("mousemove", that.onMouseMove);
        // }
    },
    handleNodeClick(data) {
        console.log(data);
    }
};
</script>
<style lang="less" scoped>
//导入全局的颜色
@import "~@css/var";

.patient {
    height: 100%;
    border: 1px solid #eee;
    .my-aside {
        background-color: rgb(238, 241, 246);
        .today_top {
            border: 1px solid rgb(167, 164, 164);
            height: 100%;
            box-sizing: border-box;
        }
    }
}

.el-header {
    background-color: rgb(235, 235, 235);
    line-height: 60px;
    margin-top: -10px;
}
// el-tabs__header is-top .move-line {
//   border: 1px solid rgb(235, 235, 235);
// }

.content-left {
    .left_top {
        border: 1px solid #d8d6d6;
        width: 365px;
        margin-right: 10px;
        height: 100%;
        box-sizing: border-box;

        .left_tab {
            position: relative;
            height: 100%;
            width: 100%;

            /deep/ .el-tabs__content {
                position: absolute;
                top: 40px;
                bottom: 0;
                left: 0;
                right: 0;
            }
        }
    }
}

.content-right {
    width: 100%;
    .right_top {
        margin-right: 10px;
        height: 100%;
        position: relative;
        box-sizing: border-box;

        /deep/ .el-tabs__content {
            position: absolute;
            top: 45px;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: white;
        }
    }
}

.visit-content {
    .visit-top-content {
        border: 1px solid #e3e3e3;
        padding: 5px 0px;
        position: relative;
    }
    .visit-bottom-content {
        margin-top: 800px;
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 60px;
        background-color: white;
    }
}

// .patient-content {
// }

.el-button {
    margin-left: 40px;
    margin-top: 10px;
    width: 120px;
}
//  /deep/ .el-table{

//        position: relative;
//        height: 100%;
// }
</style>