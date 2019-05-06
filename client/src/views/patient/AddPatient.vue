<template>
  <el-dialog
    title="新增患者"
    :visible.sync="show"
    :before-close="closeDialog"
    class="custom-dialog"
    v-dialog-drag
    width="750px"
  >
    <el-form
      ref="changePwdForm"
      label-width="80px"
      :rules="form.rules"
      :model="form"
    >
      <div style="display:flex">
        <el-form-item
          label="病历号"
          style="width:300px"
          size="small"
          prop="anamnesis"
        >
          <el-input v-model="form.anamnesis"></el-input>
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
          <el-rate v-model="form.value1"></el-rate>
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
          <el-input v-model="form.name"></el-input>
        </el-form-item>

        <div style="margin-top:10px;margin-left:50px">
          性&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          别&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <el-radio
            v-model="form.sex"
            label="1"
          >男</el-radio>
          <el-radio
            v-model="form.sex"
            label="2"
          >女</el-radio>
          <el-radio
            v-model="form.sex"
            label="3"
          >未填</el-radio>
        </div>
      </div>
      <div style="height:300px;overflow: auto">
        <div style="display:flex">
          <el-form-item
            label="电话1"
            prop="phone_one"
            style="width:210px"
          >
            <el-input
              placeholder="请输入内容"
              v-model="form.phone_one"
            ></el-input>
          </el-form-item>
          <el-select
            v-model="form.tel_one"
            style="width:90px"
          >
            <el-option
              label="   "
              value="1"
            ></el-option>
            <el-option
              label="爸爸"
              value="2"
            ></el-option>
            <el-option
              label="妈妈"
              value="3"
            ></el-option>
            <el-option
              label="妈妈妈"
              value="4"
            ></el-option>
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
            prop="phone_two"
            style="width:210px"
          >
            <el-input
              placeholder="请输入内容"
              v-model="form.phone_two"
            ></el-input>
          </el-form-item>
          <el-select
            v-model="form.two"
            placeholder="选择"
            style="width:90px"
          >
            <el-option
              v-for="item in form.tel_two"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            >
            </el-option>
          </el-select>
        </div>

        <div style="display:flex">
          <el-form-item
            label="出生年月"
            prop="birthday"
            style="width:300px"
          >
            <el-input
              autocomplete="off"
              v-model="form.birthday"
            ></el-input>
          </el-form-item>
          <el-form-item
            style="margin-left:30px;width:300px"
            label="年 龄"
            prop="age"
          >
            <el-input v-model="form.age"></el-input>
          </el-form-item>
        </div>

        <div style="display:flex">
          <el-form-item
            label="患者来源"
            prop="patients_source"
          >
            <el-select
              v-model="form.patients_source"
              placeholder="请选择活动区域"
              style="width:220px"
            >
              <el-option
                label="   "
                value="guiling"
              ></el-option>
              <el-option
                label="网络咨询"
                value="shanghai"
              ></el-option>
              <el-option
                label="朋友介绍"
                value="beijing"
              ></el-option>
              <el-option
                label="家住附近"
                value="shenzhen"
              ></el-option>
              <el-option
                label="诊所网站"
                value="guangzhou"
              ></el-option>
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
              v-model="form.category"
              label="1"
            >初诊</el-radio>
            <el-radio
              v-model="form.category"
              label="2"
            >复诊</el-radio>
          </div>
        </div>
        <div style="display:flex">
          <el-form-item
            label="就诊日期"
            prop="clinic_date"
          >
            <el-select
              v-model="form.clinic_date"
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

          <el-form-item
            style="margin-left:50px;width:300px"
            label="主治医生"
            prop="attendingphysician"
          >
            <el-input v-model="form.attendingphysician"></el-input>
          </el-form-item>
        </div>

        <div style="display:flex">
          <el-form-item
            label="患者分类"
            prop="classification_patients"
          >
            <el-select
              v-model="form.classification_patients"
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
                   font-size:20px;
                   cursor:pointer;
                   margin-left:10px
                   "
          ></i>
          <el-form-item
            style="margin-left:20px;width:300px"
            prop="patient_note"
            label="患者备注"
          >
            <el-input v-model="form.patient_note"></el-input>
          </el-form-item>

        </div>
        <div style="display:flex">
          <el-form-item
            label="会员等级"
            prop="membership_grade"
          >
            <el-select
              v-model="form.membership_grade"
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
                   font-size:20px;
                   cursor:pointer;
                   margin-left:10px
                   "
          ></i>

          <el-form-item
            style="margin-left:20px;width:300px"
            label="会员卡号"
            prop="mem_card_number"
          >
            <el-input v-model="form.mem_card_number"></el-input>
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
              v-model="form.value"
              placeholder="请选择"
              style="width:570px"
            >
              <el-option
                v-for="item in form.options"
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
          <el-form-item
            label="社保号"
            prop="social_security"
          >
            <el-input
              style="width:220px"
              v-model="form.social_security"
            ></el-input>

          </el-form-item>
          <el-form-item
            style="margin-left:60px;width:300px"
            label="电子邮箱"
            porp="email"
          >
            <el-input v-model="form.email"></el-input>
          </el-form-item>
        </div>
        <div style="display:flex">
          <el-form-item
            label="患者印象"
            prop="patients_impression"
          >
            <el-input
              style="width:220px"
              v-model="form.patients_impression"
            ></el-input>
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
            prop="grid_consulting"
          >
            <el-input v-model="form.grid_consulting"></el-input>
          </el-form-item>
        </div>
        <div style="display:flex">
          <el-form-item
            label="民族"
            porp="national"
          >
            <el-select
              style="width:220px"
              v-model="form.national"
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
                   font-size:20px;
                   cursor:pointer;
                   margin-left:10px
                  "
          ></i>
          <el-form-item
            label="吸烟"
            style="margin-left:30px"
            prop="smoking"
          >
            <div style="display:flex">
              <el-input
                style="width:100px"
                v-model="form.smoking"
              ></el-input>
              <div style="margin-left:10px">次/天</div>
            </div>
          </el-form-item>
        </div>
        <div style="display:flex">
          <el-form-item
            label="刷牙"
            prop="brush_teeth"
          >
            <div style="display:flex">
              <el-input
                style="width:60px"
                v-model="form.brush_teeth_Timeday"
              ></el-input>
              <div style="margin-left:10px">次/天</div>
            </div>
          </el-form-item>

          <div style="display:flex">
            <el-input
              v-model="form.brush_teeth_minutestime"
              style="width:60px;
                             margin-left:10px"
            ></el-input>
            <div style="margin-left:10px;
                        margin-top:13px">分钟/次</div>
          </div>
          <el-form-item
            label="洁牙习惯"
            prop="teeth_cleaning_habits"
            style="margin-left:46px;
                   width:300px"
          >
            <el-input v-model="form.teeth_cleaning_habits"></el-input>
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
  name: "AddPatient",

  mixins: [AddDialogForm],

  data() {
    return {
      form: {
        tel_two: [
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
        two: "",
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
        patients_source: "guiling",
        birthday: "",
        tel_one: "",
        phone_one: "",
        value: "",
        value1: null,
        sex: "1",
        category: "1",
        mem_card_number: "",
        social_security: "",
        email: "",
        smoking: "",
        patients_impression: "",
        patient_note: "",
        grid_consulting: "",
        brush_teeth_Timeday: "",
        brush_teeth_minutestime: "",
        teeth_cleaning_habits: "",

        name: "",
        attendingphysician: "",
        anamnesis: "",

        rules: {
          attendingphysician: [
            { required: true, message: "请输入主治医生", trigger: "blur" }
          ],
          name: [
            { required: true, message: "请输入姓名", trigger: "blur" },
            { min: 3, max: 5, message: "长度在 3 到 5 个字符", trigger: "blur" }
          ],
          anamnesis: [
            { required: true, message: "请输入病历号", trigger: "blur" },
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
//导入全局的颜色
@import "~@css/var";
</style>