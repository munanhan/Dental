<template>
  <div>
    <el-dialog
        title="添加角色"
        :visible.sync="show"
        width="350px"
        :before-close="closeDialog"
        :close-on-click-modal="false"
        v-dialog-drag
        >
        <el-form ref="form" :model="form" :rules="rules" label-width="80px">
          <el-form-item label="角色名" prop="name">
            <el-input v-model="form.name"></el-input>
          </el-form-item>
          <el-form-item>
            <el-button type="primary" @click="submitForm('form')">添加</el-button>
            <el-button @click="closethisDialog">关闭</el-button>
          </el-form-item>

        </el-form>
    </el-dialog>

  </div>
</template> 
<script>
import AddDialogForm from "@views/base/AddDialogForm";
export default {
    name: 'AddRole',
    mixins: [AddDialogForm],
    components: {},
      props: {
        
      },
      data() {

        return {
          form:{
            name:''
          },
          rules:{
              name: [
                  {
                      required: true,
                      message:'请输入角色名称.',
                      trigger: "blur"
                  }
              ],

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
        
        submitForm(formName) {
          let that = this;
          that.$refs[formName].validate((valid) => {
            if (valid) {
              that.$api.role.add(that.form)
                .then(res => {
                  if(res.code == 200){
                    that.$message({
                        message: res.msg,
                        type: "success",
                        duration: 800
                    });
                    that.closethisDialog();
                    that.$emit(
                      "flush",res.data
                    );

                   }
                   else{
                       that.$message.error(
                            res.msg || "add error."
                        );
                   }
                })
                .catch(res => {
                  that.$message.error(
                            res.msg || "add error."
                        );
                   // console.log(res);
                });
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