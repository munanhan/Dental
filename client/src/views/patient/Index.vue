<template>
    <el-container class="patient">
        <div class="content-left">
            <div class="left_top">
                <el-tabs
                    v-model="activeName"
                    class="left_tab"
                >
                    <el-tab-pane
                        label="当天工作"
                        name="first"
                        class="work-content"
                    >

                        <div class="work-top-content">
                            <div class="work-content-top1">
                                <i class="fa fa-angle-left"></i>
                            </div>

                            <div class="work-content-top2">今</div>

                            <div class="work-content-top3">
                                <i class="fa fa-angle-right"></i>
                            </div>
                            <el-date-picker
                                class="work-data"
                                v-model="value1"
                                type="date"
                                placeholder="选择日期"
                            >
                            </el-date-picker>

                        </div>
                        <div style="background-color:#efefef">
                            <div class="work-item">
                                <div style="cursor: pointer;margin-bottom:10px">
                                    <div
                                        @click="expend('appointmentExpend')"
                                        class="work-title"
                                    >
                                        <i
                                            class="el-icon-caret-right"
                                            :class="{'down': appointmentExpend}"
                                        ></i>
                                        预约未到(4)</div>
                                    <!-- /// -->
                                    <ul
                                        style="margin-top:-2px"
                                        v-if="appointmentExpend"
                                        ref="item1"
                                    >
                                        <li
                                            v-for="(item,index) in appointments"
                                            :key="index"
                                        >
                                            <div class="work-background">
                                                <div class="work-background-top">
                                                    <span class="work-top1">{{item.appointment_case_id}}</span>
                                                    <span class="work-top2">{{item.appointment_history}}</span>
                                                    <span class="work-top3">{{item.appointment_date}}</span>
                                                </div>
                                                <div class="work-background-bottom">
                                                    <span class="work-bottom">{{item.appointment_phone}}</span>
                                                    <span class="work-bottom">{{item.appointment_doctor}}</span>
                                                    {{item.appointment_record}}
                                                </div>
                                            </div>
                                        </li>

                                    </ul>
                                </div>
                                <div style="cursor: pointer;margin-bottom:10px">
                                    <div
                                        class="work-title"
                                        @click="expend('diagnosisExpend')"
                                    >
                                        <i
                                            class="el-icon-caret-right"
                                            :class="{'down': diagnosisExpend}"
                                        ></i> 当天初诊(1)</div>
                                    <!-- /// -->
                                    <ul
                                        style="margin-top:-2px"
                                        v-if="diagnosisExpend"
                                        ref="item1"
                                    >
                                        <li
                                            v-for="(item,index) in diagnosis"
                                            :key="index"
                                        >
                                            <div class="work-background">
                                                <div class="work-background-top">
                                                    <span class="work-top1">{{item.diagnosi_case_id}}</span>
                                                    <span class="work-top2">{{item.diagnosi_history}}</span>
                                                    <span class="work-top3">{{item.diagnosi_date}}</span>
                                                </div>
                                                <div class="work-background-bottom">
                                                    <span class="work-bottom">{{item.diagnosi_phone}}</span>
                                                    <span class="work-bottom">{{item.diagnosi_doctor}}</span>
                                                    {{item.diagnosi_record}}
                                                </div>
                                            </div>
                                        </li>

                                    </ul>
                                </div>
                                <div style="cursor: pointer;margin-bottom:10px">
                                    <div
                                        class="work-title"
                                        @click="expend('visitExpend')"
                                    >
                                        <i
                                            class="el-icon-caret-right"
                                            :class="{'down': visitExpend}"
                                        ></i> 当天复诊(0)</div>
                                    <!-- /// -->
                                    <ul
                                        style="margin-top:-2px"
                                        v-if="visitExpend"
                                        ref="item1"
                                    >
                                        <li
                                            v-for="(item,index) in subsequent"
                                            :key="index"
                                        >
                                            <div class="work-background">
                                                <div class="work-background-top">
                                                    <span class="work-top1">{{item.subsequent_case_id}}</span>
                                                    <span class="work-top2">{{item.subsequent_history}}</span>
                                                    <span class="work-top3">{{item.subsequent_date}}</span>
                                                </div>
                                                <div class="work-background-bottom">
                                                    <span class="work-bottom">{{item.subsequent_phone}}</span>
                                                    <span class="work-bottom">{{item.subsequent_doctor}}</span>
                                                    {{item.subsequent_record}}
                                                </div>
                                            </div>
                                        </li>

                                    </ul>
                                </div>
                                <!-- // -->
                            </div>
                        </div>
                        <div class="work-bottom-content">
                            <el-button
                                type="primary"
                                @click="add_patient"
                            >新增患者</el-button>
                            <el-button @click="app_visit">复诊预约</el-button>
                        </div>
                    </el-tab-pane>
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

                            <!-- <div>
                                <el-tree
                                    style="height:100%;
                                           font-weight:bold;
                                           background-color:#efefef;"
                                    :data="data"
                                    :props="defaultProps"
                                ></el-tree>
                            </div> -->
                            <div style="background-color:#efefef">
                                <div class="patient-item">
                                    <div style="cursor: pointer;margin-bottom:10px">
                                        <div
                                            @click="expend('patientExpend')"
                                            class="patient-title"
                                        >
                                            <i
                                                class="el-icon-caret-right"
                                                :class="{'down': patientExpend}"
                                            ></i>
                                            最近患者(1)</div>
                                        <!-- /// -->
                                        <ul
                                            style="margin-top:-2px"
                                            v-if="patientExpend"
                                            ref="item1"
                                        >
                                            <li
                                                v-for="(item,index) in patientsRecent"
                                                :key="index"
                                            >
                                                <div class="patient-background">
                                                    <div class="patient-background-top">
                                                        <span class="patient-top1">{{item.case_id}}</span>
                                                        <span class="patient-top2">{{item.medical_history}}</span>
                                                        <span class="patient-top3">{{item.appointment_date}}</span>
                                                    </div>
                                                    <div class="patient-background-bottom">
                                                        <span class="patient-bottom1">{{item.patient_phone}}</span>
                                                        <span class="patient-bottom2">{{item.patient_doctor}}</span>
                                                        {{item.medical_record}}
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div style="cursor: pointer;margin-bottom:10px">
                                        <div
                                            class="patient-title"
                                            @click="expend('blackExpend')"
                                        >
                                            <i
                                                class="el-icon-caret-right"
                                                :class="{'down': blackExpend}"
                                            ></i> 黑名单(1)</div>
                                        <!-- /// -->
                                        <ul
                                            style="margin-top:-2px"
                                            v-if="blackExpend"
                                            ref="item1"
                                        >
                                            <li
                                                v-for="(item,index) in blacklist"
                                                :key="index"
                                            >
                                                <div class="patient-background">
                                                    <div class="patient-background-top">
                                                        <span class="patient-top1">{{item.blacklist_case_id}}</span>
                                                        <span class="patient-top2">{{item.blacklist_history}}</span>
                                                        <span class="patient-top3">{{item.blacklist_date}}</span>
                                                    </div>
                                                    <div class="patient-background-bottom">
                                                        <span class="patient-bottom1">{{item.blacklist_phone}}</span>
                                                        <span class="patient-bottom2">{{item.blacklist_doctor}}</span>
                                                        {{item.blacklist_record}}
                                                    </div>
                                                </div>
                                            </li>

                                        </ul>
                                    </div>
                                    <div style="cursor: pointer;margin-bottom:10px">
                                        <div
                                            class="patient-title"
                                            @click="expend('treatmentExpend')"
                                        >
                                            <i
                                                class="el-icon-caret-right"
                                                :class="{'down': treatmentExpend}"
                                            ></i> 治疗完成(1)</div>
                                        <!-- /// -->
                                        <ul
                                            style="margin-top:-2px"
                                            v-if="treatmentExpend"
                                            ref="item1"
                                        >
                                            <li
                                                v-for="(item,index) in treatment"
                                                :key="index"
                                            >
                                                <div class="patient-background">
                                                    <div class="patient-background-top">
                                                        <span class="patient-top1">{{item.case_id}}</span>
                                                        <span class="patient-top2">{{item.medical_history}}</span>
                                                        <span class="patient-top3">{{item.appointment_date}}</span>
                                                    </div>
                                                    <div class="patient-background-bottom">
                                                        <span class="patient-bottom1">{{item.patient_phone}}</span>
                                                        <span class="patient-bottom2">{{item.patient_doctor}}</span>
                                                        {{item.medical_record}}
                                                    </div>
                                                </div>
                                            </li>

                                        </ul>
                                    </div>
                                    <!-- // -->
                                </div>

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
                        <div
                            v-for="(item,index) in access"
                            :key="index"
                            class="visit-background"
                        >
                            <div
                                class="visit-background-top"
                                style="margin-top:5px"
                            >
                                <span class="visit-top1">{{item.access_case_id}}</span>
                                <span class="visit-top2">{{item.access_history}}</span>
                                <span class="visit-top3">{{item.access_date}}</span>
                            </div>
                            <div class="visit-background-bottom">
                                <span class="visit-bottom1">{{item.access_phone}}</span>
                                <span class="visit-bottom2">{{item.access_doctor}}</span>
                                <span class="visit-bottom3">{{item.access_record}}</span>
                            </div>

                        </div>
                        <div class="visit-bottom-content">
                            <el-button
                                type="primary"
                                @click="add_patient"
                            >新增患者</el-button>
                            <el-button @click="app_visit">复诊预约</el-button>
                        </div>
                    </el-tab-pane>
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
                    name="medicalInformation"
                >
                    <medical-information
                        v-if="medicalInformation"
                        :refresh.sync="medicalInformation"
                    ></medical-information>
                </el-tab-pane>

                <el-tab-pane
                    label="预约信息"
                    name="bookingInformation"
                >
                    <booking-information
                        v-if="bookingInformation"
                        :refresh.sync="bookingInformation"
                    ></booking-information>
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
import BookingInformation from "./BookingInformation";
import medicalInformation from "./medicalInformation";

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
        ConsultingInfo,
        BookingInformation,
        medicalInformation
    },

    props: {},

    data() {
        return {
            patient_expend: false,
            input: "",
            search: "",
            curTab: "pationInfo",
            activeName: "first",
            addp_show: false,
            appvisit_show: false,
            //   pationRefresh: false,
            //   disposalRecordsRefresh: false,

            //   quickFind: {
            // 	pationInfo: "pationRefresh",
            // 	disposalRecords: "disposalRecordsRefresh"

            //   },
            value1: "",

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
            bookingInformation: false,
            medicalInformation: false,

            //当天工作
            appointments: [
                {
                    appointment_case_id: "石先生",
                    appointment_history: "史",
                    appointment_date: "上午 11:30",
                    appointment_phone: "13925814457",
                    appointment_doctor: "马医生",
                    appointment_record: "11002"
                },
                {
                    appointment_case_id: "陈先生",
                    appointment_history: "欠",
                    appointment_date: "2019-06-04",
                    appointment_phone: "13925814457",
                    appointment_doctor: "余医生",
                    appointment_record: "11003"
                },
                {
                    appointment_case_id: "刘先生",
                    appointment_history: "欠",
                    appointment_date: "2019-06-04",
                    appointment_phone: "13925814457",
                    appointment_doctor: "马医生",
                    appointment_record: "11003"
                },
                {
                    appointment_case_id: "韩先生",
                    appointment_history: "欠",
                    appointment_date: "2019-06-04",
                    appointment_phone: "13925814457",
                    appointment_doctor: "余医生",
                    appointment_record: "11003"
                }
            ],
            diagnosis: [
                {
                    diagnosi_case_id: "131313131",
                    diagnosi_history: "初",
                    diagnosi_date: "上午 11:30",
                    diagnosi_phone: "13925814457",
                    diagnosi_doctor: "马医生",
                    diagnosi_record: "21001"
                }
            ],
            subsequent: [
                {
                    subsequent_case_id: "1001",
                    subsequent_history: "vip",
                    subsequent_date: "1990-10-02",
                    subsequent_phone: "13423901332",
                    subsequent_doctor: "黄医生",
                    subsequent_record: "21001"
                }
            ],

            //全部患者
            patientsRecent: [
                {
                    recent_case_id: "15030101",
                    medical_history: "初",
                    appointment_date: "上午 11:30",
                    patient_phone: "13925814457",
                    patient_doctor: "马医生",
                    medical_record: "21001"
                }
            ],

            blacklist: [
                {
                    blacklist_case_id: "15030101",
                    blacklist_history: "vip",
                    blacklist_date: "2019-05-10",
                    blacklist_phone: "13925814457",
                    blacklist_doctor: "石医生",
                    blacklist_record: "21001"
                }
            ],

            treatment: [
                {
                    case_id: "马先生",
                    medical_history: "vip",
                    appointment_date: "2019-05-10",
                    patient_phone: "15304890744",
                    patient_doctor: "石医生",
                    medical_record: "21001"
                }
            ],
            access: [
                {
                    access_case_id: "李先生",
                    access_history: "vip",
                    access_date: "2019-06-01",
                    access_phone: "13920578841",
                    access_doctor: "孔先生",
                    access_record: "1503010120"
                }
            ],
            //最近访问
            appointmentExpend: false,
            diagnosisExpend: false,
            visitExpend: false,
            //全部患者
            patientExpend: false,
            blackExpend: false,
            treatmentExpend: false
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
        expend(type) {
            let that = this;
            that[type] = !that[type];

            // if (!patient_expend) {
            //     this.patient_expend = true;
            // } else {
            //     this.patient_expend = false;
            // }
        },

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
        background-color: #eef1f6;
        .today_top {
            border: 1px solid #a7a4a4;
            height: 100%;
            box-sizing: border-box;
        }
    }
}

.el-header {
    background-color: #ebebeb;
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
    .work-item {
        ul,
        li {
            list-style: none;
            margin: 0;
            padding: 0;
            margin-left: 10px;
            margin-top: 7px;
        }

        .work-title {
            i {
                transition: all 0.2s;

                &.down {
                    transform: rotate(90deg);
                }
            }
            &:hover {
                color: #757575;
            }
        }
        .work-background {
            border: 1px solid #bababa;
            background-color: white;
            margin-right: 10px;
            border-left-width: 10px;
            height: 60px;
            .work-background-top {
                margin-bottom: 20px;
                margin-left: 10px;
                .work-top1 {
                    // margin-right: 100px;
                    font-weight: bold;
                    color: #000;
                }
                .work-top2 {
                    // margin-right: 120px;
                    margin-left: 10px;
                    background-color: #d30f0f;
                    font-size: 10px;
                    color: white;
                }
                .work-top3 {
                    color: #747474;
                    font-size: 13px;
                    float: right;
                    margin-right: 5px;
                }
            }
            .work-background-bottom {
                margin-left: 30px;
                font-size: 14px;
                color: #747474;
                .work-bottom {
                    margin-right: 20px;
                }
            }
            &:hover {
                color: @color;
                border-color: @color;
            }
        }
    }
    .patient-item {
        ul,
        li {
            list-style: none;
            margin: 0;
            padding: 0;
            margin-left: 5px;
            margin-top: 7px;
        }

        .patient-title {
            i {
                transition: all 0.2s;

                &.down {
                    transform: rotate(90deg);
                }
            }
            &:hover {
                color: #747474;
            }
        }
        .patient-background {
            border: 1px solid #bababa;
            background-color: white;
            margin-right: 10px;
            border-left-width: 10px;
            height: 60px;
            .patient-background-top {
                margin-bottom: 20px;
                margin-left: 10px;
                .patient-top1 {
                    font-weight: bold;
                    color: #000;
                }
                .patient-top2 {
                    margin-left: 10px;
                    background-color: #d30f0f;
                    font-size: 10px;
                    color: white;
                }
                .patient-top3 {
                    color: #747474;
                    font-size: 13px;
                    float: right;
                    margin-right: 5px;
                }
            }
            .patient-background-bottom {
                margin-left: 30px;
                font-size: 14px;
                color: #747474;
                .patient-bottom1 {
                    margin-right: 20px;
                }
                .patient-bottom2 {
                    margin-right: 20px;
                }
            }
            &:hover {
                color: @color;
                border-color: @color;
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
        display: flex;
        padding: 5px 0px;
        position: relative;
        .visit-data {
            width: 230px;
        }
    }

    .visit-bottom-content {
        margin-top: 800px;
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 60px;
        background-color: white;
    }
    .visit-background {
        border: 1px solid #bababa;
        background-color: white;
        margin-right: 10px;
        cursor: pointer;
        border-left-width: 10px;
        margin-left: 10px;
        margin-top: 10px;
        height: 60px;
        .visit-background-top {
            .visit-top1 {
                font-weight: bold;
                color: #000;
                margin-left: 10px;
            }
            .visit-top2 {
                margin-left: 5px;
                background-color: #d30f0f;
                font-size: 10px;
                color: white;
            }
            .visit-top3 {
                color: #747474;
                float: right;
                margin-right: 10px;
                font-size: 13px;
            }
        }
        .visit-background-bottom {
            margin-left: 30px;
            font-size: 14px;
            color: #747474;
            margin-top: 15px;
            .visit-bottom1 {
            }
            .visit-bottom2 {
                margin-left: 20px;
            }
            .visit-bottom3 {
                margin-left: 40px;
            }
        }
        &:hover {
            border-color: @color;
        }
    }
}
.work-content {
    .work-top-content {
        border: 1px solid #e3e3e3;
        display: flex;
        padding: 5px 0px;
        position: relative;
        .work-content-top1 {
            cursor: pointer;
            margin-top: 10px;
            margin-left: 20px;
        }
        .work-content-top2 {
            cursor: pointer;
            margin-top: 10px;
            margin: 10px 20px;
            font-size: 18px;
            color: red;
        }
        .work-content-top3 {
            cursor: pointer;
            margin-top: 10px;
            margin-right: 15px;
        }

        .work-data {
            width: 230px;
        }
    }
    .work-bottom-content {
        margin-top: 800px;
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 60px;
        background-color: white;
    }
}
.el-button {
    margin-left: 40px;
    margin-top: 10px;
    width: 120px;
}
</style>