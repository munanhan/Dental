<template>
    <div class="statistics">
        <el-tabs
            v-model="activeName"
            @tab-click="handleClick"
        >
            <el-tab-pane
                label="诊所运营"
                name="clinicOperation"
            >
                <clinic-operation v-if="clinicOperation" :refresh.sync="clinicOperation"></clinic-operation>
            </el-tab-pane>

            <el-tab-pane
                label="收费对账"
                name="chargingReconciliation"
            >
                <charging-reconciliation v-if="chargingReconciliation" :refresh.sync="chargingReconciliation"></charging-reconciliation>
            </el-tab-pane>

            <el-tab-pane
                label="员工绩效"
                name="employeePerformance"
            >
                <employee-performance v-if="employeePerformance" :refresh.sync="employeePerformance"></employee-performance>
            </el-tab-pane>

            <el-tab-pane
                label="外加工"
                name="externalProcessing"
            >
                <external-processing v-if="externalProcessing" :refresh.sync="externalProcessing"></external-processing>
            </el-tab-pane>

            <el-tab-pane
                label="患者高级查询"
                name="advancedPatientInquiry"
            >
                <advanced-patient-inquiry v-if="advancedPatientInquiry" :refresh.sync="advancedPatientInquiry"></advanced-patient-inquiry>
            </el-tab-pane>

            <el-tab-pane
                label="连锁店统计"
                name="chainStoreStatistics"
            >
                <chain-storeStatistics v-if="chainStoreStatistics" :refresh.sync="chainStoreStatistics"></chain-storeStatistics>
            </el-tab-pane>
            <el-tab-pane
                label="微信运营"
                name="wechatOperation"
            >
                <wechat-operation v-if="wechatOperation" :refresh.sync="wechatOperation"></wechat-operation>

            </el-tab-pane>
            <el-tab-pane
                label="客流分析"
                name="passengerFlowAnalysis"
            >
                <passenger-flowAnalysis v-if="passengerFlowAnalysis" :refresh.sync="passengerFlowAnalysis"></passenger-flowAnalysis>
            </el-tab-pane>

        </el-tabs>
    </div>
</template>

<script>
import AdvancedPatientInquiry from "./advance_patient/AdvancedPatientInquiry";
import ChainStoreStatistics from "./chain_store/ChainStoreStatistics";
import ChargingReconciliation from "./charging_recon/ChargingReconciliation";
import ClinicOperation from "./clinic_operation/ClinicOperation";
import EmployeePerformance from "./employee_perform/EmployeePerformance";
import ExternalProcessing from "./external_process/ExternalProcessing";
import PassengerFlowAnalysis from "./passenger_flow/PassengerFlowAnalysis";
import WechatOperation from "./wechat_operation/WechatOperation";

export default {
    name: "Statistics",
    components: {
        AdvancedPatientInquiry,
        ChainStoreStatistics,
        ChargingReconciliation,
        ClinicOperation,
        EmployeePerformance,
        ExternalProcessing,
        PassengerFlowAnalysis,
        WechatOperation
    },
    props: {},
    data() {
        return {
            activeName: "clinicOperation",

            advancedPatientInquiry: false,
            chainStoreStatistics: false,
            chargingReconciliation: false,
            clinicOperation: false,
            employeePerformance: false,
            externalProcessing: false,
            passengerFlowAnalysis: false,
            wechatOperation: false
        };
    },
    created() {},
    mounted() {},
    watch: {
        activeName: {
            handler(newValue, oldValue) {
                let that = this;
                that[newValue] = true;
            },

            immediate: true
        }
    },
    computed: {},
    methods: {
        handleClick(tab, event) {
            // console.log(tab, event);
        }
    }
};
</script>
<style lang="less" scoped>
.statistics {
    height: 100%;

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

    /deep/ .el-tabs__content {
        background-color: white;
        // padding: 15px 0;
        position: absolute;
        top: 40px;
        bottom: 0;
        left: 0;
        box-sizing: border-box;
        right: 0;

        .el-tab-pane {
            height: 100%;
        }
    }
}
</style>