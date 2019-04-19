<template>
  <div class="patient-info">

    <el-collapse style="overflow:auto">
      <el-collapse-item style="width:1000px;margin-left:10px;margin-bottom:10px;">
        <template slot="title">
          <span class="base-fz">基本信息</span>
        </template>

        <div class="patient-body">
          <div class="patient-left">

            <el-row
              :gutter="24"
              style="margin:10px"
            >
              <el-col :span="6">
                <div>患者姓名：</div>
              </el-col>
              <el-col :span="6">
                <div>患者分组：</div>
              </el-col>
              <el-col :span="6">
                <div>手 机 1：</div>
              </el-col>
            </el-row>
            <el-row
              :gutter="24"
              style="margin:10px"
            >
              <el-col :span="6">
                <div>病 历 号：</div>
              </el-col>
              <el-col :span="6">
                <div>介 绍 人：</div>
              </el-col>
              <el-col :span="6">
                <div>手 机 2：</div>
              </el-col>
            </el-row>
            <el-row
              :gutter="24"
              style="margin:10px"
            >
              <el-col :span="6">
                <div>出生年月：</div>
              </el-col>
              <el-col :span="6">
                <div>年 龄：</div>
              </el-col>
              <el-col :span="6">
                <div>职 业：</div>
              </el-col>
            </el-row>
            <el-row
              :gutter="24"
              style="margin:10px"
            >
              <el-col :span="6">
                <div>会员等级：</div>
              </el-col>
              <el-col :span="6">
                <div>会员卡号：</div>
              </el-col>
              <el-col :span="6">
                <div>社 保 号：</div>
              </el-col>
            </el-row>
            <el-row
              :gutter="24"
              style="margin:10px"
            >
              <el-col :span="6">
                <div>电子邮箱：</div>
              </el-col>

            </el-row>
            <el-row
              :gutter="24"
              style="margin:10px"
            >
              <el-col :span="6">
                <div>联系地址：</div>
              </el-col>

            </el-row>
            <el-row
              :gutter="24"
              style="margin:10px"
            >
              <el-col :span="6">
                <div>备 注：</div>
              </el-col>

            </el-row>
          </div>

          <div
            class="patient-right"
            style="{background-image:url(/i/eg_bg_04.gif);}"
          >
            <div class="block">
              <span class="demonstration"></span>
              <el-rate
                v-model="value2"
                :colors="['#99A9BF', '#F7BA2A', '#FF9900']"
              >
              </el-rate>
            </div>
          </div>
        </div>

        <div class="patient-footer">
        </div>

        <div class="patient-bottom">
          <el-row
            :gutter="24"
            style="margin:10px"
          >
            <el-col :span="6">
              <div>咨 询 师：</div>
            </el-col>
            <el-col :span="6">
              <div>初诊医生：</div>
            </el-col>
            <el-col :span="6">
              <div>初诊时间：</div>
            </el-col>
          </el-row>
          <el-row
            :gutter="24"
            style="margin:10px"
          >
            <el-col :span="6">
              <div>患者来源：</div>
            </el-col>
            <el-col :span="6">
              <div>复诊医生：</div>
            </el-col>
            <el-col :span="6">
              <div>复诊时间：</div>
            </el-col>
          </el-row>
          <el-row
            :gutter="24"
            style="margin:10px"
          >
            <el-col :span="6">
              <div>电网咨询：</div>
            </el-col>
            <el-col :span="6">
              <div>患者分类：</div>
            </el-col>
            <el-col :span="6">
              <div>咨询项目：</div>
            </el-col>
          </el-row>
          <el-row
            :gutter="24"
            style="margin:10px"
          >
            <el-col :span="10">
              <div>过 敏 史：</div>
            </el-col>
          </el-row>
          <el-row
            :gutter="24"
            style="margin:10px"
          >
            <el-col :span="10">
              <div>既 往 史：</div>
            </el-col>
          </el-row>

        </div>

      </el-collapse-item>

      <el-collapse-item
        title="效率 Efficiency"
        style="width:1000px;margin-left:10px;margin-bottom:10px"
      >
        <div>简化流程：设计简洁直观的操作流程；</div>
        <div>清晰明确：语言表达清晰且表意明确，让用户快速理解进而作出决策；</div>
        <div>帮助用户识别：界面简单直白，让用户快速识别而非回忆，减少用户记忆负担。</div>
        <div>简化流程：设计简洁直观的操作流程；</div>
        <div>清晰明确：语言表达清晰且表意明确，让用户快速理解进而作出决策；</div>
        <div>帮助用户识别：界面简单直白，让用户快速识别而非回忆，减少用户记忆负担。</div>
        <div>简化流程：设计简洁直观的操作流程；</div>

      </el-collapse-item>

      <el-collapse-item style="width:1000px;margin-left:10px;margin-bottom:10px">
        <template slot="title">

          <span class="base-fz">亲友关系</span>
        </template>

        <div></div>

      </el-collapse-item>

    </el-collapse>
    <div style="border:1px solid #e4e4e4;background-color:#e3e3e3;position:absolute;left;0;bottom:0;width:100%;height:59px">

      <el-button class="patient-button">扫一扫</el-button>
      <el-button
        style="width:110px;margin-right: 20px;"
        type="success"
      >修改信息</el-button>
      <el-button class="patient-button">病历首页打印</el-button>
      <i class="fa fa-cog" style="cursor:pointer"></i>

    </div>
  </div>
</template>

<script>
export default {
  name: "PatientInfo",
  components: {},
  props: {
    refresh: {
      type: Boolean,
      required: true
    }
  },
  data() {
    return {
      activeNames: ["1"],
      value2: null
    };
  },
  created() {},
  mounted() {},
  watch: {
    refresh(newValue, oldValue) {
      let that = this;

      if (newValue) {
        that.getPatientInfo();
      }
    }
  },
  computed: {},
  methods: {
    getPatientInfo() {
      let that = this;

      that.$api.aaaa.aaaa
        .then(res => {
          that.getDataDone();
        })
        .catch(res => {
          that.getDataDone();
        });
    },

    getDataDone() {
      setTimeout(() => {
        that.$emit("update:refresh", false);
      }, 6e3);
    },
    handleChange(val) {
      console.log(val);
    }
  }
};
</script>
<style lang="less" scoped>
.patient-info {
  .el-collapse {
    height: 800px;
    .el-collapse-item {
      .base-fz {
        font-size: 18px;
        margin-left: 10px;
      }
      .patient-body {
        display: flex;
        .patient-left {
          //   flex: 1 auto;
          //   height: 100%;
          //   padding: 5px;
          height: 100%;
          width: 850px;
        }
        .patient-right {
          // height: 100%;
          // width: 300px;
          border: 1px solid red;
          width: 100px;
          margin-left: 10px;
          margin-right: 30px;
          margin-left: -40px;
          flex: 1 auto;
          height: 140px;
          padding: 5px;
          //   float: right;
          //   border: 1px solid red;
          //   margin-right: 50px;
          //   height: 50;
        }
      }
    }
  }
  .patient-footer {
    border: 0.5px solid #e3e3e3;
    width: 980px;
    margin-top: 70px;
    margin-bottom: 10px;
  }
}

.el-row {
  color: #7a7979;
}

.patient-button {
    margin-right: 20px;
  width: 120px;
  border: 1px solid green;
  margin-left: 10px;
  margin-top: 10px;
}
</style>