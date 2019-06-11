<template>
  <div>
    <el-dialog
        title="修改角色名"
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
            <el-button type="primary" @click="submitForm('form')">修改</el-button>
            <el-button @click="closethisDialog">关闭</el-button>
          </el-form-item>

        </el-form>
    </el-dialog>

  </div>
</template> 
<script>
import EditDialogForm from "@views/base/EditDialogForm";
export default {
    name: 'EditRole',
    mixins: [EditDialogForm],
    components: {},
      props: {
        // p_id:undefined
        // refresh: {
        //   type: Boolean,
        //   required: true
        // }
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
              // console.log(this.form);
              that.$api.role.update(that.form)
                  .then(res => {
                    if(res.code == 200){
                      that.$message({
                          message: res.msg,
                          type: "success",
                          duration: 800
                      });
                      // console.log(res.data);
                      that.closethisDialog();
                      that.$emit("flush",res.data);
                     }
                     else{
                         that.$message.error(
                              res.msg || "edit error."
                          );
                     }
                  })
                  .catch(res => {
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