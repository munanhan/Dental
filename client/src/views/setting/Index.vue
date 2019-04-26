<template>

    <div class="setting">
      <!-- tab -->

      <el-tabs v-model="curTab">

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
import ClinicInformation from "./ClinicInformation";
import PermissionSettings from "./PermissionSettings";
import StaffManagement from "./StaffManagement/Index";
import DisposalCharging from "./DisposalCharging/Index";
import DisposalCombination from "./DisposalCombination/Index";
import CaseTemplate from "./CaseTemplate";
import MemberUpgrade from "./MemberUpgrade/Index";
import PatientRecyclingBin from "./PatientRecyclingBin/Index";
import OperationRecord from "./OperationRecord";


export default {
    name: 'Setting',
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
    props:{},
    data() {
        return {
              curTab: "ClinicInformation",
              ClinicInformation:false,
              PermissionSettings:false,
              StaffManagement:false,
              DisposalCharging:false,
              DisposalCombination:false,
              CaseTemplate:false,
              MemberUpgrade:false,
              PatientRecyclingBin:false,
              OperationRecord:false
            };
    },
      created() {},
      mounted() {},
      watch: {
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

        maskMouseHandler(evt) {
          let that = this;

          //调整移动的区间范围
          that.maxMoveWidth = that.outerWidth - that.maskWidth;
          that.maxMoveHeight = that.outerHeight - that.maskHeight;

          //点击鼠标点击的位置
          that.disX = evt.clientX;
          that.disY = evt.clientY;

          //记录原来的mask的位置，从这个位置开始计算左右移动距离，- 0 是为了复制值
          that.orginTop = that.top - 0;
          that.orginLeft = that.left - 0;

          // 如果存在可移动的范围的时候才绑定
          // 全局监听松开事件，放在在内容选择框外松开
          document.addEventListener("mouseup", that.onMouseUp);
          document.addEventListener("mousemove", that.onMouseMove);
        }
      }
}
</script>
<style lang="less" scoped>
.setting{
  margin-left: 10px;
  width: 98%;
  height: 100%;
  /*border: 1px solid #eee;*/

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