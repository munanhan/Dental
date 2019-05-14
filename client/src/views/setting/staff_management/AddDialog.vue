<template>
	<div>
    <el-dialog
        title="添加员工"
        :visible.sync="show"
        width="450px"
        :close-on-click-modal="false"
        :before-close="closeDialog"
        v-dialog-drag
        >
        <el-form ref="form" :model="form" :rules="rules" label-width="80px">
          <el-form-item label="员工姓名" prop="name">
            <el-input v-model="form.name"></el-input>
          </el-form-item>
          <el-form-item label="手机号码" prop="phone">
            <el-input v-model="form.phone"></el-input>
          </el-form-item>
          <el-form-item label="密码" prop="password">
            <el-input v-model="form.password" type="password"></el-input>
          </el-form-item>
          <el-form-item label="职位" prop="role">
                      <el-select
                          clearable
                          filterable
                          placeholder="请选择职位"
                          size="small"
                          v-model="form.role"
                          class="width100"
                          
                      >
                          <el-option
                              v-for="item in role_list"
                              :key="item.id"
                              :label="item.name"
                              :value="item.id"
                          ></el-option>
                      </el-select>
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
    name: 'addDialog',
    mixins: [AddDialogForm],
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
            name:'',
            phone:'',
            password:'',
            role:''
          },
          role_list:[
            // '主任',
            // '医生',
            // '前台',
            // '护士',
            // '收银员',
            // '技师',
            // '咨询师'
          ],

          rules:{
          	name: [
                    {
                        required: true,
                        message:'请输入姓名.',
                        trigger: "blur"
                    },
                    {
                        min:2,
                        message:'姓名长度最少2位.',
                        trigger:'blur'
                    }
                ],
            phone: [
                {
                    required: true,
                    message:'请输入电话.',
                    trigger: "blur"
                }
            ],
            password: [
                    {
                        required: true,
                        message:'请输入密码.',
                        trigger: "blur"
                    },
                    {
                        min:6,
                        message:'密码长度最少6位.',
                        trigger:'blur'
                    }
                ],
              role: [
                  {
                      required: true,
                      message:'请选择职位.',
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
        let that = this;
        that.getData();
      },
      mounted() {},
      watch: {
        
        
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
        getData(){
          let that = this;
          that.$api.user.get_role()
            .then(res => {
               that.role_list = res.data;
            })
            .catch(res => {
               console.log(res);
            });
        },
        submitForm(formName) {
          let that = this;
          that.$refs[formName].validate((valid) => {
            if (valid) {
              that.$api.user.add(that.form)
                .then(res => {
                   that.role_list = res.data;
                })
                .catch(res => {
                   console.log(res);
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