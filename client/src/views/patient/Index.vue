<template>
  <el-container class="patient">

    <div class="content-left">
      <div style="border:1px solid red;width:350px;margin-right:10px">
        <el-tabs
          v-model="activeName"
          @tab-click="handleClick"
        >
          <el-tab-pane
            label="用户管理"
            name="first"
          >
		  
		  </el-tab-pane>
          <el-tab-pane
            label="配置管理"
            name="second"
          >配置管理</el-tab-pane>
          <el-tab-pane
            label="角色管理"
            name="third"
          >角色管理</el-tab-pane>
          
        </el-tabs>
      </div>
      <div></div>
    </div>

    <div class="content-right">
      <!-- tab -->

      <el-tabs v-model="curTab">

        <el-tab-pane
          label="患者信息"
          name="pationInfo"
        >
          <patient-info :refresh.sync="pationInfo"></patient-info>

        </el-tab-pane>

        <el-tab-pane
          label="处置记录"
          name="disposalRecords"
        >
          <disposal-records :refresh.sync="disposalRecords"></disposal-records>
        </el-tab-pane>

        <el-tab-pane
          label="收费信息"
          name="chargeInfo"
        >
          <charge-info :refresh.sync="chargeInfo"></charge-info>
        </el-tab-pane>

        <el-tab-pane
          label="影像信息"
          name="imageInfo"
        >
          <image-info :refresh.sync="imageInfo"></image-info>
        </el-tab-pane>

        <el-tab-pane
          label="病历信息"
          name="medicalRecordsInfo"
        >
          <medical-records-info :refresh.sync="medicalRecordsInfo"></medical-records-info>
        </el-tab-pane>

        <el-tab-pane
          label="外加工"
          name="outsideProcessing"
        >
          <outside-processing :refresh.sync="outsideProcessing"></outside-processing>
        </el-tab-pane>

        <el-tab-pane
          label="回访信息"
          name="returnVisitInfo"
        >
          <return-visit-info :refresh.sync="returnVisitInfo"></return-visit-info>
        </el-tab-pane>

        <el-tab-pane
          label="咨询信息"
          name="consultingInfo"
        >
          <consulting-info :refresh.sync="consultingInfo"></consulting-info>
        </el-tab-pane>
      </el-tabs>
    </div>

    <!-- <el-aside
      class="my-aside"
      width="380px"
    >
      <div class="today_top">

        <el-tabs @tab-click="handleClick">
          <el-tab-pane
            label="当天工作"
            name="first"
          >
          </el-tab-pane>

          <el-tab-pane
            label="全部患者"
            name="second"
          >
            <el-container>
              <div style="display:flex;">
                <template>
                  <el-select
                    style="width:105px;padding-left:10px"
                    v-model="value"
                    placeholder="患者信息"
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
                </template>
              </div>
            </el-container>
          </el-tab-pane>

          <el-tab-pane
            label="最近访问"
            name="third"
          >角色管理</el-tab-pane>
        </el-tabs>
      </div>

    </el-aside>

    <div
      class="container"
      style="height: 99.8%; border: 1px solid red"
    >
      <div class="tab-pane">
        <div
          class="tab-pane-content"
          :style="{
            left: `${left}px`,
            width: `${width}px`
          }"
        ></div>
        <div
          class="move-line"
          @mousedown.stop.prevent="maskMouseHandler($event)"
        ></div>

      </div>
      <div class="content"></div>
    </div>

    <el-container>
      <el-header>
        <el-tabs @tab-click="handleClick">
          <el-tab-pane
            label="患者信息"
            name="first"
          >
            <div style="background-color: rgb(238, 241, 246)">adasdas</div>
          </el-tab-pane>
          <el-tab-pane
            label="处置记录"
            name="second"
          >配置管理</el-tab-pane>
          <el-tab-pane
            label="收费信息"
            name="third"
          >角色管理</el-tab-pane>
          <el-tab-pane
            label="影像信息"
            name="fourth"
          >定时任务补偿</el-tab-pane>
          <el-tab-pane
            label="病历信息"
            name="5"
          >定时任务补偿</el-tab-pane>
          <el-tab-pane
            label="外加工"
            name="6"
          >定时任务补偿</el-tab-pane>
          <el-tab-pane
            label="回访信息"
            name="7"
          >定时任务补偿</el-tab-pane>
          <el-tab-pane
            label="咨询信息"
            name="8"
          >定时任务补偿</el-tab-pane>
        </el-tabs>
      </el-header>
    </el-container> -->

  </el-container>
</template>

<script>
import PatientInfo from "./PatientInfo";
import DisposalRecords from "./DisposalRecords";
import ChargeInfo from "./ChargeInfo";
import ImageInfo from "./ImageInfo";
import MedicalRecordsInfo from "./MedicalRecordsInfo";
import OutsideProcessing from "./OutsideProcessing";
import ReturnVisitInfo from "./ReturnVisitInfo";
import ConsultingInfo from "./ConsultingInfo";

export default {
  name: "Patient",

  components: {
    PatientInfo,
    DisposalRecords,
    ChargeInfo,
    ImageInfo,
    MedicalRecordsInfo,
    OutsideProcessing,
    ReturnVisitInfo,
    ConsultingInfo
  },

  props: {},

  data() {
    return {
      curTab: "pationInfo",

      //   pationRefresh: false,
      //   disposalRecordsRefresh: false,

      //   quickFind: {
      // 	pationInfo: "pationRefresh",
      // 	disposalRecords: "disposalRecordsRefresh"

      //   },

      pationInfo: false,
      disposalRecords: false,
      chargeInfo: false,
      imageInfo: false,
      medicalRecordsInfo: false,
      outsideProcessing: false,
      returnVisitInfo: false,
      consultingInfo: false
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
};
</script>
<style lang="less" scoped>
.patient {
  height: 100%;
  border: 1px solid #eee;
  .my-aside {
    background-color: rgb(238, 241, 246);
    .today_top {
      border: 1px solid red;
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
el-tabs__header is-top .move-line {
  border: 1px solid rgb(235, 235, 235);
}
</style>