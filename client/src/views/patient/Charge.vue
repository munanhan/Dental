<template>
  <el-dialog
    title="收费"
    :visible.sync="show"
    :before-close="closeDialog"
    :close-on-click-modal="false"
    class="custom-dialog"
    v-dialog-drag
    width="1010px"
    top="2vh"
  >
    <el-form
      ref="form"
      :model="form"
      label-width="80px"
      :rules="form.rules"
    >
      <div class="charge-content">
        <div class="charge-top">
          <div class="left">1503010120</div>
          <div class="left">8岁</div>
          <div class="left">*(无病历号)</div>
          <div class="right">收费时间:</div>
          <div style="margin-top:5px">
            <el-date-picker
              type="datetime"
              style="margin-left:10px"
              size="mini"
              placeholder="选择日期时间"
            >
            </el-date-picker>
          </div>

        </div>
        <div class="charge-middle">
          <div class="left-content">
            <div class="charge-upperleft">
            </div>
            <div class="chagre-lowerleft">
              <div style="display:flex">
                <el-form-item
                  prop="doctor"
                  label="医生"
                >
                  <el-select
                    class="lower-input"
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
                <el-form-item label="收款人">
                  <el-select
                    class="lower-input"
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
                <div style="display:flex">
                  <el-form-item label="本单折扣">
                    <el-input class="lower-input"></el-input>
                  </el-form-item>
                  <span class="lower-span">%</span>
                </div>
              </div>
              <div style="display:flex">
                <el-form-item
                  label="护士"
                  prop="nurse"
                >
                  <el-select
                    class="lower-input"
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
                <el-form-item label="备注">
                  <el-input style="width:360px"></el-input>
                </el-form-item>
              </div>
              <div style="display:flex">

                <el-form-item label="疾病名称">
                  <el-select
                    class="lower-input"
                    v-model="form.value"
                    style="width:280px"
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
                <el-form-item label="疾病编码">
                  <el-input
                    style="width:180px"
                    class="lower-input"
                  ></el-input>
                </el-form-item>
              </div>

            </div>
          </div>
          <div class="charge-right">
            <div style="margin-left:80px;
                        display:flex;
                        margin-top:20px">
              <div style="margin-top:5px;
                          font-size:15px">上次欠款</div>
              <div style="font-weight:bold;
                          color:#000;
                          margin-left:115px;
                          font-size:25px">0.00</div>
            </div>
            <div style="margin-left:80px;
                        display:flex;
                        margin-top:10px">
              <div style="margin-top:5px;
                          font-size:15px">本次费用</div>
              <div style="font-weight:bold;
                          color:#000;
                          margin-left:115px;
                          font-size:25px">0.00</div>
            </div>
            <div style="margin-left:60px;
                        display:flex;
                        margin-top:20px">
              <div style="margin-top:5px;
                          font-size:20px;
                          font-weight:bold;
                          color:#000">合计应收</div>
              <div style="font-weight:bold;
                          color:#000;margin-left:115px;
                          font-size:25px">0.00</div>
            </div>
            <div style="margin-left:40px;
                        display:flex;
                        margin-top:30px">
              <div style="margin-top:10px;
                          font-size:20px;
                          font-weight:bold;
                          color:#000">优惠后金额</div>
              <el-form-item>
                <el-input style="width:170px;margin-left:-75px"></el-input>
              </el-form-item>
            </div>
            <div style="display:flex">
              <el-form-item>
                <el-select
                  v-model="value"
                  placeholder="请选择"
                  style="width:130px;margin-left:-70px"
                >
                  <el-option
                    v-for="item in options"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value"
                  >
                  </el-option>
                </el-select>
              </el-form-item>
              <el-form-item>
                <el-input style="width:170px;margin-left:-75px"></el-input>
              </el-form-item>
            </div>
            <div style="display:flex">
              <el-form-item>
                <el-select
                  v-model="value"
                  placeholder="请选择"
                  style="width:130px;margin-left:-70px"
                >
                  <el-option
                    v-for="item in options"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value"
                  >
                  </el-option>
                </el-select>
              </el-form-item>
              <el-form-item>
                <el-input style="width:100px;margin-left:-75px"></el-input>
              </el-form-item>
              <el-form-item>
                <el-button style="width:65px;margin-left:-75px">确定</el-button>
              </el-form-item>
            </div>
            <div style="margin-left:80px;display:flex;">
              <div style="margin-top:5px;font-size:20px;font-weight:bold;color:#000">欠&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;款</div>
              <div style="font-weight:bold;color:#000;margin-left:100px;font-size:25px">0.00</div>
            </div>
            <div style="margin-left:80px;display:flex;margin-top:40px">
              <div style="margin-top:5px;font-size:20px;font-weight:bold;color:#000">找&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;零</div>
              <div style="font-weight:bold;color:#000;margin-left:100px;font-size:25px">0.00</div>
            </div>
          </div>
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
  name: "Charge",

  mixins: [DialogForm],

  data() {
    return {
      form: {
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

        rules: {
          doctor: [
            { required: true, message: "请输入活动名称", trigger: "blur" },
            { min: 3, max: 5, message: "长度在 3 到 5 个字符", trigger: "blur" }
          ],
          nurse: [
            { required: true, message: "请输入活动名称", trigger: "blur" },
            { min: 3, max: 5, message: "长度在 3 到 5 个字符", trigger: "blur" }
          ]
        }
      }
    };
  },

  methods: {}
};
</script>
<style lang="less" scoped>
.charge-content {
  .charge-top {
    display: flex;
    font-size: 15px;
    width: 100%;
    height: 40px;
    background-color: #f9f9f9;
    border: 1px solid #f6f6f6;
    .left {
      margin-top: 10px;
      margin-left: 20px;
    }
    .right {
      margin-top: 10px;
      color: #606266;
      margin-left: 370px;
    }
  }
  .charge-middle {
    margin-top: 30px;
    display: flex;
    // border:1px solid red;
    height: 500px;
    .left-content {
      // border: 1px solid red;
      height: 500px;
      width: 690px;
      .charge-upperleft {
        border: 2px solid #e3e3e3;
        height: 320px;
      }
      .chagre-lowerleft {
        // border: 1px solid red;
        margin-top: 10px;
        .lower-input {
          width: 130px;
        }
        .lower-span {
          font-size: 20px;
          margin-top: 10px;
          margin-left: 5px;
        }
      }
    }
    .charge-right {
      border: 1px solid #b9b9b9;
      background-color: #f3f3f3;
      height: 500px;
      width: 400px;
      margin-left: 10px;
    }
  }
}
</style>