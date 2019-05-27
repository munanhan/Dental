<template>
    <el-dialog
        title="新增病史"
        :visible.sync="show"
        :before-close="closeDialog"
        class="custom-dialog add-medical"
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
                label="病史名称"
                prop="medical_name"
            >
                <el-input
                    v-model.trim="form.medical_name"
                    autocomplete="off"
                ></el-input>
            </el-form-item>

            <el-form-item
                label="类型"
                prop="type"
            >
                <el-radio-group v-model="form.type">
                    <el-radio :label="0">部位</el-radio>
                    <el-radio :label="1">性质</el-radio>
                    <el-radio :label="2">时间</el-radio>
                    <el-radio :label="3">其他</el-radio>
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
    name: "AddMedical",
    mixins: [AddDialogForm],

    components: {},
    props: {},
    data() {
        return {

            form: {
                medical_name: "",
                type: 0
            },
            formRules: {
                medical_name: [
                    {
                        required: true,
                        message: "请输入病史名称",
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
.add-medical {
    /deep/ .el-dialog__body {
        padding-bottom: 0;
    }
}
</style>