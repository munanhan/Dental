<template>
  <el-dialog
    :title="title"
    :visible.sync="show"
    :before-close="closeDialog"
    class="custom-dialog add-yuyue-dialog"
    :close-on-click-modal="false"
    width="835px"
    v-dialog-drag
  >
    <div class="header">
      <div class="base-info">基本信息</div>
      <div class="time-interval">时段*</div>
      <div class="right">
        <div>事项*</div>
        <div class="search">
          <input
            type="text"
            ref="inputSearch"
            name="search"
            placeholder="姓名"
            value
            @keyup.enter="search"
          />
          <i class="fas fa-search" @click="search"></i>
        </div>
      </div>
    </div>
    <el-form
      :model="formData"
      ref="addYuyueFrom"
      label-width="80px"
      :rules="rules"
      label-position="left"
    >
      <div class="left">
        <el-form-item label="病历号" prop="case_id">
          <el-input v-model="formData.case_id" type="text" autocomplete="off" placeholder></el-input>
        </el-form-item>
        <el-form-item label="电话" prop="patient_phone" required>
          <el-input
            v-model="formData.patient_phone"
            type="text"
            autocomplete="off"
            placeholder
            @blur="getPatientByPhone"
          ></el-input>
        </el-form-item>
        <el-form-item label="姓名" prop="patient_name">
          <el-input v-model="formData.patient_name" type="text" autocomplete="off" placeholder></el-input>
        </el-form-item>

        <el-form-item label="性别" prop="patient_sex">
          <el-radio-group v-model="formData.patient_sex">
            <el-radio :label="0">男</el-radio>
            <el-radio :label="1">女</el-radio>
          </el-radio-group>
        </el-form-item>

        <el-form-item prop="patient_age" label="年龄">
          <el-input v-model="formData.patient_age" type="text" autocomplete="off" placeholder></el-input>
        </el-form-item>

        <el-form-item prop="patient_source" label="患者来源">
          <el-select v-model="formData.patient_source" placeholder="请选择">
            <el-option label value></el-option>
            <el-option label="网络咨询" value="网络咨询"></el-option>
            <el-option label="朋友介绍" value="朋友介绍"></el-option>
            <el-option label="家住附近" value="家住附近"></el-option>
            <el-option label="诊所网站" value="诊所网站"></el-option>
          </el-select>
        </el-form-item>
        <el-form-item prop="appointment_doctor" label="预约医生">
          <el-select v-model="formData.appointment_doctor" placeholder="请选择">
            <el-option
              v-for="(item,index) in doctor"
              :key="index"
              :label="item.name"
              :value="item.id"
            ></el-option>
          </el-select>
        </el-form-item>

        <el-form-item label="就诊类型" prop="type" required>
          <el-radio-group v-model="formData.type">
            <el-radio label="0">初诊</el-radio>
            <el-radio label="1">复诊</el-radio>
          </el-radio-group>
        </el-form-item>
        <el-form-item label="患者备注" prop="patient_content">
          <el-input v-model="formData.patient_content" type="text" autocomplete="off" placeholder></el-input>
        </el-form-item>
        <el-form-item label="预约备注" prop="appointment_comment">
          <el-input
            v-model="formData.appointment_comment"
            type="text"
            autocomplete="off"
            placeholder
          ></el-input>
        </el-form-item>
      </div>

      <div class="center">
        <el-form-item prop="appointment_date" label-width="0">
          <el-date-picker v-model="formData.appointment_date" type="date" placeholder="选择日期"></el-date-picker>
        </el-form-item>

        <div class="day-time">
          <div class="other-left">
            <div v-for="(item,index) in dayTime" :key="index">
              <div>
                <span class="big-font">{{item}}</span>
                <span>00</span>
              </div>
              <div>
                <span>30</span>
              </div>
            </div>
          </div>
          <div class="other-right" @click="chooseTime">
            <template v-for="(item,index) in dayTime">
              <div
                :key="index"
                :data-time="item + ' : 00'"
                :class="{
                  'gray':yuyue_time == item + ' : ' +'00'
              }"
              ></div>
              <div
                :key="index+20"
                :data-time="item + ' : 30'"
                :class="{
                  'gray':yuyue_time == item + ' : ' +30
                  }"
              ></div>
            </template>
          </div>
        </div>
      </div>
      <div class="right">
        <el-form-item label-width="0">
          <el-input type="textarea" v-model="formData.items" resize="none"></el-input>
        </el-form-item>
        <div class="items">
          <el-checkbox-group v-model="checked_items">
            <el-checkbox v-for="item in items_o" :label="item" :key="item">{{item}}</el-checkbox>
          </el-checkbox-group>
        </div>
      </div>
    </el-form>
    <div slot="footer" class="dialog-footer">
      <el-button @click="closeDialog">取 消</el-button>
      <el-button :loading="commitLoading" type="primary" @click="submitFrom">确 定</el-button>
    </div>
  </el-dialog>
</template>

<script>
let telRules = [
  {
    required: true,
    message: "请填写正确号码",
    trigger: "blur"
  },
  {
    min: 11,
    max: 11,
    message: "请填写正确号码",
    trigger: "blur"
  }
];
let ageRules = [
  {
    required: true,
    message: "请填写正确年龄",
    trigger: "blur"
  }
];

const itemsOptions = [
  "试戴义齿",
  "换药",
  "补牙",
  "戴牙",
  "手术",
  "拔牙",
  "拆线",
  "根管预备",
  "试内冠",
  "根管治疗",
  "牙周上药",
  "试支架",
  "根充",
  "备牙",
  "牙周刮治",
  "洁治",
  "修义齿",
  "加力"
];
import { addClass, removeClass } from "@/common/util.js";
import DialogForm from "@/views/base/DialogForm";
import { type } from "os";
import { format } from "path";
export default {
  name: "ChangePassword",
  mixins: [DialogForm],
  props: [
    "dayTime",
    "yuyue_time",
    "yuyue_id",
    "yuyue_date",
    "weekStart",
    "weekEnd",
    "appointment_doctor"
  ],
  inject: ["getTodayAppointment"],
  created() {},
  computed: {
    chooseDate() {
      return this.$store.state.chooseDate;
    }
  },
  data() {
    return {
      formData: {
        case_id: "190418001",
        appointment_date: "",
        appointment_doctor: "",
        patient_source: "",
        items: "",
        type: "0",
        patient_name: "",
        patient_age: "",
        patient_source: "",
        patient_phone: "",
        patient_sex: ""
        // start_time:this.yuyue_time,
      },
      doctor: null,
      title: "新增预约",
      items_o: itemsOptions,
      checked_items: [],

      rules: {
        patient_name: [
          {
            required: true,
            message: "请输入姓名",
            trigger: "blur"
          }
        ],
        patient_age: [
          {
            required: true,
            message: "请输入年龄.",
            trigger: "blur"
          }
        ],
        patient_sex: [
          {
            required: true,
            message: "请选择性别.",
            trigger: "blur"
          }
        ],
        patient_phone: [
          {
            required: true,
            message: "请输入手机号",
            trigger: "blur"
          },
          {
            pattern: /^1[3|4|5|7|8|6|9][0-9]{9}$/,
            message: "请输入正确的手机号"
          }
        ],
        appointment_doctor: [
          {
            required: true,
            message: "请选择主治医生",
            trigger: "blur"
          }
        ]
      },

      commitLoading: false
    };
  },
  watch: {
    checked_items(newci, oldci) {
      this.formData.items = this.checked_items.join(",");
    },
    show(new_show, old_show) {
      if (new_show) {
        this.$api.appointment.getCaseNumber().then(res => {
          if (res.code == 200) {
            this.formData.case_id = res.data.case_id;
          }
        });
      }
      if (this.yuyue_id) {
        if (new_show) {
          this.$api.appointment
            .getByIdAppointment({ id: this.yuyue_id })
            .then(res => {
              if (res.code == 200) {
                this.formData = res.data;
                this.title = "修改预约";
              }
            });
        }
      } else {
        this.title = "新增预约";
      }
      if (old_show) {
        this.formData.id = null;
      } else {
        //获取预约医生数据、
        this.$api.appointment.attendDoctor().then(res => {
          this.doctor = res;
        });
      }
      this.formData.appointment_date = this.yuyue_date
        ? this.yuyue_date
        : this.chooseDate;
      this.appointment_doctor
        ? (this.formData.appointment_doctor = this.appointment_doctor)
        : null;
      if (!this.yuyue_time) {
        return;
      }
      this.formData.start_time = this.yuyue_time;

      let [H, i] = this.yuyue_time.split(":");
      H = +H + 1;
      this.$nextTick(function() {
        let gray = document.getElementsByClassName("gray");
        if (new_show) {
          if (i != 30) {
            gray[0].innerHTML = `<div class="double">${this.yuyue_time}-${H}:00 (60m)</div>`;
          } else {
            gray[0].innerHTML = `<div class="double">${this.yuyue_time}-${H}:30 (60m)</div>`;
          }
        } else {
          gray[0].innerHTML = "";
        }
      });
    }
  },
  methods: {
    getPatientByPhone() {
      let patient_phone = this.formData.patient_phone;
      if (patient_phone.length == 11) {
        this.$api.appointment.getPatientByPhone({ patient_phone }).then(res => {
          if (res.code == 200) {
            if (res.data) {
              this.formData.patient_name = res.data.patient_name;
              this.formData.patient_age = res.data.patient_age;
              this.formData.patient_sex = res.data.patient_sex;
              this.formData.patient_source = res.data.patient_source;
              this.formData.type = "1";
            } else {
              this.formData.patient_name = null;
              this.formData.patient_age = null;
              this.formData.patient_sex = null;
              this.formData.patient_source = null;
              this.formData.type = "0";
            }
          }
        });
      } else {
        return;
      }
    },
    search() {
      this.items_o = itemsOptions;
      let $search = this.$refs.inputSearch;
      let itemArray = this.items_o.filter(item => {
        return item.indexOf($search.value) > -1 ? true : false;
      });
      this.items_o = itemArray;
    },
    chooseTime() {
      let value = event.target.attributes["data-time"].value;

      let gray = document.getElementsByClassName("gray");

      [...gray].forEach(i => {
        i.innerHTML = " ";
        removeClass(i, "gray");
      });
      addClass(event.target, "gray");
      let [H, i] = value.split(":");
      H = +H + 1;
      if (i != 30) {
        event.target.innerHTML = `<div class="double">${value}-${H}:00 (60m)</div>`;
      } else {
        event.target.innerHTML = `<div class="double">${value}-${H}:30 (60m)</div>`;
      }
      this.formData.start_time = value;
    },
    submitFrom() {
      let that = this;
      that.$refs["addYuyueFrom"].validate(valid => {
        if (valid) {
          that.commitLoading = true;
          var t = new Date(that.formData.appointment_date);
          var tf = function(i) {
            return (i < 10 ? "0" : "") + i;
          };
          that.formData.appointment_date =
            t.getFullYear() +
            "-" +
            tf(t.getMonth() + 1) +
            "-" +
            tf(t.getDate());
          that.$api.appointment
            .addAppointment(that.formData)
            .then(res => {
              if (res.code == 200) {
                that.$message({
                  message: res.msg,
                  type: "success",
                  duration: 800
                });
                that.getTodayAppointment();
                if (this.weekStart) {
                  this.$api.appointment
                    .getWeekAppointment({
                      weekStart: this.weekStart,
                      weekEnd: this.weekEnd
                    })
                    .then(res => {
                      if (res.code == 200) {
                        this.$parent.yuyue_week_res = res.data;
                      }
                    });
                }

                that.closeDialog();
              } else {
                that.$message.error(res.message);
              }

              that.commitLoading = false;
            })
            .catch(res => {
              that.$message.error("修改失败，请重试.");
              that.commitLoading = false;
            });
        }
      });
    },
    afterClose() {
      this.checked_items = []
      this.$refs["addYuyueFrom"].resetFields();
    }
  },
  mounted() {}
};
</script>
<style lang="less" >
@import "~@/assets/css/var.less";
.add-yuyue-dialog {
  .header {
    font-size: 18px;
    display: flex;
    .base-info {
      flex: 3 1 auto;
      margin-left: 10px;
    }
    .time-interval {
      flex: 1 1 auto;
      margin-left: 18%;
    }
    .right {
      margin-left: 10%;
      flex: 0 1 auto;
      display: flex;
      color: #000;
      .search {
        color: @color;
        margin-left: 10px;
        line-height: 25px;
        border: 1px solid @color;
        border-radius: 8px;
        font-size: 14px;
        input {
          width: 140px;
          outline: none;
          border: none;
          // height: 18px;
          padding: 0 14px;
        }
      }
    }
  }
  .el-form {
    display: flex;
    margin: 10px;
    .left {
      border-radius: 10px;
      padding: 10px;
      padding-right: 10px;
      box-sizing: border-box;
      border: 1px solid #e0e0e0;
      flex: auto;
      .el-input {
        width: 80%;
        // height: 60%;
      }
    }
    .center {
      padding: 10px;
      margin-left: 5px;
      flex: auto;
      border-radius: 10px;
      border: 1px solid #e0e0e0;
      display: flex;
      flex-direction: column;
      .day-time {
        flex: auto;
        display: flex;
        .other-left {
          color: #fff;
          display: flex;
          flex-direction: column;
          background-color: @hover-color;
          > div {
            flex: auto;
            > div {
              flex: auto;
              box-sizing: border-box;
              &:first-of-type {
                display: flex;
                padding: 0 10px;
                span {
                  flex: auto;
                  border-top: 1px solid #e6e6e6;
                  &.big-font {
                    font-size: 20px;
                  }
                }
              }
              &:last-of-type {
                display: flex;
                padding: 0 10px;
                span {
                  margin-left: auto;
                  border-top: 1px solid #e6e6e6;
                }
                .span-left {
                  margin: 0;
                }
              }
            }
          }
        }
        .other-right {
          flex: auto;
          display: flex;
          flex-direction: column;
          > div {
            box-sizing: border-box;
            background-color: #fff;
            flex: auto;
            text-align: center;
            border: 1px solid #000;
            border-bottom: none;
            cursor: pointer;
            &:last-of-type {
              border-bottom: 1px solid #000;
            }
            &.gray {
              // flex: 0 1 auto;
              position: relative;
              .double {
                background-color: #ccc;
                color: #fff;
                position: absolute;
                left: 0;
                right: 0;
                height: 200%;
                line-height: 200%;
                z-index: 100;
                text-align: center;
              }
            }
          }
        }
      }
    }

    .right {
      padding: 10px;
      margin-left: 5px;
      box-sizing: border-box;
      border-radius: 10px;
      border: 1px solid #e0e0e0;
      flex: auto;
      display: flex;
      flex-direction: column;
      .items {
        flex: 1 1 auto;
        border: 1px solid #e0e0e0;
        .el-checkbox-group {
          display: flex;
          flex-wrap: wrap;
          width: 256px;
          .el-checkbox {
            width: 30%;
            box-sizing: border-box;
            padding-left: 10px;
            margin-top: 10px;
          }
        }
      }
    }
  }
}
</style>