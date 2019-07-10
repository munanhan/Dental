<template>
    <el-container class="patient">
        <div class="content-left">
            <div class="left_top">
                <el-tabs
                    v-model="activeName"
                    class="left_tab"
                >
                    <el-tab-pane
                        :label="dayStatusWork"
                        name="first"
                        class="work-content"
                        v-if="$check_pm('patients_today_work')"
                    >

                        <div class="work-top-content">
                            <div
                                class="work-content-top1"
                                @click="changeWorkdate('prev')"
                            >
                                <i class="fa fa-angle-left"></i>
                            </div>

                            <div
                                class="work-content-top2"
                                @click="changeWorkdate('today')"
                            >今</div>

                            <div
                                class="work-content-top3"
                                @click="changeWorkdate('next')"
                            >
                                <i class="fa fa-angle-right"></i>
                            </div>
                            <!-- <el-date-picker
                                class="work-data"
                                v-model="value1"
                                type="date"
                                placeholder="选择日期"
                            >
                            </el-date-picker> -->
                            <el-date-picker
                                v-model="workdate"
                                type="date"
                                format="yyyy-MM-dd"
                                value-format="yyyy-MM-dd"
                                :clearable="false"
                                class="work-data"
                            >
                            </el-date-picker>

                        </div>
                        <div style="background-color:#efefef">
                            <div
                                class="work-item"
                                @select="selectHandler"
                            >
                                <div class="work-select">
                                    <div
                                        @click="expend('appointmentExpend')"
                                        class="work-title"
                                    >
                                        <i
                                            class="el-icon-caret-right"
                                            :class="{'down': appointmentExpend}"
                                        ></i>
                                        预约未到({{appointCount}})</div>
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
                                            <div
                                                class="work-background"
                                                :class="{ 'active': item.id == selectItem }"
                                                @click="isSelect(item.id)"
                                            >
                                                <div class="work-background-top">
                                                    <span class="work-top1">{{item.patient_name}}</span>
                                                    <span class="work-top2">{{item.member_id}}</span>
                                                    <span class="work-top3">{{item.appointment_date}}</span>
                                                </div>
                                                <div class="work-background-bottom">
                                                    <span class="work-bottom">{{item.patient_phone}}</span>
                                                    <span class="work-bottom">{{item.appointment_doctor}}</span>
                                                    {{item.case_id}}
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="work-select">
                                    <div
                                        class="work-title"
                                        @click="expend('diagnosisExpend')"
                                    >
                                        <i
                                            class="el-icon-caret-right"
                                            :class="{'down': diagnosisExpend}"
                                        ></i> {{dayStatus}}初诊({{todayFirst}})</div>
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
                                            <div
                                                class="work-background"
                                                :class="{ 'active': item.id == selectItem }"
                                                @click="isSelect(item.id)"
                                            >
                                                <div class="work-background-top">
                                                    <span class="work-top1">{{item.patient_name}}</span>
                                                    <span class="work-top2">{{item.member_id}}</span>
                                                    <span class="work-top3">{{item.appointment_date}}</span>
                                                </div>
                                                <div class="work-background-bottom">
                                                    <span class="work-bottom">{{item.patient_phone}}</span>
                                                    <span class="work-bottom">{{item.appointment_doctor}}</span>
                                                    {{item.case_id}}
                                                </div>
                                            </div>
                                        </li>

                                    </ul>
                                </div>
                                <div class="work-select">
                                    <div
                                        class="work-title"
                                        @click="expend('visitExpend')"
                                    >
                                        <i
                                            class="el-icon-caret-right"
                                            :class="{'down': visitExpend}"
                                        ></i> {{dayStatus}}复诊({{todaySub}})</div>
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
                                            <div
                                                class="work-background"
                                                :class="{ 'active': item.id == selectItem }"
                                                @click="isSelect(item.id)"
                                            >
                                                <div class="work-background-top">
                                                    <span class="work-top1">{{item.patient_name}}</span>
                                                    <span class="work-top2">{{item.member_id}}</span>
                                                    <span class="work-top3">{{item.appointment_date}}</span>
                                                </div>
                                                <div class="work-background-bottom">
                                                    <span class="work-bottom">{{item.patient_phone}}</span>
                                                    <span class="work-bottom">{{item.appointment_doctor}}</span>
                                                    {{item.case_id}}
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
                        v-if="$check_pm('patients_all')"
                    >
                        <div class="top-content">
                            <el-select
                                v-model="patientSearch.flag"
                                placeholder="患者信息"
                                class="patient-infor"
                                @change="dialogshow(patientSearch.flag)"
                            >
                                <el-option
                                    v-for="item in options"
                                    :key="item.id"
                                    :label="item.type"
                                    :value="item.id"
                                >
                                </el-option>
                            </el-select>
                            <el-input
                                v-model="patientSearch.keywords"
                                class="patient-input"
                                :placeholder="placeholder"
                                suffix-icon="el-icon-search"
                            ></el-input>
                            <i class="fa fa-sort-alpha-down patient-i"></i>
                        </div>

                        <div style="background-color:#efefef">
                            <div
                                class="patient-item"
                                style="height:735px;overflow:auto"
                            >
                                <div class="patient-select">
                                    <div
                                        @click="expend('patientExpend')"
                                        class="patient-title"
                                    >
                                        <i
                                            class="el-icon-caret-right"
                                            :class="{'down': patientExpend}"
                                        ></i>
                                        最近患者({{recentCount}})</div>
                                    <!-- /// -->
                                    <ul
                                        style="margin-top:-2px;"
                                        v-if="patientExpend"
                                        ref="item1"
                                    >
                                        <li
                                            v-for="(item, index) in patientsRecent"
                                            :key="index"
                                        >
                                            <div
                                                class="patient-background"
                                                :class="{ 'active': item.id == selectItem }"
                                                @click="isSelect(item.id)"
                                            >
                                                <div class="patient-background-top">
                                                    <span class="patient-top1">{{item.patient_name}}</span>
                                                    <span class="patient-top2">{{item.member_id}}</span>
                                                    <span class="patient-top3">{{item.appointment_date}}</span>
                                                </div>
                                                <div class="patient-background-bottom">
                                                    <span class="patient-bottom1">{{item.patient_phone}}</span>
                                                    <span class="patient-bottom2">{{item.appointment_doctor}}</span>
                                                    {{item.medical_record}}
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="patient-select">
                                    <div
                                        class="patient-title"
                                        @click="expend('blackExpend')"
                                    >
                                        <i
                                            class="el-icon-caret-right"
                                            :class="{'down': blackExpend}"
                                        ></i> 黑名单({{blackCount}})</div>
                                    <!-- /// -->
                                    <ul
                                        style="margin-top:-2px;"
                                        v-if="blackExpend"
                                        ref="item1"
                                    >
                                        <li
                                            v-for="(item,index) in blacklist"
                                            :key="index"
                                        >
                                            <div
                                                class="patient-background"
                                                :class="{ 'active': item.id == selectItem }"
                                                @click="isSelect(item.id)"
                                            >
                                                <div class="patient-background-top">
                                                    <span class="patient-top1">{{item.patient_name}}</span>
                                                    <span class="patient-top2">{{item.member_id}}</span>
                                                    <span class="patient-top3">{{item.appointment_date}}</span>
                                                </div>
                                                <div class="patient-background-bottom">
                                                    <span class="patient-bottom1">{{item.patient_phone}}</span>
                                                    <span class="patient-bottom2">{{item.appointment_doctor}}</span>
                                                    {{item.blacklist_record}}
                                                </div>
                                            </div>
                                        </li>

                                    </ul>
                                </div>
                                <div class="patient-select">
                                    <div
                                        class="patient-title"
                                        @click="expend('treatmentExpend')"
                                    >
                                        <i
                                            class="el-icon-caret-right"
                                            :class="{'down': treatmentExpend}"
                                        ></i> 治疗完成({{completeCount}})</div>
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
                                            <div
                                                class="patient-background"
                                                :class="{ 'active': item.id == selectItem }"
                                                @click="isSelect(item.id)"
                                            >
                                                <div class="patient-background-top">
                                                    <span class="patient-top1">{{item.patient_name}}</span>
                                                    <span class="patient-top2">{{item.member_id}}</span>
                                                    <span class="patient-top3">{{item.appointment_date}}</span>
                                                </div>
                                                <div class="patient-background-bottom">
                                                    <span class="patient-bottom1">{{item.patient_phone}}</span>
                                                    <span class="patient-bottom2">{{item.appointment_doctor}}</span>
                                                    {{item.medical_record}}
                                                </div>
                                            </div>
                                        </li>

                                    </ul>
                                </div>
                                <!-- // -->
                            </div>

                        </div>
                        <div class="bottom-content">
                            <el-button
                                type="primary"
                                @click="add_patient"
                            >新增患者</el-button>
                            <el-button @click="app_visit">复诊预约</el-button>
                        </div>
                    </el-tab-pane>

                    <el-tab-pane
                        label="最近访问"
                        name="visit"
                        class="visit-content"
                        v-if="$check_pm('patients_recent_visit')"
                    >
                        <div class="visit-top-content">
                            <el-input
                                style="width:300px;margin-left:10px;"
                                v-model="search"
                                placeholder="姓名、电话"
                                suffix-icon="el-icon-search"
                            ></el-input>
                        </div>
                        <div style="height:750px;overflow:auto">
                            <div
                                v-for="(item,index) in access"
                                :key="index"
                                class="visit-background"
                                :class="{ 'active': item.id == selectItem }"
                                @click="isSelect(item.id)"
                            >
                                <div
                                    class="visit-background-top"
                                    style="margin-top:5px"
                                >
                                    <span class="visit-top1">{{item.patient_name}}</span>
                                    <span class="visit-top2">{{item.member_id}}</span>
                                    <span class="visit-top3">{{item.appointment_date}}</span>
                                </div>
                                <div class="visit-background-bottom">
                                    <span class="visit-bottom1">{{item.patient_phone}}</span>
                                    <span class="visit-bottom2">{{item.appointment_doctor}}</span>
                                    <span class="visit-bottom3">{{item.record}}</span>
                                </div>

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
                    v-if="$check_pm('patients_info')"
                >
                    <patient-info
                        v-if="pationInfo"
                        :refresh.sync="pationInfo"
                        :patientInfo="selectPatientInfo"
                    >

                    </patient-info>

                </el-tab-pane>

                <el-tab-pane
                    label="就诊信息"
                    name="medicalInformation"
                    v-if="$check_pm('patients_medical_information')"
                >
                    <medical-information
                        v-if="medicalInformation"
                        :refresh.sync="medicalInformation"
                        :medicalInformation="selectPatient"
                        :selectID="selectItem"
                    ></medical-information>
                </el-tab-pane>

                <el-tab-pane
                    label="预约信息"
                    name="bookingInformation"
                    v-if="$check_pm('patients_appoint_information')"
                >
                    <booking-information
                        v-if="bookingInformation"
                        :refresh.sync="bookingInformation"
                        :bookingInformation="selectPatient"
                        :selectID="selectItem"
                    ></booking-information>
                </el-tab-pane>

                <el-tab-pane
                    label="处置记录"
                    name="disposalRecords"
                    v-if="$check_pm('patients_disposal')"
                >
                    <disposal-records
                        v-if="disposalRecords"
                        :refresh.sync="disposalRecords"
                        :selectID="selectItem"
                    ></disposal-records>
                </el-tab-pane>

                <el-tab-pane
                    label="收费信息"
                    name="chargeInfo"
                    v-if="$check_pm('patients_charge')"
                >
                    <charge-info
                        v-if="chargeInfo"
                        :refresh.sync="chargeInfo"
                        :charInfo="selectPatient"
                        :selectID="selectItem"
                    ></charge-info>
                </el-tab-pane>

                <el-tab-pane
                    label="病历信息"
                    name="medicalRecordsInfo"
                    v-if="$check_pm('patients_case')"
                >
                    <medical-records-info
                        v-if="medicalRecordsInfo"
                        :refresh.sync="medicalRecordsInfo"
                        :medicalInfo="selectPatient"
                        :selectID="selectItem"
                    ></medical-records-info>
                </el-tab-pane>

                <el-tab-pane
                    label="回访信息"
                    name="returnVisitInfo"
                    v-if="$check_pm('patients_visit')"
                >
                    <return-visit-info
                        v-if="returnVisitInfo"
                        :refresh.sync="returnVisitInfo"
                        :visitInfo="selectPatient"
                        :selectPatientID="selectItem"
                    ></return-visit-info>
                </el-tab-pane>

                <el-tab-pane
                    label="咨询信息"
                    name="consultingInfo"
                    v-if="$check_pm('patients_consult')"
                >
                    <consulting-info
                        v-if="consultingInfo"
                        :refresh.sync="consultingInfo"
                        :consultInfo="selectPatient"
                        :selectID="selectItem"
                    ></consulting-info>
                </el-tab-pane>
            </el-tabs>
        </div>
        <!-- 新增患者 -->
        <add-patient
                :show.sync="addp_show"
                :addPatient="add_patient_resource"
        ></add-patient>

        <!-- 复诊预约 -->
        <appointment-visit :show.sync="appvisit_show"></appointment-visit>

        <!-- <advanced-query :show.sync="advancedque_show"></advanced-query> -->
    </el-container>

</template>

<script>
import { formatDate, addClass, inArray } from "@/common/util.js";
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
// import AdvancedQuery from "./AdvancedQuery";

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
        medicalInformation,
        // AdvancedQuery
    },

    props: {},

    data() {
        return {
            advancedque_show: false,
            selectPatient: [],
            selectPatientInfo:{},
            placeholder: "姓名、拼音、电话",
            patient_expend: false,
            input: "",
            search: "",
            curTab: "",
            activeName: "first",
            addp_show: false,
            appvisit_show: false,

            add_patient_resource:[],

            workdate: new Date(),
            //当天工作
            dayStatusWork: "今日工作",
            dayStatus: "今日",
            appointCount: "",
            todayFirst: "",
            todaySub: "",
            //全部患者
            recentCount: "",
            blackCount: "",
            completeCount: "",

            patientSearch: {
                flag: "",
                keywords: ""
            },

            options: [
                {
                    id: 1,
                    type: "患者信息"
                },
                {
                    id: 2,
                    type: "病历号"
                },
                {
                    id: 3,
                    type: "会员号"
                },
                // {
                //     id: 4,
                //     type: "检查医生"
                // }
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
            appointments: [],
            diagnosis: [],
            subsequent: [],

            //全部患者
            treatment: [],
            blacklist: [],
            patientsRecent: [],

            //最近访问
            access: [],

            //今日工作
            appointmentExpend: false,
            diagnosisExpend: false,
            visitExpend: false,
            //全部患者
            patientExpend: false,
            blackExpend: false,
            treatmentExpend: false,

            selectItem: null
        };
    },
    created() {
        let that = this;
        let whereTime = new Date();
        that.getTodayWork(whereTime);
    },

    mounted() {},
    watch: {
        activeName(newValue, oldValue) {
            let that = this;
            switch (newValue) {
                case "first":
                    that.getTodayWork();
                    break;
                case "patient":
                    that.getAllPatient();
                    break;
                case "visit":
                    that.getRecentVisit();
                    break;
            }
        },

        workdate(newValue, oldValue) {
            let newV = formatDate(newValue, "yyyy-MM-dd"),
                now = formatDate(new Date(), "yyyy-MM-dd");

            newV == now
                ? (this.dayStatusWork = "今日工作")
                : (this.dayStatusWork = "当日工作");
            newV == now ? (this.dayStatus = "今日") : (this.dayStatus = "当日");
            let that = this;
            that.getTodayWork();
        },

        curTab(newValue, oldValue) {
            let that = this;

            if (that.selectItem == null) {
                return false;
            }

            that.getSwitch(newValue);
        }

    },
    computed: {},
    methods: {
        dialogshow(value) {
            switch (value) {
                case 1:
                    this.placeholder = "姓名、拼音、电话";
                    break;
                case 2:
                    this.placeholder = "病历号";
                    break;
                case 3:
                    this.placeholder = "会员号";
                    break;
                // case 4:
                //     this.advancedque_show = true;
                //     break;
            }
            // this[value] = true;
            // this.value = "";
        },

        getSwitch(module) {
            let that = this;
            let params = {};
            params.id = that.selectItem;

            switch (module) {
                case "pationInfo":
                    that.getPatientData("patient", "getPatientByID", params, module);
                    break;

                case "medicalInformation":
                    that.getPatientData("patient", "treat", params, module);
                    break;

                case "bookingInformation":
                    that.getPatientData("patient", "appoint", params, module);
                    break;

                case "disposalRecords":
                    that.getPatientData("patient_disposal", "get", params, module);
                    break;

                case "chargeInfo":
                    that.getPatientData("patient_charge", "get", params, module);
                    break;

                case "medicalRecordsInfo":
                    that.getPatientData("patient_case", "get", params, module);
                    break;

                case "returnVisitInfo":
                    that.getPatientData("patient_visit", "get", params, module);
                    break;

                case "consultingInfo":
                    that.getPatientData("patient_consult", "getByPatientId", params, module);
                    break;
            }
        },

        getPatientData(url, method, data, module) {
            let that = this;

            console.log(url, method, data, module)

            that.$api[url][method](data)
                .then(res => {
                    if (res.code == 200) {
                        switch (module){
                            case "pationInfo":
                                that.selectPatientInfo = res.data;
                                that[module] = true;
                                break;
                            default:
                                that.selectPatient = res.data;
                                that[module] = true;
                                break;
                        }
                    }
                })
                .catch(res => {
                    console.log(res);
                });
        },

        //获取id
        isSelect(id) {
            let that = this;
            //选中
            that.selectItem = id;

            that.getSwitch(that.curTab);
        },

        //获取最近访问
        getRecentVisit() {
            let that = this;
            that.$api.patient
                .recentVisit()
                .then(res => {
                    if (res.code == 200) {
                        that.access = res.data;
                    } else {
                        console.log(res.msg);
                    }
                })
                .catch(res => {
                    console.log(res.msg);
                });
        },
        //获取全部患者
        getAllPatient() {
            let that = this;
            that.$api.patient
                .index(that.patientSearch)
                .then(res => {
                    if (res.code == 200) {
                        that.patientsRecent = res.data.recentPatient;
                        that.recentCount = that.patientsRecent.length;

                        that.blacklist = res.data.blacklistPatient;
                        that.blackCount = that.blacklist.length;

                        that.treatment = res.data.completePatient;
                        that.completeCount = that.treatment.length;
                    } else {
                        console.log(res.msg);
                    }
                })
                .catch(res => {
                    console.log(res.msg);
                });
        },
        //获取今日工作
        getTodayWork() {
            let that = this;
            let params = {};
            params.whereTime =
                typeof that.workdate == "object"
                    ? that.workdate.toLocaleDateString()
                    : that.workdate;
            that.$api.patient
                .todayWork(params)
                .then(res => {
                    if (res.code == 200) {
                        that.appointments = res.data.appointmentNotArrive;
                        that.diagnosis = res.data.todayFirstVisit;
                        that.subsequent = res.data.todaySubsequentVisit;
                        that.appointCount = that.appointments.length;
                        that.todayFirst = that.diagnosis.length;
                        that.todaySub = that.subsequent.length;
                    } else {
                        console.log(res.msg);
                    }
                })
                .catch(res => {
                    console.log(res.msg);
                });
        },

        selectHandler(index) {
            let that = this;
            that.content.chargeDetail = "chargeDetail" == index;
            that.chargeDetailUpdate = "chargeDetail" == index;

            that.content.projectConsumption = "projectConsumption" == index;
            that.projectConsumptionUpdate = "projectConsumption" == index;
        },
        //改变时间日期
        changeWorkdate(i) {
            switch (i) {
                case "prev":
                    this.workdate = new Date(
                        +new Date(this.workdate) - 3600 * 24 * 1000
                    );

                    break;
                case "next":
                    this.workdate = new Date(
                        +new Date(this.workdate) + 3600 * 24 * 1000
                    );

                    break;
                case "today":
                    this.workdate = new Date();

                    break;
            }
        },
        expend(type) {
            let that = this;
            that[type] = !that[type];
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
            let that=this;
            that.patientResource();
        },

        patientResource() {
            let that=this;
            that.$api.patient.getPatientResource()
                .then(res=>{
                    if(res.code==200){
                        that.add_patient_resource=res.data;
                        that.addp_show = true;
                    }else {
                        console.log(res);
                    }
                })
                .catch(res=>{
                    console.log(res);
                })
        },
        //
        app_visit() {
            this.appvisit_show = true;
        }
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

    /deep/ .el-tabs {
        position: relative;
        height: 100%;
    }

    /deep/ .el-tabs__header {
        margin-bottom: 0;
        .el-tabs__nav-scroll {
            padding-left: 20px;
        }
    }

    // /deep/ .el-tabs__content {
    //     background-color: white;
    //     // padding: 15px 0;
    //     position: absolute;
    //     top: 40px;
    //     bottom: 0;
    //     left: 0;
    //     box-sizing: border-box;
    //     right: 0;

    //     .el-tab-pane {
    //         height: 100%;
    //     }
    // }
}

.el-header {
    background-color: #ebebeb;
    line-height: 60px;
    margin-top: -10px;
}

.content-left {
    .left_top {
        border: 1px solid #d8d6d6;
        width: 365px;
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
            .patient-content {
                .top-content {
                    border: 1px solid #e3e3e3;
                    padding: 5px 0px;
                    display: flex;
                    .patient-infor {
                        width: 105px;
                        padding-left: 5px;
                    }
                    .patient-input {
                        width: 200px;
                        padding-left: 5px;
                    }
                    .patient-i {
                        margin-left: 5px;
                        margin-top: 5px;
                        color: #8f8f8f;
                        font-size: 30px;
                        cursor: pointer;
                        &:hover {
                            color: #525252;
                        }
                    }
                }
                .bottom-content {
                    position: absolute;
                    left: 0;
                    bottom: 0;
                    width: 100%;
                    height: 60px;
                    background-color: white;
                }
            }
        }
    }
    .work-item {
        .work-select {
            cursor: pointer;
            margin-bottom: 10px;
        }
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

            &.active {
                background-color: #eeffcd;
            }
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
        .patient-select {
            cursor: pointer;
            margin-bottom: 10px;
        }
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
            transition: 0.2s all;

            &.active {
                background-color: #eeffcd;
            }

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
            top: 40px;
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

    .visit-background {
        border: 1px solid #bababa;
        background-color: white;
        margin-right: 10px;
        cursor: pointer;
        border-left-width: 10px;
        margin-left: 10px;
        margin-top: 10px;
        height: 60px;
        &.active {
            background-color: #eeffcd;
        }
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
            // .visit-bottom1 {
            // }
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
    .visit-bottom-content {
        margin-top: 800px;
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 60px;
        background-color: white;
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