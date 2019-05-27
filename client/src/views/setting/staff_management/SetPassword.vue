<template>
	<div>
		    <!--修改密码-->
	    <el-dialog
	      title="设置密码"
	      :visible.sync="show"
	      width="400px"
	      :before-close="closeDialog"
	      v-dialog-drag
	      >
	      <!-- <div class="title"><span>设置用户{{show_name}}的密码</span></div> -->
	      <el-form :model="ruleForm" status-icon :rules="rules" ref="ruleForm" label-width="100px" class="demo-ruleForm">
	        <el-form-item label="密码" prop="password">
	          <el-input type="password" v-model="ruleForm.password" autocomplete="off"></el-input>
	        </el-form-item>
	        <el-form-item label="确认密码" prop="re_password">
	          <el-input type="password" v-model="ruleForm.re_password" autocomplete="off"></el-input>
	        </el-form-item>
	        <el-form-item>
	          <el-button type="primary" @click="submitForm('ruleForm')">提交</el-button>
	          <el-button @click="closePassDialog">关闭</el-button>
	        </el-form-item>
	      </el-form>
	    </el-dialog>

	</div>
</template>	
<script>
let passRules = [
    {
        required: true,
        message: "请填写所需要的密码",
        trigger: "blur"
    },
    {
        min: 6,
        // max: 16,
        message: "长度在最小在6个字符",
        trigger: "blur"
    }
];
import DialogForm from "@views/base/DialogForm";
export default {
    name: 'setPassword',
    mixins: [DialogForm],
    components: {},
      props: {
        
        // refresh: {
        //   type: Boolean,
        //   required: true
        // }
      },
      data() {

        return {
          
          ruleForm: {
            password: '',
            re_password: ''
          },

          rules:{
          	new_password:passRules,
          	re_password:passRules,
          	re_password:passRules.concat({
                    validator: (rule, value, callback) => {
                        let that = this;

                        if (that.ruleForm.password !== value) {
                            callback(
                                new Error("两次的密码不一致，请重新输入.")
                            );
                        } else {
                            callback();
                        }
                    }
                })
          },
          commitLoading: false,

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
        setHasErrorMessage() {
            let that = this;
            that.hasShowErrorMessage = true;

            setTimeout(() => {
                that.hasShowErrorMessage = false;
            }, 3e3);
        },
        
        submitForm(formName) {
          let that = this;
          that.ruleForm.id = that.id;
          this.$refs[formName].validate((valid) => {
            if (valid) {
              that.$api.staff.changePassword(that.ruleForm)
                .then(res => {
                  if(res.code == 200){
                    this.$message({
                        message: res.msg,
                        type: "success",
                        duration: 800
                    });
                    that.closePassDialog();
                    // that.$emit(
                    //   "flush"
                    // );

                   }
                   else{
                       that.$message.error(
                            res.msg || "修改失败."
                        );
                   }
                })
              // console.log(that.ruleForm);
              // alert('submit!');
            } else {
              console.log('error submit!!');
              return false;
            }
          });
        },
        closePassDialog(){
           let that = this;
           that.$refs["ruleForm"].resetFields();
           that.closeDialog();
        }
      }
}
</script>