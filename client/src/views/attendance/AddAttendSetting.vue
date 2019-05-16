<template>
    <el-dialog
        title="新增考勤类型"
        :visible.sync="show"
        :before-close="closeDialog"
        class="custom-dialog add-attend-dialog"
        :close-on-click-modal="false"
        v-dialog-drag
    >
        <el-form
            :model="form"
            :rules="formRules"
            label-width="60px"
            ref="form"
        >
            <el-form-item
                label="类型"
                prop="attend_type"
            >
                <el-input
                    v-model.trim="form.attend_type"
                    autocomplete="off"
                ></el-input>
            </el-form-item>
            <el-form-item
                label="颜色"
                prop="attend_color"
            >
                <el-color-picker v-model="form.attend_color"></el-color-picker>
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
        </div>
    </el-dialog>
</template>

<script>
import DialogForm from "../base/DialogForm";
export default {
    name: "AddAttendSetting",
    mixins: [DialogForm],
    components: {},
    props: {},
    data() {
        return {
            commitLoading: false,

            form: {
                attend_type: "",
                attend_color: "red"
            },
            formRules: {
                attend_type: [
                    {
                        required: true,
                        message: "请输入类型",
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
        addCommit() {
            let that = this;

            that.$emit("add-item", that.form.expenditure);

            that.closeDialog();
        }
    }
};
</script>
<style lang="less" scoped>
.add-attend-dialog {
    /deep/ .el-color-picker {
        width: 100%;

        .el-color-picker__trigger {
            width: 100%;
        }
    }
}
</style>