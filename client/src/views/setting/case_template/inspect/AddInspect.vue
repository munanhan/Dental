<template>
    <el-dialog
        title="新增检查"
        :visible.sync="show"
        :before-close="closeDialog"
        class="custom-dialog add-inspect"
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
                label="检查名称"
                prop="inspect_content"
            >
                <el-input
                    v-model.trim="form.inspect_content"
                    autocomplete="off"
                ></el-input>
            </el-form-item>

            <el-form-item
                label="类型"
                prop="type"
            >
                <el-radio-group v-model="form.type">
                    <el-radio :label="0">部位</el-radio>
                    <el-radio :label="1">症状</el-radio>
                    <el-radio :label="2">诊法</el-radio>
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
    name: "AddInspect",
    mixins: [AddDialogForm],

    components: {},
    props: {
        menu_id:{

        }
    },
    data() {
        return {
            apiType:'inspect',

            form: {
                inspect_content: "",
                menu_id:0,
                type: 0
            },
            formRules: {
                inspect_content: [
                    {
                        required: true,
                        message: "请输入检查名称",
                        trigger: "blur"
                    }
                ]
            }
        };
    },
    created() {},
    mounted() {},
    watch: {
        show(newValue,oldValue){
            let that = this;
            if (newValue) {

                that.form.menu_id = that.menu_id;

            }
        }
    },
    computed: {},
    methods: {}
};
</script>
<style lang="less" scoped>
.add-inspect {
    /deep/ .el-dialog__body {
        padding-bottom: 0;
    }
}
</style>