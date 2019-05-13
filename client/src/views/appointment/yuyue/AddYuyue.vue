<template>
  <el-dialog
    title="新增预约"
    :visible.sync="show"
    :before-close="closeDialog"
    class="custom-dialog"
    :close-on-click-modal="false"
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
          >
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
        <el-form-item label="病历号" prop="sick_id">
          <el-input v-model="formData.sick_id" type="text" autocomplete="off" placeholder></el-input>
        </el-form-item>
        <el-form-item label="姓名" prop="name" required>
          <el-input v-model="formData.name" type="text" autocomplete="off" placeholder></el-input>
        </el-form-item>
        <el-form-item label="电话" prop="phone" required>
          <el-input v-model="formData.phone" type="text" autocomplete="off" placeholder></el-input>
        </el-form-item>
      
        <el-form-item label="性别" prop="sex" required>
          <el-radio-group v-model="formData.sex">
            <el-radio label="男"></el-radio>
            <el-radio label="女"></el-radio>
          </el-radio-group>
        </el-form-item>

        <el-form-item prop="age" label="年龄" required>
          <el-input v-model="formData.age" type="text" autocomplete="off" placeholder></el-input>
        </el-form-item>

        <el-form-item prop="source" label="患者来源">
          <el-select v-model="formData.source" placeholder="请选择">
            <el-option label value></el-option>
            <el-option label="网络咨询" value="网络咨询"></el-option>
            <el-option label="朋友介绍" value="朋友介绍"></el-option>
            <el-option label="家住附近" value="家住附近"></el-option>
            <el-option label="诊所网站" value="诊所网站"></el-option>
          </el-select>
        </el-form-item>

        <el-form-item label="预约医生" prop="doctor_id">
          <el-input v-model="formData.doctor_id" type="text" autocomplete="off" placeholder></el-input>
        </el-form-item>
        <el-form-item label="就诊类型" prop="type_id" required>
          <el-radio-group v-model="formData.type_id">
            <el-radio label="初诊"></el-radio>
            <el-radio label="复诊"></el-radio>
          </el-radio-group>
        </el-form-item>
        <el-form-item label="患者备注" prop="comment">
          <el-input v-model="formData.comment" type="text" autocomplete="off" placeholder></el-input>
        </el-form-item>
        <el-form-item label="预约备注" prop="apt_comment">
          <el-input v-model="formData.apt_comment" type="text" autocomplete="off" placeholder></el-input>
        </el-form-item>
      </div>

      <div class="center">
        <el-form-item prop="apt_date" label-width="0">
          <el-input v-model="formData.apt_date" type="text" suffix-icon="el-icon-caret-bottom"></el-input>
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
              <div :key="index"
                :data-time="item + ':00'"
                :class="{
                  'gray':yuyue_time == item + ' : ' +'00'
              }"
              ></div>
              <div :key="index+20"
                :data-time="item + ':30'"
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
export default {
  name: "ChangePassword",
  mixins: [DialogForm],
  props: ["dayTime", "yuyue_time"],
  created() {
    
    this.$nextTick(function() {
      this.formData.apt_date = this.chooseDate;
    });
     this.$api.appointment.getCaseNumber().then(res=>{
       if (res.code == 200) {
         this.formData.sick_id = res.data
       }
     })
    
  },
  computed: {
    chooseDate() {
      return this.$store.state.chooseDate;
    }
  },
  data() {
    return {
      formData: {
        sick_id: "190418001",
        apt_date: "",
        source: "",
        items: ""
        // time_frame_begin:this.yuyue_time,
      },

      items_o: itemsOptions,
      checked_items: [],
      rules: {
        phone: telRules.concat({
          validator:(rule,value,callback)=>{
            if(!/^1[34578]\d{9}$/.test(value)){
              callback(new Error("请输入正确手机号码"))
            }else{
              callback();
            }
          }
        }),
      },

      commitLoading: false
    };
  },
  watch: {
    checked_items(newci, oldci) {
      this.formData.items = this.checked_items.join(",");
    },
    show(new_show, old_show) {
      this.$nextTick(function() {
        let gray = document.getElementsByClassName("gray");
      
        if(!this.yuyue_time){
          return;
        }
        let [H, i] = this.yuyue_time.split(":");
       
        this.formData.time_frame_begin = this.yuyue_time;
        H = +H + 1;
        if (new_show) {
     
          if (i != 30) {
            gray[0].innerHTML = `${this.yuyue_time}-${H}:00 (60m)`;
      
          } else {
            gray[0].innerHTML = `${this.yuyue_time}-${H}:30 (60m)`;
          }
          addClass(gray[0].nextSibling, "gray");
        } else {
          gray[0].innerHTML = "";
          removeClass(gray[0].nextSibling, "gray");
          removeClass(gray[0], "gray");
        }
      });
    }
  },
  methods: {
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
      addClass(event.target.nextSibling, "gray");

      let [H, i] = value.split(":");
      H = +H + 1;
      if (i != 30) {
        event.target.innerHTML = `${value}-${H}:00 (60m)`;
      } else {
        event.target.innerHTML = `${value}-${H}:30 (60m)`;
      }
      this.formData.time_frame_begin = value;
    },
    submitFrom() {
      let that = this;
      that.$refs["addYuyueFrom"].validate(valid => {
        if (valid) {
          that.commitLoading = true;

          that.$api.appointment
            .addAppointment(that.formData)
            .then(res => {
              if (res.code == 200) {
                that.$message({
                  message: "新增成功.",
                  type: "success",
                  duration: 800
                });

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
      this.$refs["addYuyueFrom"].resetFields();
    }
  },
  mounted() {}
};
</script>
<style lang="less" scoped>
@import "~@/assets/css/var.less";

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
          cursor: pointer;
          &:nth-of-type(2n) {
            border-top: none;
          }
          &.gray {
            flex: 0 1 auto;
            background-color: #ccc;
            color: #fff;
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
</style>