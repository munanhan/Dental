<template>
  <el-dialog
    title="新增患者"
    :visible.sync="show"
    :before-close="closeDialog"
    class="custom-dialog"
    v-dialog-drag
    width="750px"
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
          style="width:300px"
          size="small"
          prop="name"
        >
          <el-input v-model="ruleForm.name"></el-input>
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
          style="width:300px"
          size="small"
          prop="name"
        >
          <el-input></el-input>
        </el-form-item>

        <div style="margin-top:10px;margin-left:50px">
          性&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          别&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <el-radio
            v-model="sex"
            label="1"
          >男</el-radio>
          <el-radio
            v-model="sex"
            label="2"
          >女</el-radio>
          <el-radio
            v-model="sex"
            label="3"
          >未填</el-radio>
        </div>
      </div>
      <div style="height:300px;overflow: auto">
        <div style="display:flex">
          <el-form-item
            label="电话1"
            prop="tel_one"
            style="width:215px"
          >
            <el-input
              v-model="tel_one"
              placeholder="请输入内容"
            ></el-input>
          </el-form-item>
          <el-select
            v-model="value"
            placeholder="选择"
            style="width:85px"
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

          <el-form-item
            label="电话2"
            prop="tel_one"
            style="width:210px"
          >
            <el-input
              v-model="tel_one"
              placeholder="请输入内容"
            ></el-input>
          </el-form-item>
          <el-select
            v-model="value"
            placeholder="选择"
            style="width:80px"
          >
            <el-option
              v-for="item in options"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            >
            </el-option>
          </el-select>
        </div>

        <div style="display:flex">
          <el-form-item
            label="生日年月"
            prop="birthday"
            style="width:300px"
          >
            <el-input autocomplete="off"></el-input>
          </el-form-item>
          <el-form-item
            style="margin-left:30px;width:300px"
            label="年龄"
          >
            <el-input></el-input>
          </el-form-item>
        </div>

        <div style="display:flex">
          <el-form-item label="患者来源">
            <el-select
              v-model="value"
              style="width:220px"
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
              v-model="category"
              label="1"
            >初诊</el-radio>
            <el-radio
              v-model="category"
              label="2"
            >复诊</el-radio>
          </div>
        </div>
        <div style="display:flex">
          <el-form-item label="就诊日期">
            <el-select
              v-model="value"
              style="width:220px"
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
            style="margin-left:50px;width:300px"
            label="主治医生"
            prop="attendingphysician"
            v-model="ruleForm.attendingphysician"
          >
            <el-input></el-input>
          </el-form-item>
        </div>

        <div style="display:flex">
          <el-form-item label="患者分类">
            <el-select
              v-model="value"
              style="width:220px"
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
            style="margin-left:20px;width:300px"
            label="患者备注"
          >
            <el-input></el-input>
          </el-form-item>

        </div>
        <div style="display:flex">
          <el-form-item label="会员等级">
            <el-select
              v-model="value"
              style="width:220px"
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
            style="margin-left:20px;width:300px"
            label="会员卡号"
          >
            <el-input></el-input>
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
              style="width:570px"
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
            <el-input style="width:570px"></el-input>
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
            <el-input style="width:570px"></el-input>
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
            <el-input style="width:220px"></el-input>

          </el-form-item>
          <el-form-item
            style="margin-left:60px;width:300px"
            label="电子邮箱"
          >
            <el-input></el-input>
          </el-form-item>
        </div>
        <div style="display:flex">
          <el-form-item label="患者印象">
            <el-input style="width:220px"></el-input>
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
            style="margin-left:30px;width:300px"
            label="电网咨询"
          >
            <el-input></el-input>
          </el-form-item>
        </div>
        <div style="display:flex">
          <el-form-item label="民族">
            <el-select
              style="width:220px"
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
            label="吸烟"
            style="margin-left:30px"
          >
            <div style="display:flex">
              <el-input style="width:100px"></el-input>
              <div style="margin-left:10px">次/天</div>
            </div>
          </el-form-item>
        </div>
        <div style="display:flex">
          <el-form-item label="刷牙">
            <div style="display:flex">
              <el-input style="width:60px"></el-input>
              <div style="margin-left:10px">次/天</div>
            </div>
          </el-form-item>

          <div style="display:flex">
            <el-input style="width:60px;margin-left:10px"></el-input>
            <div style="margin-left:10px;margin-top:13px">分钟/次</div>
          </div>
          <el-form-item
            label="洁牙习惯"
            style="margin-left:15px"
          >
            <el-input></el-input>
          </el-form-item>
          <i
            class="fa fa-cog"
            style="margin-top:10px;
                   font-size:20px;
                   cursor:pointer;
                   margin-left:10px
                  "
          ></i>

        </div>
      </div>
    </el-form>

    <div
      slot="footer"
      class="dialog-footer"
    >
      <el-button @click="closeDialog">读身份证</el-button>
      <el-button @click="closeDialog">清空</el-button>
      <el-button
        :loading="commitLoading"
        type="primary"
      >确 定</el-button>
      <el-button @click="closeDialog">取 消</el-button>

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
      options: [
        {
          value: "选项1",
          label: "爸爸"
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
      tel_one: "",
      value: "",
      ruleForm: {
        name: "",
        attendingphysician: ""
      },
      value1: null,
      sex: "1",
      category: "1",

      rules: {
        name: [
          { required: true, message: "请输入病历号", trigger: "blur" }
          // { min: 3, max: 5, message: "长度在 3 到 5 个字符", trigger: "blur" }
        ],
        attendingphysician: [
          { required: true, message: "请输入主治医生", trigger: "blur" }
        ],
        name: [
          { required: true, message: "请输入姓名", trigger: "blur" }
          // { min: 3, max: 5, message: "长度在 3 到 5 个字符", trigger: "blur" }
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
</style>