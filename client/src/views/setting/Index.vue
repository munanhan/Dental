<template>

    <div class="setting">
        <el-tabs
            v-model="curTab"
        >

            <el-tab-pane
                label="诊所信息"
                name="ClinicInformation"
            >
                <clinic-information :refresh.sync="ClinicInformation"></clinic-information>

            </el-tab-pane>

            <el-tab-pane
                label="权限设置"
                name="PermissionSettings"
            >
                <permission-settings :refresh.sync="PermissionSettings"></permission-settings>
            </el-tab-pane>

            <el-tab-pane
                label="员工管理"
                name="StaffManagement"
            >
                <staff-management :refresh.sync="StaffManagement"></staff-management>
            </el-tab-pane>

            <el-tab-pane
                label="处置与收费"
                name="DisposalCharging"
            >
                <disposal-charging :refresh.sync="DisposalCharging"></disposal-charging>
            </el-tab-pane>

            <el-tab-pane
                label="处置组和"
                name="DisposalCombination"
            >
                <disposal-combination :refresh.sync="DisposalCombination"></disposal-combination>
            </el-tab-pane>

            <el-tab-pane
                label="病例模板"
                name="CaseTemplate"
            >
                <case-template :refresh.sync="CaseTemplate"></case-template>
            </el-tab-pane>

            <el-tab-pane
                label="会员升级"
                name="MemberUpgrade"
            >
                <member-upgrade :refresh.sync="MemberUpgrade"></member-upgrade>
            </el-tab-pane>

            <el-tab-pane
                label="患者回收站"
                name="PatientRecyclingBin"
            >
                <patient-recycling-bin :refresh.sync="PatientRecyclingBin"></patient-recycling-bin>
            </el-tab-pane>

            <el-tab-pane
                label="操作记录"
                name="OperationRecord"
            >
                <operation-record :refresh.sync="OperationRecord"></operation-record>
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
import CaseTemplate from "./CaseTemplate";
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
            OperationRecord: false
        };
    },
    created() {},
    mounted() {},
    watch: {
        curTab(newValue, oldValue) {
            let that = this;
            that[newValue] = true;
        }
    },
    computed: {},
    methods: {}
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