<template>
	<div>
    <el-dialog
        title="会员等级设置"
        :visible.sync="show"
        width="430px"
        :close-on-click-modal="false"
        :before-close="closeDialog"
        v-dialog-drag
        >
      <el-row :gutter="10">
        <el-col :span="20">
        <el-form ref="form" :model="form" :rules="rules" label-width="80px">
          <el-form-item label="会员等级" prop="mem_level_id">
            <el-select
              clearable
              filterable
              placeholder="请选择会员等级"
              size=""
              v-model="form.mem_level_id"
              class="width100"
              
          >
              <el-option
                  v-for="item in member"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value"
              ></el-option>
          </el-select>
          </el-form-item>
          <el-form-item label="会员卡号" prop="mem_card">
            <el-input v-model="form.mem_card"></el-input>
          </el-form-item>
          <el-form-item>
            <el-button type="primary" @click="submitForm('form')">确定</el-button>
            <el-button @click="closethisDialog">关闭</el-button>
          </el-form-item>
        </el-form>
       </el-col>
       <el-col :span="2">
          <i
            class="fa fa-cog"
            style="margin-top:10px;
                 font-size:20px;
                 cursor:pointer;
                 margin-left:10px"
                 @click="showSetLevelDialog"
          ></i>
          <!-- <el-button class="setting_btn fa fa-cog" @click="showSetLevelDialog"></el-button> -->
       </el-col>
      </el-row>
    </el-dialog>
  <!-- 设置会员等级窗口 -->
  <set-member-level-dialog
    :show.sync="setMemberLevelDialog"
  >
  </set-member-level-dialog>
	</div>
</template>	
<script>
import EditDialogForm from "@views/base/EditDialogForm";
import SetMemberLevelDialog from "./SetMemberLevelDialog";

export default {
    name: 'SetMemberDialog',
    mixins: [EditDialogForm],
    components: {
      SetMemberLevelDialog
    },
      props: {
        // refresh: {
        //   type: Boolean,
        //   required: true
        // }
      },
      data() {

        return {
          setMemberLevelDialog:false,
          form:{
            mem_level_id:'',
            mem_card:''
          },
          member:[
             {
              label:'无',
              value:0
             },
             {
              label:'铜卡会员',
              value:1
             },
             {
              label:'银卡会员',
              value:2
             },
             {
              label:'金卡会员',
              value:3
             }
          ],

          rules:{
            mem_level_id: [{
                    required: true,
                    message:'请选择会员等级.',
                    trigger: "blur"
                }],
              mem_card: 
                  [{
                      required: true,
                      message:'请输入会员卡号.',
                      trigger: "blur"
                  }],

          },
          //         //要检查的字段
          // checkField: {
          //     name: "请输入姓名.",
          //     phone: "请填写移动电话.",
          //     password:'请输入密码',
          //     role:'请选择职位'
          // },
          commitLoading: false
          // tableData:[]
        };
      },
      created() {
        
      },
      mounted() {},
      watch: {
        // refresh(newValue, oldValue) {
        //   let that = this;

        //   if (newValue) {
        //     that.getPatientInfo();
        //   }
        // }
        
      },
      computed: {},
      methods: {
        // setHasErrorMessage() {
        //     let that = this;
        //     that.hasShowErrorMessage = true;

        //     setTimeout(() => {
        //         that.hasShowErrorMessage = false;
        //     }, 3e3);
        // },
        showSetLevelDialog(){
            this.setMemberLevelDialog = true;
        },
        submitForm(formName) {
          console.log(this.editItem);
          console.log(this.form);
          this.$refs[formName].validate((valid) => {
            if (valid) {
              console.log('submit!');
            } else {
              console.log('error submit!!');
              return false;
            }
          });
        },
        closethisDialog(){
           let that = this;
           that.$refs["form"].resetFields();
           that.closeDialog();
        }
      }
}
</script>
<style lang="less" scoped>

</style>