<template>

    <div class="setting">
        <el-tabs
            v-model="curTab"
        >

            <el-tab-pane
                label="诊所信息"
                name="ClinicInformation"
            >
                <clinic-information v-if="ClinicInformation" :refresh.sync="ClinicInformationUpdate"></clinic-information>

            </el-tab-pane>

            <el-tab-pane
                label="权限设置"
                name="PermissionSettings"
            >
                <permission-settings v-if="PermissionSettings" :refresh.sync="PermissionSettingsUpdate"></permission-settings>
            </el-tab-pane>

            <el-tab-pane
                label="员工管理"
                name="StaffManagement"
            >
                <staff-management v-if="StaffManagement" :refresh.sync="StaffManagementUpdate"></staff-management>
            </el-tab-pane>

            <el-tab-pane
                label="处置与收费"
                name="DisposalCharging"
            >
                <disposal-charging v-if="DisposalCharging" :refresh.sync="DisposalChargingUpdate"></disposal-charging>
            </el-tab-pane>

            <el-tab-pane
                label="处置组和"
                name="DisposalCombination"
            >
                <disposal-combination v-if="DisposalCombination" :refresh.sync="DisposalCombinationUpdate"></disposal-combination>
            </el-tab-pane>

            <el-tab-pane
                label="病例模板"
                name="CaseTemplate"
            >
                <case-template v-if="CaseTemplate" :refresh.sync="CaseTemplateUpdate"></case-template>
            </el-tab-pane>

            <el-tab-pane
                label="会员升级"
                name="MemberUpgrade"
            >
                <member-upgrade v-if="MemberUpgrade" :refresh.sync="MemberUpgradeUpdate"></member-upgrade>
            </el-tab-pane>

            <el-tab-pane
                label="患者回收站"
                name="PatientRecyclingBin"
            >
                <patient-recycling-bin v-if="PatientRecyclingBin" :refresh.sync="PatientRecyclingBinUpdate"></patient-recycling-bin>
            </el-tab-pane>

            <el-tab-pane
                label="操作记录"
                name="OperationRecord"
            >
                <operation-record v-if="OperationRecord" :refresh.sync="OperationRecordUpdate"></operation-record>
            </el-tab-pane>
        </el-tabs>

    </div>
</template>

<script>
import ClinicInformation from "./clinic_information/Index";
import PermissionSettings from "./permission_settings/Index";
import StaffManagement from "./staff_management/Index";
import DisposalCharging from "./disposal_charging/Index";
import DisposalCombination from "./disposal_combination/Index";
import CaseTemplate from "./case_template/Index";
import MemberUpgrade from "./member_upgrade/Index";
import PatientRecyclingBin from "./patient_recyclingBin/Index";
import OperationRecord from "./operation_record/Index";

export default {
    name: "Setting",
    components: {
        ClinicInformation,
        PermissionSettings,
        StaffManagement,
        DisposalCharging,
        DisposalCombination,
        CaseTemplate,
        MemberUpgrade,
        PatientRecyclingBin,
        OperationRecord
    },
    props: {},
    data() {
        return {
            curTab: "ClinicInformation",
            ClinicInformation: false,
            PermissionSettings: false,
            StaffManagement: false,
            DisposalCharging: false,
            DisposalCombination: false,
            CaseTemplate: false,
            MemberUpgrade: false,
            PatientRecyclingBin: false,
            OperationRecord: false,

            ClinicInformationUpdate: false,
            PermissionSettingsUpdate: false,
            StaffManagementUpdate: false,
            DisposalChargingUpdate: false,
            DisposalCombinationUpdate: false,
            CaseTemplateUpdate: false,
            MemberUpgradeUpdate: false,
            PatientRecyclingBinUpdate: false,
            OperationRecordUpdate: false,

        };
    },
    created() {},
    mounted() {},
    watch: {
        curTab: {
            handler(newValue, oldValue) {
                let that = this;
                that[newValue] = true;
                that[newValue + 'Update'] = true;
            },

            immediate: true
        }
        // curTab(newValue, oldValue) {
        //     let that = this;
        //     that[newValue] = true;
        // }
    },
    computed: {},
    methods: {}

    // ,
    // data() {
    //     return {
    //         activeName: "clinicOperation",

    //         advancedPatientInquiry: false,
    //         chainStoreStatistics: false,
    //         chargingReconciliation: false,
    //         clinicOperation: false,
    //         employeePerformance: false,
    //         externalProcessing: false,
    //         passengerFlowAnalysis: false,
    //         wechatOperation: false,

    //         advancedPatientInquiryUpdate: false,
    //         chainStoreStatisticsUpdate: false,
    //         chargingReconciliationUpdate: false,
    //         clinicOperationUpdate: false,
    //         employeePerformanceUpdate: false,
    //         externalProcessingUpdate: false,
    //         passengerFlowAnalysisUpdate: false,
    //         wechatOperationUpdate: false
    //     };
    // },
    // created() {},
    // mounted() {},
    // watch: {
    //     activeName: {
    //         handler(newValue, oldValue) {
    //             let that = this;
    //             that[newValue] = true;
    //             that[newValue + 'Update'] = true;
    //         },

    //         immediate: true
    //     }
    // },
    // computed: {},
    // methods: {
    // }


};
</script>
<style lang="less" scoped>
.setting {
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