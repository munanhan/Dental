<template>
    <el-dialog
        title="新增医嘱性质"
        :visible.sync="show"
        :before-close="closeDialog"
        class="custom-dialog add-advice"
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
                label="医嘱性质"
                prop="advice_name"
            >
                <el-input
                    v-model.trim="form.advice_name"
                    autocomplete="off"
                ></el-input>
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
    name: "AddAdvice",
    mixins: [AddDialogForm],

    components: {},
    props: {},
    data() {
        return {
            form: {
                advice_name: "",
            },
            formRules: {
                advice_name: [
                    {
                        required: true,
                        message: "请输入治疗性质",
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
.add-advice {
    /deep/ .el-dialog__body {
        padding-bottom: 0;
    }
}
</style>