<template>
  <div class="patient-info">

    <el-collapse
      class="patien-content"
      style="overflow:auto"
    >
      <el-collapse-item class="sliding-one">
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
                <div> 患者姓名：</div>
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

          <div class="patient-right">
            <div
              class="image"
              style="background-image: url(404.jpg);"
            >
            </div>
            <div style="display:flex;margin-bottom:5px">
              <el-radio
                v-model="sex"
                label="1"
              >男</el-radio>
              <el-radio
                v-model="sex"
                label="2"
              >女</el-radio>
            </div>
            <div class="block">
              <span
                class="demonstration"
                style="position: absolute;bottom:0;"
              ></span>
              <el-rate
                v-model="value2"
                :colors="['#FF9900', '#FF9900', '#FF9900']"
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

      <!-- <el-collapse-item
        title="等待确认"
        style="width:1000px;margin-left:10px;margin-bottom:10px"

      >
        <div>简化流程：设计简洁直观的操作流程；</div>
        <div>清晰明确：语言表达清晰且表意明确，让用户快速理解进而作出决策；</div>
        <div>帮助用户识别：界面简单直白，让用户快速识别而非回忆，减少用户记忆负担。</div>
        <div>简化流程：设计简洁直观的操作流程；</div>
        <div>清晰明确：语言表达清晰且表意明确，让用户快速理解进而作出决策；</div>
        <div>帮助用户识别：界面简单直白，让用户快速识别而非回忆，减少用户记忆负担。</div>
        <div>简化流程：设计简洁直观的操作流程；</div>

      </el-collapse-item> -->
      <el-collapse-item
        class="sliding-two"
        style=""
      >
        <template slot="title">

          <span class="base-fz">初诊信息</span>

        </template>
        <div>水水水水</div>

      </el-collapse-item>

      <el-collapse-item class="sliding-three">
        <template slot="title">
          <span class="base-fz">亲友关系</span>
        </template>

      </el-collapse-item>

    </el-collapse>
    <div style="border:1px solid #e4e4e4;
                background-color:#e3e3e3;
                position:absolute;left;0;
                bottom:0;width:100%;
                height:59px">

      <el-button class="patient-button">扫一扫</el-button>
      <el-button
        style="width:110px;margin-right: 20px;"
        type="primary"
        porp="modify-inormation"
        @click="Modify_info"
      >修改信息</el-button>
      <el-button class="patient-button">病历首页打印</el-button>
      <i
        class="fa fa-cog"
        style="cursor:pointer"
      ></i>

    </div>
    <modify-info :show.sync="modinfo_show"></modify-info>
  </div>
</template>

<script>
import ModifyInfo from "./ModifyInfo";
export default {
  name: "PatientInfo",

  components: {
    ModifyInfo
  },
  props: {
    refresh: {
      type: Boolean,
      required: true
    }
  },
  data() {
    return {
      sex: "",
      activeNames: ["1"],
      value2: null,
      modinfo_show: false
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
    },
    Modify_info() {
      this.modinfo_show = true;
    }
  }
};
</script>
<style lang="less" scoped>
//导入全局的颜色
@import "~@css/var";

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
          height: 100%;
          width: 850px;
        }
        .patient-right {
          margin-left: 10px;
          margin-right: 30px;
          margin-left: -40px;
          flex: 1 auto;
          padding: 5px;
          .image {
            position: relative;
            border: 1px solid red;
            width: 170px;
            margin-bottom: 10px;
            margin-left: -30px;
            height: 180px;
          }
          .block {
            margin-left: -4px;
          }
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
  margin-left: 10px;
  margin-top: 10px;
}

.sliding-one {
  width: 1000px;
  margin-left: 10px;
  margin-bottom: 10px;
}
.sliding-two {
  width: 1000px;
  margin-left: 10px; 
  margin-bottom: 10px;
}
.sliding-three {
  width: 1000px;
  margin-left: 10px;
  margin-bottom: 10px;
}
</style>