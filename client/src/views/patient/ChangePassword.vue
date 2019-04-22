<template>
  <el-dialog
    title="新增患者"
    :visible.sync="show"
    :before-close="closeDialog"
    class="custom-dialog"
    v-dialog-drag
    width="700px"
    top="3vh"
  >
    <el-form
      ref="changePwdForm"
      label-width="80px"
      :rules="rules"
    >
      <div style="display:flex">
        <el-form-item
          label="病历号"
          prop="name"
        >
          <el-input
            type="password"
            v-model="ruleForm.name"
          ></el-input>
        </el-form-item>
        <i
          class="fa fa-cog"
          style="margin-top:10px;
                 padding-left:10px;
                 font-size:20px;
                 cursor:pointer"
        ></i>
        <div
          class="block"
          style="margin-top:10px;
                 margin-left:40px;
                 margin-right:40px"
        >
          <span class="demonstration"></span>
          <el-rate v-model="value1"></el-rate>
        </div>
        <div class="block">
          <el-button
            round
            style="margin-right:10px"
          >新增头像</el-button>
        </div>
        <i
          class="fa fa-cog"
          style="margin-top:10px;
                 font-size:20px;
                 margin-right:10px;
                 cursor:pointer"
        ></i>
        <i
          class="el el-icon-question"
          style="margin-top:10px;
                 font-size:20px;
                 cursor:pointer"
        ></i>
      </div>

      <div style="display:flex">
        <el-form-item
          label="姓名"
          prop="name"
        >
          <el-input type="password"></el-input>
        </el-form-item>

        <div style="margin-top:10px;margin-left:50px">
          性&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          别&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <el-radio
            v-model="radio"
            label="1"
          >男</el-radio>
          <el-radio
            v-model="radio"
            label="2"
          >女</el-radio>
          <el-radio v-model="radio">未填</el-radio>
        </div>
      </div>
      <div style="height:300px;overflow: auto">
        <div style="display:flex">
          <el-form-item label="电话1">
            <el-input type="password"></el-input>
          </el-form-item>
          <i
            class="fa fa-cog"
            style="margin-top:10px;
                 font-size:20px;
                 cursor:pointer;
                 margin-left:10px
                  "
          ></i>

          <el-form-item label="电话2">
            <el-select
              v-model="value"
              placeholder="请选择"
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
        </div>

        <div style="display:flex">
          <el-form-item label="出生年月">
            <el-input type="password"></el-input>
          </el-form-item>
          <el-form-item
            style="margin-left:30px"
            label="年龄"
          >
            <el-input type="password"></el-input>
          </el-form-item>
        </div>

        <div style="display:flex">
          <el-form-item label="患者来源">
            <el-select
              v-model="value"
              placeholder="请选择"
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
          <i
            class="fa fa-cog"
            style="margin-top:10px;
                 font-size:20px;
                 margin-right:10px;
                 cursor:pointer;
                 margin-left:10px
                  "
          ></i>
          <div style="margin-top:10px;margin-left:10px">
            类&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            别&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <el-radio
              v-model="radio"
              label="1"
            >初诊</el-radio>
            <el-radio
              v-model="radio"
              label="2"
            >复诊</el-radio>
          </div>
        </div>
        <div style="display:flex">
          <el-form-item label="就诊日期">
            <el-select
              v-model="value"
              placeholder="请选择"
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

          <el-form-item
            style="margin-left:50px"
            label="主治医生"
            prop="name"
          >
            <el-input type="password"></el-input>
          </el-form-item>
        </div>

        <div style="display:flex">
          <el-form-item label="患者分类">
           <el-select
              v-model="value"
              placeholder="请选择"
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
          <i
            class="fa fa-cog"
            style="margin-top:10px;
                 font-size:20px;
                 cursor:pointer;
                 margin-left:10px
                  "
          ></i>
          <el-form-item
            style="margin-left:20px"
            label="患者备注"
          >
            <el-input type="password"></el-input>
          </el-form-item>

        </div>
        <div style="display:flex">
          <el-form-item label="会员等级">
            <el-select
              v-model="value"
              placeholder="请选择"
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
          <i
            class="fa fa-cog"
            style="margin-top:10px;
                 font-size:20px;
                 cursor:pointer;
                 margin-left:10px
                  "
          ></i>

          <el-form-item
            style="margin-left:20px"
            label="会员卡号"
          >
            <el-input type="password"></el-input>
          </el-form-item>
        </div>
        <div>
          <el-form-item
            autocomplete="off"
            label="联系地址"
          >
            <!-- <el-select style="width:530px">
              <el-option
                v-for="item in options"
                :key="item.value"
                :label="item.label"
                :value="item.value"
              >
              </el-option>
            </el-select> -->
            <el-select
              v-model="value"
              placeholder="请选择"
               style="width:530px"
            >
              <el-option
                v-for="item in options"
                :key="item.value"
                :label="item.label"
                :value="item.value"
              >
              </el-option>
            </el-select>
            <i
              class="fa fa-cog"
              style="margin-top:10px;
                 font-size:20px;
                 cursor:pointer;
                 margin-left:10px
                  "
            ></i>
          </el-form-item>
        </div>
        <div>
          <el-form-item label="过 敏 使">
            <el-input
              type="password"
              style="width:530px"
            ></el-input>
            <i
              class="fa fa-cog"
              style="margin-top:10px;
                 font-size:20px;
                 margin-left:10px;
                 cursor:pointer;
                  "
            ></i>
          </el-form-item>
        </div>
        <div>
          <el-form-item label="既 往 史">
            <el-input
              type="password"
              style="width:530px"
            ></el-input>
            <i
              class="fa fa-cog"
              style="margin-top:10px;
                 font-size:20px;
                 margin-left:10px;
                 cursor:pointer;
                  "
            ></i>
          </el-form-item>
        </div>
        <div style="display:flex">
          <el-form-item label="社保号">
            <el-input type="password"></el-input>
          </el-form-item>
          <el-form-item
            style="margin-left:45px"
            label="电子邮箱"
          >
            <el-input type="password"></el-input>
          </el-form-item>
        </div>
        <div style="display:flex">
          <el-form-item label="患者印象">
            <el-input type="password"></el-input>
          </el-form-item>
          <el-form-item
            style="margin-left:45px"
            label="电网咨询"
          >
            <el-input type="password"></el-input>
          </el-form-item>
        </div>
        <div style="display:flex">
          <el-form-item label="民族">
            <el-input type="password"></el-input>
          </el-form-item>
          <el-form-item
            style="margin-left:45px"
            label="吸烟"
          >
            <el-input type="password"></el-input>
          </el-form-item>
        </div>
        <div style="display:flex">
          <el-form-item label="刷牙">
            <el-input type="password"></el-input>
          </el-form-item>
        </div>
      </div>
    </el-form>

    <div
      slot="footer"
      class="dialog-footer"
    >
      <el-button @click="closeDialog">读身份证</el-button>
      <el-button @click="closeDialog">清空</el-button>
      <el-button @click="closeDialog">取 消</el-button>
      <el-button
        :loading="commitLoading"
        type="primary"
      >确 定</el-button>
    </div>

  </el-dialog>
</template>


<script>
import AddDialogForm from "../base/AddDialogForm";
export default {
  name: "ChangePassword",

  mixins: [AddDialogForm],

  data() {
    return {

      options: [{
          value: '选项1',
          label: '黄金糕'
        }, {
          value: '选项2',
          label: '双皮奶'
        }, {
          value: '选项3',
          label: '蚵仔煎'
        }, {
          value: '选项4',
          label: '龙须面'
        }, {
          value: '选项5',
          label: '北京烤鸭'
        }],
        value: '',
      ruleForm: {
        name: ""
      },
      value1: null,
      radio: "1",

      rules: {
        name: [
          { required: true, message: "请输入病历号", trigger: "blur" }
          // { min: 3, max: 5, message: "长度在 3 到 5 个字符", trigger: "blur" }
        ]
      }
    };
  },

  methods: {}
};
</script>
<style lang="less" scoped>
</style>