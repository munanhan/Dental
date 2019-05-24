<template>
    <el-dialog
        title="新增节点"
        :visible.sync="show"
        :before-close="closeDialog"
        class="custom-dialog add-tree-node"
        :close-on-click-modal="false"
        v-dialog-drag
    >
        <el-form
            :model="form"
            :rules="formRules"
            label-width="100px"
            ref="form"
        >

            <el-form-item
                label="节点名称"
                prop="nodeName"
            >
                <el-input
                    v-model.trim="form.nodeName"
                    autocomplete="off"
                ></el-input>
            </el-form-item>

            <el-form-item
                label="类型"
                prop="type"
            >
                <el-radio-group v-model="form.type">
                    <el-radio :label="0">目录</el-radio>
                    <el-radio :label="1">案例</el-radio>
                </el-radio-group>
            </el-form-item>
        </el-form>

        <div
            slot="footer"
            class="dialog-footer"
        >
            <el-button
                @click="closeDialog"
                :disabled="commitLoading"
            >取 消</el-button>
            <el-button
                type="primary"
                @click="addCommit"
                :loading="commitLoading"
            >确 定</el-button>
            <!-- :disabled="!$check_pm('resume_add') || analyzeLoading" -->
        </div>
    </el-dialog>
</template>

<script>
import AddDialogForm from "../../base/AddDialogForm";

export default {
    name: "AddTreeNode",
    mixins: [AddDialogForm],

    components: {},
    props: {},
    data() {
        return {
            commitLoading: false,

            form: {
                nodeName: "",
                type: 0
            },
            formRules: {
                nodeName: [
                    {
                        required: true,
                        message: "请输入节点名称",
                        trigger: "blur"
                    }
                ]
            }
        };
    },
    created() {},
    mounted() {},
    watch: {},
    computed: {},
    methods: {
        addCommit(){
            let that = this;

            that.$emit('add-node', that.form);
        }

    }
};
</script>
<style lang="less" scoped>
.add-tree-node{
    /deep/ .el-dialog__body{
        padding-bottom: 0;
    }
}

</style>