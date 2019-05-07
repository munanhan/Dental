<template>
  <el-dialog
    title="修改信息"
    :visible.sync="show"
    :before-close="closeDialog"
    class="custom-dialog"
    v-dialog-drag
    width="940px"
    top="1vh"
  >
    <el-form
      ref="form"
      :model="form"
      label-width="80px"
      :rules="rules"
    >
      <!----------------------- 基本资料 -->

      <div class="mod-1">
        <div style="position: relative;">
          <div style="display:flex">
            <div
              class="number"
              style="background-color:red;margin-right:3px"
            >1</div>
            <div class="number">基本资料</div>
          </div>
        </div>
        <div style="border:1px solid red;
                    position: absolute;
                    right:0;    
                    margin-right: 244px;
                    width: 300px;
                    height: 286px;">
          asdasd
        </div>
        <el-form-item
          label="病历号"
          class="left-width"
          prop="medical_record"
        >
          <el-input></el-input>
          <!-- <i
            class="fa fa-cog"
            style="margin-top:10px;
                   font-size:20px;
                   cursor:pointer;
                   margin-left:10px
                    "
          ></i> -->
        </el-form-item>

        <el-form-item
          label="姓名"
          class="left-width"
          prop="name"
        >
          <el-input v-model="form.name"></el-input>
        </el-form-item>
        <el-form-item
          label="性别"
          class="left-width"
        >
          <el-radio
            v-model="form.radio"
            label="1"
          >男</el-radio>
          <el-radio
            v-model="form.radio"
            label="2"
          >女</el-radio>
          <el-radio
            v-model="form.radio"
            label="3"
          >未填</el-radio>
        </el-form-item>
        <el-form-item
          label="出生年月"
          class="left-width"
        >
          <el-input></el-input>
        </el-form-item>
        <el-form-item
          label="年龄(岁)"
          class="left-width"
        >
          <el-input></el-input>
        </el-form-item>

        <!-- </div> -->

        <div style="display:flex">
          <el-form-item
            label="电话1"
            prop="phone_one"
            style="width:230px"
          >
            <el-input
              placeholder="请输入内容"
              v-model="form.phone_one"
            ></el-input>
          </el-form-item>
          <el-select
            v-model="form.one"
            style="width:110px"
          >

            <el-option
              v-for="item in form.tel_one"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            >
            </el-option>
          </el-select>
          <el-form-item
            label="电话1"
            prop="phone_one"
            style="width:230px"
          >
            <el-input
              placeholder="请输入内容"
              v-model="form.phone_one"
            ></el-input>
          </el-form-item>
          <el-select
            v-model="form.tel_one"
            style="width:110px"
          >

           <el-option
              v-for="item in form.phone"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            >
            </el-option>
          </el-select>
        </div>
        <div style="display:flex">
          <el-form-item
            label="会员等级"
            class="left-width"
          >
            <el-input></el-input>
          </el-form-item>
          <el-form-item
            label="会员卡号"
            class="right-width"
          >
            <el-input></el-input>
          </el-form-item>
        </div>
        <div style="display:flex">
          <el-form-item
            label="职业"
            class="left-width"
          >
            <el-input></el-input>
          </el-form-item>
          <el-form-item
            label="社保号"
            class="right-width"
          >
            <el-input></el-input>
          </el-form-item>
        </div>
        <div style="display:flex">
          <el-form-item
            label="电子邮箱"
            class="left-width"
          >
            <el-input></el-input>
          </el-form-item>
          <el-form-item
            label="患者分组"
            class="right-width"
          >
            <el-input></el-input>
          </el-form-item>
        </div>
        <el-form-item
          label="患者备注"
          style="width:680px"
        >
          <el-input></el-input>
        </el-form-item>
        <div style="display:flex">
          <el-form-item
            label="介绍人"
            class="left-width"
          >
            <el-input></el-input>
          </el-form-item>
          <el-form-item
            label="咨询师"
            class="right-width"
          >
            <el-input></el-input>
          </el-form-item>
        </div>
        <el-form-item
          label="联系地址"
          style="width:680px"
        >
          <el-input></el-input>
        </el-form-item>
        <div style="display:flex">
          <el-form-item
            label="患者印象"
            class="left-width"
          >
            <el-input></el-input>
          </el-form-item>
          <el-form-item
            label="电网咨询"
            class="right-width"
          >
            <el-input></el-input>
          </el-form-item>
        </div>

        <!-------------------- 就诊信息  -->

        <div style="display:flex">
          <div
            class="number"
            style="background-color:red;margin-right:3px"
          >2</div>
          <div class="number">就诊信息</div>
        </div>
        <div style="display:flex">
          <el-form-item
            label="患者来源"
            class="left-width"
          >
            <el-input></el-input>
          </el-form-item>
          <el-form-item
            label="患者信息"
            class="right-width"
          >
            <el-input></el-input>
          </el-form-item>
        </div>
        <el-form-item
          label="过敏使"
          style="width:680px"
        >
          <el-input></el-input>
        </el-form-item>
        <el-form-item
          label="既往使"
          style="width:680px"
        >
          <el-input></el-input>
        </el-form-item>
        <div style="display:flex">
          <el-form-item
            label="患者来源"
            class="left-width"
          >
            <el-input></el-input>
          </el-form-item>
          <el-form-item
            label="患者分类"
            class="right-width"
          >
            <el-input></el-input>
          </el-form-item>
        </div>
        <div style="display:flex">
          <el-form-item
            label="刷牙"
            prop="brush_teeth"
          >
            <div style="display:flex">
              <el-input
                style="width:80px"
                v-model="form.brush_teeth_Timeday"
              ></el-input>
              <div style="margin-left:10px">次/天</div>
            </div>
          </el-form-item>
          <el-input
            v-model="form.brush_teeth_minutestime"
            style="width:80px;
                   margin-left:10px"
          ></el-input>
          <div style="margin-left:10px;
                      margin-top:13px">分钟/次</div>

          <el-form-item
            label="吸烟"
            style="margin-left:30px"
            prop="smoking"
          >
            <div style="display:flex">
              <el-input
                style="width:150px"
                v-model="form.smoking"
              ></el-input>
              <div style="margin-left:10px">次/天</div>
            </div>
          </el-form-item>
        </div>
        <el-form-item
          label="洁牙习惯"
          style="width:680px"
        >
          <el-input></el-input>
        </el-form-item>
        <div style="display:flex">
          <el-form-item
            label="初诊医生"
            class="left-width"
          >
            <el-input></el-input>
          </el-form-item>
          <el-form-item
            label="初诊日期"
            class="right-width"
          >
            <el-input></el-input>
          </el-form-item>
        </div>
        <div style="display:flex">
          <el-form-item
            label="复诊医生"
            class="left-width"
          >
            <el-input></el-input>
          </el-form-item>
          <el-form-item
            label="复诊日期"
            class="right-width"
          >
            <el-input></el-input>
          </el-form-item>
        </div>
        <!-- ----------------亲友关系----------- -->
        <div style="display:flex">
          <div
            class="number"
            style="background-color:red;margin-right:3px"
          >3</div>
          <div class="number">亲友关系</div>
        </div>
        <el-table
          border
          style="width: 100%"
        >
          <el-table-column
            prop="date"
            label="关系"
            width="100"
          >
          </el-table-column>
          <el-table-column
            prop="participant_name"
            label="关系人姓名"
            width="100"
          >
          </el-table-column>
          <el-table-column
            prop="date"
            label="性别"
            width="80"
          >
          </el-table-column>
          <el-table-column
            prop="name"
            label="电话"
            width="140"
          >
          </el-table-column>
          <el-table-column
            prop="date"
            label="会员等级"
            width="100"
          >
          </el-table-column>
          <el-table-column
            prop="name"
            label="会员号"
            width="100"
          >
          </el-table-column>
          <el-table-column
            prop="date"
            label="备注"
            width="120"
          >
          </el-table-column>
          <el-table-column
            prop="name"
            label="修改"
            width="80"
          >
          </el-table-column>
          <el-table-column
            prop="address"
            label="删除"
          >
          </el-table-column>
        </el-table>

      </div>

    </el-form>

    <div
      slot="footer"
      class="dialog-footer"
    >
      <el-button
        :loading="commitLoading"
        type="primary"
      >确 定</el-button>
      <el-button
        @click="closeDialog"
        type="primary"
      >新增关系</el-button>
      <el-button @click="closeDialog">取 消</el-button>

    </div>
  </el-dialog>
</template>


<script>
import AddDialogForm from "../base/AddDialogForm";
export default {
  name: "AddPatient",

  mixins: [AddDialogForm],

  data() {
    return {
      form: {
        tel_one:[{
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

        phone: [{
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
        tel_one:'',
        one:"",
        radio: "1",
        name: "",
        medical_record: "",
        participant_name: ""
        // options:"",
      },
      rules: {
        name: [
          { required: true, message: "请输入病历号", trigger: "blur" }
          // { min: 3, max: 5, message: '长度在 3 到 5 个字符', trigger: 'blur' }
        ],
        medical_record: [
          { required: true, message: "请输入姓名", trigger: "blur" }
          // { min: 3, max: 5, message: '长度在 3 到 5 个字符', trigger: 'blur' }
        ]
      }
    };
  },

  methods: {}
};
</script>

<style lang="less" scoped>
//导入全局的颜色
@import "~@css/var";
.mod-1 {
  .number {
    font-size: 18px;
    

    font-weight: bold;
    // rgb(110, 240, 149)
    margin-bottom: 10px;
  }
  .left-width {
    width: 340px;
  }
  .right-width {
    width: 340px;
  }
}
</style>