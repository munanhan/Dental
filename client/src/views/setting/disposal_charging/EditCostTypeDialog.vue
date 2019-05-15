<template>
	<div>
    <el-dialog
        title="修改费用类型"
        :visible.sync="show"
        width="350px"
        :before-close="closeDialog"
        :close-on-click-modal="false"
        v-dialog-drag
        append-to-body
        >
        <el-form ref="form" :model="form" :rules="rules" label-width="80px">
          <el-form-item label="费用类型" prop="category">
            <el-input v-model="form.category"></el-input>
          </el-form-item>
          <el-form-item>
            <el-button type="primary" @click="submitForm('form')" style="background-color:#2f6386;border:1px solid #2f6386;">修改</el-button>
            <el-button @click="closethisDialog">关闭</el-button>
          </el-form-item>

        </el-form>
    </el-dialog>

	</div>
</template>	
<script>
import EditDialogForm from "@views/base/EditDialogForm";
    export default {
        name: 'EditCostType',
        mixins: [EditDialogForm],
        components: {},
          props: {
            // refresh: {
            //   type: Boolean,
            //   required: true
            // }
          },
          data() {

            return {
              form:{
                category:''
              },
              rules:{
                  category: [
                      {
                          required: true,
                          message:'请输入费用类型.',
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
                  that.$api.cost_category.update(that.form)
                    .then(res => {
                      if(res.code == 200){
                        that.$message({
                            message: res.msg,
                            type: "success",
                            duration: 800
                        });
                        that.closethisDialog();
                        that.$emit("flushData",res.data);
                       }
                       else{
                           that.$message.error(
                                res.msg || "update error."
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