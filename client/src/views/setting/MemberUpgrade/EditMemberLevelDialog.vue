<template>
	<div>
    <el-dialog
        title="修改会员参数"
        :visible.sync="show"
        width="400px"
        :close-on-click-modal="false"
        :before-close="closeDialog"
        v-dialog-drag
        >
        <el-form ref="form" :model="form" :rules="rules" label-width="120px">
          <el-form-item label="会员等级" prop="mem_level">
            <el-input v-model="form.mem_level"></el-input>
          </el-form-item>
          <el-form-item label="会员折扣(%)" prop="discount">
            <el-input-number v-model="form.discount" :precision="2" :step="0.1" :min="0" :max="100" controls-position="right"  class="input_size"></el-input-number>
          </el-form-item>
          <el-form-item>
            <el-button type="primary" @click="submitForm('form')">确定</el-button>
            <el-button @click="closethisDialog">关闭</el-button>
          </el-form-item>
        </el-form>
    </el-dialog>

	</div>
</template>	
<script>
import EditDialogForm from "@views/base/EditDialogForm";

export default {
    name: 'EditMemberLevel',
    mixins: [EditDialogForm],
    components: {
      
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
            mem_level:'',
            discount:''
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
            mem_level: [
                    {
                        required: true,
                        message:'请输入会员等级.',
                        trigger: "blur"
                    }
                ],
            discount: [
                {
                    required: true,
                    message:'请输入折扣.',
                    trigger: "blur"
                }
            ]

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
.setting_btn{
   border: 0px;
}
.input_size{
   width: 100%;
}
</style>