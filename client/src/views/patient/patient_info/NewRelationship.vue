<template>
    <el-dialog
        title="新增亲友关系"
        :visible.sync="show"
        :before-close="closeDialog"
        class="custom-dialog"
        :close-on-click-modal="false"
        v-dialog-drag
        :append-to-body="true"
    >
        <el-form
            ref="form"
            label-width="100px"
            :rules="form.rules"
        >
            <el-form-item
                label="关系人查询"
                prop="oldPass"
            >
                <el-input></el-input>
            </el-form-item>
            <el-form-item
                label="关系人"
                prop="newPass"
            >
                <el-input></el-input>
            </el-form-item>
            <el-form-item
                label="关系类别"
                prop="newPassRe"
            >
                <el-input></el-input>
            </el-form-item>
            <el-form-item
                label="备注"
                prop="newPassRe"
            >
                <el-input></el-input>
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
    name: "NewRelationship",

    mixins: [DialogForm],

    data() {
        return {
            form: {
                rules: {}
            }
        };
    },

    methods: {}
};
</script>
<style lang="less" scoped>
</style>