<template>
  <div class="status-dialog">
    <el-dialog
      :title="name"
      :visible.sync="show"
      :before-close="closeDialog"
      class="custom-dialog"
      :close-on-click-modal="false"
      width="600px"
      v-dialog-drag
    >
      <div class="content">
        <div class="item expried" ref="item3" @click="changeStatus(3)" v-if="status != 0">
          <div>
            <i class="fas fa-exclamation-triangle"></i>
          </div>
          <div>过期</div>
        </div>
        <div class="item appoint" ref="item0" @click="changeStatus(0)" v-if="status == 0">
          <div>
            <i class="far fa-clock"></i>
          </div>
          <div>预约</div>
        </div>
        <div class="item" ref="item1" @click="changeStatus(1)">
          <div>
            <i class="far fa-thumbs-up"></i>
          </div>
          <div>确认</div>
        </div>
        <div class="item" ref="item2" @click="changeStatus(2)">
          <div>
            <i class="fas fa-warehouse"></i>
          </div>
          <div>到达</div>
        </div>
        <div class="item" ref="item5" @click="changeStatus(5)">
          <div>
            <i class="fas fa-times-circle"></i>
          </div>
          <div>流失</div>
        </div>
        <div class="item" ref="item4" @click="changeStatus(4)">
          <div>
            <i class="el-icon-delete"></i>
          </div>
          <div>删除</div>
        </div>
      </div>
      <div class="tip">
        <div class="flow" v-if="status == 5">
          <div class="flow-comment">
            <span>流失备注:</span>
            <span>
              <el-input v-model="formData.flow_comment" placeholder="请输入内容" style="width:300px"></el-input>
            </span>
          </div>
        </div>
        <div class="active" v-if="status == 2">
          <div class="attend-doctor">
            <span>主治医生：</span>
            <span>
              <el-select v-model="formData.appointment_doctor" placeholder="请选择">
                <el-option
                  v-for="(item,index) in doctor"
                  :key="index"
                  :label="item.name"
                  :value="item.id"
                ></el-option>
              </el-select>
            </span>
          </div>
          <div class="type">
            <span>类别 :</span>
            <span>
              <el-radio-group v-model="formData.type">
                <el-radio label="0">初诊</el-radio>
                <el-radio label="1">复诊</el-radio>
              </el-radio-group>
            </span>
          </div>
        </div>
      </div>
      <div slot="footer" class="dialog-footer">
        <el-button @click="closeDialog">取 消</el-button>
        <el-button :loading="commitLoading" type="primary" @click="submitFrom">确 定</el-button>
      </div>
    </el-dialog>
  </div>
</template>

<script>
import { addClass, removeClass } from "@/common/util.js";
import DialogForm from "@/views/base/DialogForm";
export default {
  name: "StatusDialog",
  mixins: [DialogForm],
  props: ["yuyue_id"],
  inject: ["getTodayAppointment"],
  created() {},
  computed: {},
  data() {
    return {
      formData: {
        appointment_doctor: "",
        type: "",
        flow_comment: ""
      },
      status: "",
      name: "",
      doctor: null,
      appointment_data:null,
      commitLoading: false
    };
  },
  watch: {
    show(new_show, old_show) {
      if (new_show) {
        this.$api.appointment
          .getByIdAppointment({ id: this.yuyue_id })
          .then(res => {
            if (res.code == 200) {
              this.appointment_data = res.data;
              this.status = res.data.status;
              this.$nextTick(function() {
                this.$refs[
                  "item" + this.status
                ].style.backgroundColor = this.changeBg(this.status);
              });
              this.name = "更换预约状态: " + res.data.patient_name;
              this.formData.type = res.data.type;
              this.formData.appointment_doctor = res.data.appointment_doctor;
              this.formData.flow_comment = res.data.flow_comment;
            }
          });
        // 获取预约医生数据、
        this.$api.appointment.attendDoctor().then(res => {
          this.doctor = res.data;
        });
      }
    }
  },
  methods: {
    submitFrom() {
      let data ={ id: this.yuyue_id, status: this.status};
      if(this.status == 2){
        if(this.formData.type != this.appointment_data.type){
          data.type = this.formData.type;
        }
        if(this.formData.appointment_doctor != this.appointment_data.appointment_doctor){
          data.appointment_doctor = this.formData.appointment_doctor;
        }
      }
      if(this.status == 5){
        data.flow_comment = this.formData.flow_comment;
      }
      this.$api.appointment.changeAppointmentStatus(data).then(res => {
        if (res.code == 200) {
          this.getTodayAppointment();
          this.$api.appointment
            .getWeekAppointment({
              weekStart: this.$parent.weekStart,
              weekEnd: this.$parent.weekEnd
            })
            .then(res => {
              if (res.code == 200) {
                this.$parent.yuyue_week_res = res.data;
              }
            });
          this.closeDialog();
        }
      });
    },
    changeStatus(sv) {
      sv = sv.toString();
      let items = document.getElementsByClassName("item");
      items = Array.from(items);
      if (this.status == 2 && sv == 4) {
        return;
      }
      items.forEach(ele => {
        ele.style.backgroundColor = "";
      });
      this.$refs["item" + sv].style.backgroundColor = this.changeBg(sv);
      if (this.status == 3 && sv == 1) {
        return;
      }
      if (this.status == 2 && sv == 0) {
        this.status = 3;
        return;
      }

      this.status = sv;
    },
    changeBg(sv) {
      var bgv;
      switch (sv) {
        case "1":
          bgv = "rgb(160, 101, 238)";
          break;
        case "0":
          bgv = "#6bb15e";
          break;
        case "2":
          bgv = "rgb(50, 17, 233)";
          break;
        case "3":
          bgv = "#f17e1a";
          break;
        case "4":
          bgv = "#ff3646";
          break;
        case "5":
          bgv = "#ff4040";
          break;
      }
      return bgv;
    }
  },
  mounted() {}
};
</script>
<style lang="less" scoped>
@import "~@/assets/css/var.less";
.status-dialog {
  .content {
    display: flex;
    justify-content: space-around;
    .item {
      padding: 10px;
      border: 1px solid black;
      text-align: center;
      cursor: pointer;
      &.appoint:hover {
        background-color: #6bb15e;
      }
      &.expried:hover {
        background-color: #f17e1a;
      }
      &:hover:nth-of-type(2) {
        background-color: rgb(160, 101, 238);
      }
      &:hover:nth-of-type(3) {
        background-color: rgb(50, 17, 233);
      }
      &:hover:nth-of-type(4) {
        background-color: #ff4040;
      }
      &:hover:nth-of-type(5) {
        background-color: #ff3646;
      }
    }
  }
  .tip {
    display: flex;
    // border: 1px solid #000;
    padding-top: 30px;
    .active {
      margin: auto;
      .attend-doctor {
      }
      .type {
        padding: 20px;
        span:nth-of-type(2) {
          padding-left: 20px;
        }
      }
    }
    .flow {
      margin: auto;
      .flow-comment {
        span:nth-of-type(2) {
          padding-left: 20px;
        }
      }
    }
  }
}
</style>