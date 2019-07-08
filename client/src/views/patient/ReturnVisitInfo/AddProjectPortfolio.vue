<template>
    <el-dialog
        title="新增计划组合"
        :visible.sync="show"
        :before-close="closeDialog"
        class="custom-dialog"
        :close-on-click-modal="false"
        :append-to-body="true"
        v-dialog-drag
    >
            <!-- :model="changePwd" -->
        <el-form
            ref="changePwdForm"
            label-width="100px"
            :rules="rules"
        >
            <el-form-item
                label="组合名称"
                prop="newPassRe"
            >
                <el-input
                v-moder="cooo"
                    type="password"
                    autocomplete="off"
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

import DialogForm from "@/views/base/DialogForm";
export default {
    name: "AddProjectPortfolio",

    mixins: [DialogForm],

    data() {
        return {
            rules: {},

            commitLoading: false
        };
    },

    methods: {
        afterClose() {
            this.$refs["changePwdForm"].resetFields();
        }
    }
};
</script>
<style lang="less" scoped>
</style>