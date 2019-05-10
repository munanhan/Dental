<template>
  <el-dialog
    title="预交款"
    :visible.sync="show"
    :before-close="closeDialog"
    class="custom-dialog"
    v-dialog-drag
    width="1000px"
    center
  >
    <el-form
      ref="form"
      :model="form"
      :rules="form.rules"
      label-width="80px"
    >
      <div class="Advan-content ">
        <div class="Advan-top">
          <div class="one"> 用户名</div>
          <div class="one"> 用户账号</div>
          <div
            class="one"
            style="margin-left:280px"
          > 预交款余额</div>
          <div
            class="two"
            style="color:#000"
          > 0.00</div>
        </div>
        <div class="Advan-middle">
          <div class="middle-left">
            <div style="display:flex">
              <el-form-item label="操作方式">
                <el-radio
                  style="margin-left:10px"
                  v-model="form.radio"
                  label="1"
                >充值</el-radio>
                <el-radio
                  v-model="form.radio"
                  label="2"
                >退款</el-radio>
                <el-radio
                  v-model="form.radio"
                  label="3"
                >转出</el-radio>
              </el-form-item>
              <el-form-item
                label="活动名称"
                style="margin-left:70px"
              >
                <el-select
                  v-model="form.value"
                  style="width:220px"
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
              <i
                class="fa fa-cog"
                style="margin-top:10px;
                 padding-left:10px;
                 font-size:20px;
                 cursor:pointer"
              ></i>
            </div>
            <div style="display:flex">
              <el-form-item label="充值金额">
                <el-input></el-input>
              </el-form-item>
              <el-form-item
                label="赠送金额"
                style="margin-left:75px"
              >
                <el-input></el-input>
              </el-form-item>
            </div>
            <div style="display:flex">
              <el-form-item label="经 手 人">
                <el-input></el-input>
              </el-form-item>
              <el-form-item
                label="备注申明"
                style="margin-left:75px"
              >
                <el-input></el-input>
              </el-form-item>
            </div>
          </div>
          <div class="middle-right">
            <div style="margin:40px 0">
              <el-button
                type="primary"
                style="width:100px"
              >充值</el-button>
            </div>
            <div>
              <el-button style="width:100px">打印全部</el-button>
              <i
                class="fa fa-cog"
                style="margin-top:10px;
                 padding-left:10px;
                 font-size:20px;
                 cursor:pointer"
              ></i>
            </div>
          </div>
        </div>
        <div class="Advan-bottom">
          <el-table
            border
            style="width: 100%"
            :header-cell-style="{backgroundColor:'#e3e3e3',color:'#3a3a3a'}"
          >
            <el-table-column
              prop="date"
              label="打印"
            >
            </el-table-column>
            <el-table-column
              prop="name"
              label="操作"
            >
            </el-table-column>
            <el-table-column
              prop="address"
              label="操作时间"
            >
            </el-table-column>
            <el-table-column
              prop="date"
              label="收费方式"
            >
            </el-table-column>
            <el-table-column
              prop="name"
              label="开票方式"
            >
            </el-table-column>
            <el-table-column
              prop="address"
              label="收入"
            >
            </el-table-column>
            <el-table-column
              prop="date"
              label="支出"
            >
            </el-table-column>
            <el-table-column
              prop="name"
              label="余额"
            >
            </el-table-column>
            <el-table-column
              prop="address"
              label="经手人"
            >
            </el-table-column>
            <el-table-column
              prop="address"
              label="备注"
              width="120"
            >
            </el-table-column>
          </el-table>
        </div>
      </div>
    </el-form>

    <div
      slot="footer"
      class="dialog-footer"
    >
      <el-button @click="closeDialog">取 消</el-button>
      <el-button type="primary">确 定</el-button>
    </div>
  </el-dialog>
</template>

<script>
import DialogForm from "../base/DialogForm";
export default {
  name: "AdvancePayment",

  mixins: [DialogForm],

  data() {
    return {
      form: {
        radio: "1",

        options: [
          {
            value: "选项1",
            label: "黄金糕"
          },
          {
            value: "选项2",
            label: "双皮奶"
          },
          {
            value: "选项3",
            label: "蚵仔煎"
          },
          {
            value: "选项4",
            label: "龙须面"
          },
          {
            value: "选项5",
            label: "北京烤鸭"
          }
        ],
        value: "",
        rules: {}
      }
    };
  },

  methods: {}
};
</script>
<style lang="less" scoped>
.Advan-content {
  .Advan-top {
    display: flex;
    border: 1px solid red;
    font-size: 15px;
    width: 100%;
    height: 40px;
    background-color: #f9f9f9;
    border: 1px solid #f6f6f6;
    .one {
      margin-top: 10px;
      margin-left: 50px;
    }
    .two {
      margin-top: 6px;
      margin-left: 10px;
      font-size: 20px;
      font-weight: bold;
    }
  }
  .Advan-middle {
    display: flex;
    height: 200px;

    width: 100%;
    .middle-left {
      margin-top: 20px;
      width: 100%;
      .el-input {
        width: 220px;
      }
    }
    .middle-right {
      width: 20%;
    }
  }
  .Advan-bottom {
  }
}
</style>