<template>
  <el-dialog
    title="自动导入图片"
    :visible.sync="show"
    :before-close="closeDialog"
    class="custom-dialog"
    :close-on-click-modal="false"
    v-dialog-drag
    top="4vh"
    width="750px"
  >
    <el-form
      :model="changePwd"
      ref="AutoImportForm"
      label-width="100px"
    >
      <el-form-item
        label="导入目录"
        prop="oldPass"
      >
        <el-button>配置</el-button>
      </el-form-item>
      <el-form-item
        label="导入历史"
        prop="oldPass"
      >

        <el-button>刷新</el-button>
      </el-form-item>
      <div style="height:350px;width:720px">
        <el-table
          border
          style="width: 100%"
        >
          <el-table-column
            prop="date"
            label="日期"
            width="180"
          >
          </el-table-column>
          <el-table-column
            prop="name"
            label="姓名"
            width="180"
          >
          </el-table-column>
          <el-table-column
            prop="address"
            label="地址"
          >
          </el-table-column>
        </el-table>
      </div>
    </el-form>
    <div
      slot="footer"
      class="dialog-footer"
    >
      <el-button @click="closeDialog">取 消</el-button>
      <el-button
        :loading="commitLoading"
        type="primary"
        @click="changePassword"
      >确 定</el-button>
    </div>
  </el-dialog>
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

import DialogForm from "../base/DialogForm";
export default {
  name: "AutomaticImport",

  mixins: [DialogForm],

  data() {
    return {
      changePwd: {
        oldPass: "",
        newPass: "",
        newPassRe: ""
      },

      rules: {
        oldPass: passRules,
        newPass: passRules,
        newPassRe: passRules.concat({
          validator: (rule, value, callback) => {
            let that = this;

            if (that.changePwd.newPass !== value) {
              callback(new Error("两次的密码不一致，请重新输入."));
            } else {
              callback();
            }
          }
        })
      },

      commitLoading: false
    };
  },

  methods: {
    changePassword() {
      let that = this;

      that.$refs["changePwdForm"].validate(valid => {
        if (valid) {
          that.commitLoading = true;

          that.$api.user
            .changePassword(that.changePwd)
            .then(res => {
              if (res.code == 0) {
                that.$message({
                  message: "修改成功.",
                  type: "success",
                  duration: 800
                });

                that.closeDialog();
              } else {
                that.$message.error(res.message);
              }

              that.commitLoading = false;
            })
            .catch(res => {
              that.$message.error("修改失败，请重试.");
              that.commitLoading = false;
            });
        }
      });
    },

    afterClose() {
      this.$refs["changePwdForm"].resetFields();
    }
  }
};
</script>
<style lang="less" scoped>
/deep/ .el-table__empty-block{
    min-height: 300px;
}
</style>