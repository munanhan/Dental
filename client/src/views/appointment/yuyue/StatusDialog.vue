<template>
  <div class="status-dialog">
    <el-dialog
      :title="name"
      :visible.sync="show"
      :before-close="closeDialog"
      class="custom-dialog"
      :close-on-click-modal="false"
      v-dialog-drag
    >
      <div class="content">
        <div class="item" ref="item3" @click="changeStatus(3)">
          <div>
            <i class="fas fa-exclamation-triangle"></i>
          </div>
          <div>过期</div>
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
        <div class="item" ref="item4" @click="changeStatus(4)">
          <div>
            <i class="el-icon-delete"></i>
          </div>
          <div>删除</div>
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
      status: "",
      name: "",
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
              this.status = res.data.status;
              console.log(this.status);
              this.name = "更换预约状态: " + res.data.name;
            }
          });
      }
    }
  },
  methods: {
    submitFrom() {
      let data = { id: this.yuyue_id, status: this.status };
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
      items.forEach(ele => {
        ele.style.backgroundColor = "";
      });
      this.$refs["item" + sv].style.backgroundColor = this.changeBg(sv);
      if (this.status == 3 && sv == 1) {
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
        case "2":
          bgv = "rgb(50, 17, 233)";
          break;
        case "3":
          bgv = "#f40";
          break;
        case "4":
          bgv = "rgb(226, 45, 14)";
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
      &:hover:nth-of-type(1) {
        background-color: #f40;
      }
      &:hover:nth-of-type(2) {
        background-color: rgb(160, 101, 238);
      }
      &:hover:nth-of-type(3) {
        background-color: rgb(50, 17, 233);
      }
      &:hover:nth-of-type(4) {
        background-color: rgb(226, 45, 14);
      }
    }
  }
}
</style>