<template>
    <el-dialog
        title="新增诊断"
        :visible.sync="show"
        :before-close="closeDialog"
        class="custom-dialog add-diagnose"
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
                label="诊断名称"
                prop="diagnose_name"
            >
                <el-input
                    v-model.trim="form.diagnose_name"
                    autocomplete="off"
                ></el-input>
            </el-form-item>

            <el-form-item
                label="类型"
                prop="type"
            >
                <el-radio-group v-model="form.type">
                    <el-radio :label="0">诊断</el-radio>
                    <el-radio :label="1">性质</el-radio>
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
import AddDialogForm from "../../../base/AddDialogForm";

export default {
    name: "AddDiagnose",
    mixins: [AddDialogForm],

    components: {},
    props: {},
    data() {
        return {

            form: {
                diagnose_name: "",
                type: 0
            },
            formRules: {
                diagnose_name: [
                    {
                        required: true,
                        message: "请输入诊断名称",
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
    methods: {}
};
</script>
<style lang="less" scoped>
.add-diagnose {
    /deep/ .el-dialog__body {
        padding-bottom: 0;
    }
}
</style>