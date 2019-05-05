<template>
  <div>
    <el-dialog
        title="修改数量"
        :visible.sync="show"
        width="350px"
        :before-close="closeDialog"
        :close-on-click-modal="false"
        v-dialog-drag
        >
        <el-form ref="form" :model="form" :rules="rules" label-width="80px">
          <el-form-item label="数量" prop="qty">
            <el-input v-model="form.qty"></el-input>
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
    name: 'EditQty',
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
            qty:''
          },
          rules:{
              combo_name: [
                  {
                      required: true,
                      message:'请输数量.',
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
          this.$refs[formName].validate((valid) => {
            if (valid) {
              console.log(this.form);
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