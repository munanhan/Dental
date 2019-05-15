<template>
  <el-dialog
    title="复诊"
    :visible.sync="show"
    :before-close="closeDialog"
    :close-on-click-modal="false"
    class="custom-dialog"
    v-dialog-drag
    width="1100px"
    top="2vh"
  >
    <el-form
      ref="form"
      :model="form"
      label-width="80px"
      :rules="form.rules"
    >
      <div class="initDiag-content">
        <div class="left-content">
          <div class="initDiag-upperleft">
            <el-tabs v-model="form.activeName">
              <el-tab-pane
                label="病历模板"
                name="medicalTemplates"
              >
                <!-- <medical-templates></medical-templates> -->
                <!-- <div>
                <el-tree
                  style="height:100%;
                  font-weight:bold;
                       background-color:#efefef"
                  :data="data"
                  :props="defaultProps"
                ></el-tree>
              </div> -->
              </el-tab-pane>

              <el-tab-pane
                label="病历词条"
                name="second"
              >
              </el-tab-pane>
            </el-tabs>
          </div>
          <div class="initDiag-lowerleft">

          </div>
        </div>
        <div class="right-content">
          <div class="right-top">
            <div style="display:flex;font-size:15px">
              <div style="margin-left:8px;margin-top:13px;margin-right:10px">1503010120</div>
              <div style="margin-top:13px">8岁</div>
              <el-form-item
                style="margin-top:5px;margin-left:30px"
                label="活动名称"
                size="small"
              >
                <el-input style="width:120px"></el-input>
              </el-form-item>
              <div style="margin-top:10px;margin-left:10px">
                <el-radio
                  v-model="form.radio"
                  label="1"
                >初诊</el-radio>
                <el-radio
                  style="margin-left:-20px"
                  v-model="form.radio"
                  label="2"
                >复诊</el-radio>
              </div>
            </div>
            <div style="display:flex">
              <el-form-item
                label="检查医生:"
                size="small"
              >
                <el-select
                  style="width:120px"
                  v-model="form.value"
                  placeholder="请选择"
                >
                  <el-option
                    v-for="item in form.options"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value"
                  >
                  </el-option>
                </el-select>
              </el-form-item>
              <el-form-item
                style="margin-left:-20px"
                label="护士:"
                size="small"
              >
                <el-select
                  style="width:120px"
                  v-model="form.value"
                  placeholder="请选择"
                >
                  <el-option
                    v-for="item in form.options"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value"
                  >
                  </el-option>
                </el-select>
              </el-form-item>
              <el-form-item
                label="就诊日期:"
                size="small"
              >
                <el-date-picker
                  style="width:180px"
                  format="yyyy-MM-dd hh:mm"
                  v-model="form.value1"
                  type="date"
                  placeholder="选择日期"
                >
                </el-date-picker>
              </el-form-item>
            </div>
          </div>
          <div class="right-middle">
            <div style="display:flex">
              <el-button style="margin-top:2px;margin-left:2px">Ω特殊符号</el-button>
              <el-checkbox
                style="margin-top:10px;margin-left:450px"
                v-model="form.checked"
              ><span style="font-size:15px;color:#000">牙位同步</span></el-checkbox>
            </div>
            <div style="margin-top:5px;margin-left:2px">
              <table border="1">
                
                <tr>
                  <td align="center">复 诊</td>
                  <input>
                </tr>
                <tr>
                  <td align="center">检 查</td>
                  <input>
                </tr>
                <tr>
                  <td align="center">辅助检查</td>
                  <input>
                </tr>
                <tr>
                  <td align="center">治疗方案</td>
                  <input>
                </tr>
                <tr>
                  <td align="center">治 疗</td>
                  <input>
                </tr>
                <tr>
                  <td align="center">医嘱</td>
                  <input>
                </tr>
               
              </table>
            </div>
          </div>
          <div class="right-bottom">
            <div
              slot="footer"
              class="dialog-footer"
            >
              <div style="margin-top:10px;margin-left:5px">
                <el-button>另存模板</el-button>
                <el-button>预约</el-button>
                <el-button>回访</el-button>
                <el-button type="primary">确 定</el-button>
                <el-button @click="closeDialog">退出</el-button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </el-form>
  </el-dialog>
</template>

<script>
import DialogForm from "@/views/base/DialogForm";
export default {
  name: "InitialDiagnosis",

  mixins: [DialogForm],

  data() {
    return {
      form: {
        value1: "",
        radio: "2",
        checked: "",
        activeName: "medicalTemplates",
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

        // defaultProps: {
        //         children: "children",
        //         label: "label"
        //       },
        rules: {}
      }
    };
  },

  methods: {}
};
</script>
<style lang="less" scoped>
.initDiag-content {
  // border: 1px solid red;
  height: 600px;
  width: 1000px;
  display: flex;
  .left-content {
    height: 600px;
    .initDiag-upperleft {
      border: 1px solid #cacaca;
      position: relative;
      width: 400px;
      height: 350px;
    }
    .initDiag-lowerleft {
      margin-top: 5px;
      border: 1px solid #cacaca;
      height: 242px;
    }
  }
  .right-content {
    // border: 1px solid red;
    background-color: #f9f9f9;
    position: absolute;
    right: 0;
    width: 650px;
    margin-right: 20px;
    height: 600px;
    .right-top {
      height: 120px;
      border: 1px solid #e6e6e6;
    }
    .right-middle {
      border: 1px solid #e6e6e6;
      border-top: none;
      height: 410px;
      table {
        border-collapse: collapse;
        border-spacing: 0;
        border: 1px solid #e3e3e3;
      }
      tr {
        font-size: 16px;
      }
      td {
        padding: 0;
        width: 120px;
        background-color: #f8f8f8;
      }
      input {
        width: 520px;
        height: 30px;
      }
      select {
        width: 664px;
        height: 40px;
      }
    }
    .right-bottom {
      border: 1px solid #e6e6e6;
      border-top: none;
      height: 67px;
    }
  }
  /deep/ .el-tabs__nav-scroll {
    margin-left: 10px;
  }
}
</style>