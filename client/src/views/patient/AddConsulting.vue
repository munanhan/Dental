<template>
  <el-dialog
    title="修改密码"
    :visible.sync="show"
    :before-close="closeDialog"
    class="custom-dialog"
    :close-on-click-modal="false"
    v-dialog-drag
  >
    <el-form
      :model="changePwd"
      ref="changePwdForm"
      label-width="100px"
      :rules="rules"
    >
      <el-alert
        title="王生 8岁  *(无病历号)"
        type="success"
        :closable="false"
      >
      </el-alert>
      <el-form-item
        label="新密码"
        prop="newPass"
      >
        <el-input
          v-model="changePwd.newPass"
          type="password"
          autocomplete="off"
          placeholder="请输入新密码"
        ></el-input>
      </el-form-item>
      <el-form-item
        label="确认密码"
        prop="newPassRe"
      >
        <el-input
          v-model="changePwd.newPassRe"
          type="password"
          autocomplete="off"
          placeholder="请再次输入新密码"
        ></el-input>
      </el-form-item>
    </el-form>
    <div
      slot="footer"
      class="dialog-footer"
    >
      <el-button @click="closeDialog">取 消</el-button>
      <el-button
        :loading="commitLoading"
        type="primary"
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
  name: "AddConsulting",

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
    
  }
};
</script>
<style lang="less" scoped>
</style>