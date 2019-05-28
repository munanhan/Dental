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
          <el-form-item label="会员等级" prop="member_id">
            <el-select
              clearable
              filterable
              placeholder="请选择会员等级"
              size=""
              v-model="form.member_id"
              class="width100"
              
          >
              <el-option
                  v-for="item in member"
                  :key="item.id"
                  :label="item.name"
                  :value="item.id"
              ></el-option>
          </el-select>
          </el-form-item>
          <el-form-item label="会员卡号" prop="phone">
            <el-input v-model="form.phone" disabled></el-input>
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
            member_id:'',
            phone:''
          },
          member:[],

          rules:{
            member_id: [{
                    required: true,
                    message:'请选择会员等级.',
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
      mounted() {
        //let that = this;
        //that.getMember();
      },
      watch: {
        refresh(newValue, oldValue) {
            let that = this;
            if (newValue) {
                // that.resizeTable();

                //更新原来的refresh, 防止下次点击时不通知更新
                // that.$emit("update:refresh", false);
                that.getMember();
                // that.getData();
            }
        }
        
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
          let that = this;
          that.$refs[formName].validate((valid) => {
            if (valid) {
              // console.log(this.form);
              that.$api.member.update(that.form)
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
        },
        /**获取数据**/
        getMember(){
          //获取会员信息
            let that = this;
            that.$api.patient_member.get()
            .then(res => {
               that.member = res.data;
            })
            .catch(res => {

            });
        }
      }
}
</script>
<style lang="less" scoped>

</style>