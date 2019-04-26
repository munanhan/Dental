<template>
  <div>
    <el-dialog
        title="修改处置收费项"
        :visible.sync="show"
        width="400px"
        :before-close="closeDialog"
        :close-on-click-modal="false"
        v-dialog-drag
        >
        <el-form ref="form" :model="form" :rules="rules" label-width="100px">
          <el-form-item label="处置代码" prop="disposal_code">
            <el-input v-model="form.disposal_code"></el-input>
          </el-form-item>
          <el-form-item label="处置名称" prop="disposal_name">
            <el-input v-model="form.disposal_name"></el-input>
          </el-form-item>
          <el-form-item label="价格" prop="price">
            <el-input-number v-model="form.price" placeholder="价格" :precision="2" :step="0.01" :min="0" controls-position="right" style="width: 100%"></el-input-number>
          </el-form-item>
          <el-form-item label="单位" prop="unit">
            <el-input v-model="form.unit"></el-input>
          </el-form-item>
          <el-form-item label="按会员折扣" prop="mem_discount">
            <el-radio-group v-model="form.mem_discount">
              <el-radio :label="1">是</el-radio>
              <el-radio :label="0">否</el-radio>
            </el-radio-group>
          </el-form-item>
          <el-form-item label="费用类型" prop="cost_type">
            <el-select
              clearable
              filterable
              placeholder="请选择费用类型"
              size=""
              v-model="form.cost_type"
              class="width100"
              
          >
              <el-option
                  v-for="item in cost_type"
                  :key="item.id"
                  :label="item.cost_type"
                  :value="item.id"
              ></el-option>
          </el-select>
          </el-form-item>
          <el-form-item label="计费方式" prop="billing_mode">
            <el-select
              clearable
              filterable
              placeholder="请选择计费方式"
              size=""
              v-model="form.billing_mode"
              class="width100"
              
          >
              <el-option
                  v-for="item in billing_mode"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value"
              ></el-option>
          </el-select>
          </el-form-item>
          <el-form-item label="备注" prop="remarks">
            <el-input v-model="form.remarks"></el-input>
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
    name: 'EditDisposalCharging',
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
          billing_mode:[
          {
            label:'按牙齿收费',
            value:1
          },
          {
            label:'按其他收费',
            value:2
          }
          ],
          cost_type:[
          {
                id: 1,
                cost_type: '西药费'
                },
                {
                id: 2,
                cost_type: '放射费'
                },
                {
                id: 3,
                cost_type: '检查费'
                },
                {
                id: 4,
                cost_type: '诊疗费'
                },
                {
                id: 5,
                cost_type: '补牙费'
                },
                {
                id: 6,
                cost_type: '手术费'
                },
                {
                id: 7,
                cost_type: '正畸费'
                },
                {
                id: 8,
                cost_type: '拔牙费'
                },
                {
                id: 9,
                cost_type: '修复费'
                },
                {
                id: 10,
                cost_type: '其他'
                },
          ],
          form:{
              disposal_code:'',
              disposal_name:'',
              price:undefined,
              unit:'',
              mem_discount:undefined,
              cost_type:'',
              billing_mode:'',
              remarks:'',
          },
          rules:{
              cost_type: [
                  {
                      required: true,
                      message:'请输入费用类型.',
                      trigger: "blur"
                  }
              ],
              disposal_code: [
                  {
                      required: true,
                      message:'请输入处置代码.',
                      trigger: "blur"
                  }
              ],
              disposal_name: [
                  {
                      required: true,
                      message:'请输入处置名称.',
                      trigger: "blur"
                  }
              ],
              price: [
                  {
                      required: true,
                      message:'请输入价格.',
                      trigger: "blur"
                  }
              ],
              unit: [
                  {
                      required: true,
                      message:'请输入单位.',
                      trigger: "blur"
                  }
              ],
              mem_discount: [
                  {
                      required: true,
                      message:'请选择是否按会员折扣.',
                      trigger: "blur"
                  }
              ],
              billing_mode: [
                  {
                      required: true,
                      message:'请选择计费方式.',
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