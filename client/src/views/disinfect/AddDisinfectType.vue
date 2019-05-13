<template>
    <el-dialog
        title="新增消毒方式"
        :visible.sync="show"
        :before-close="closeDialog"
        class="custom-dialog"
        :close-on-click-modal="false"
        v-dialog-drag
    >
        <el-form
            :model="form"
            :rules="formRules"
            label-width="80px"
            ref="form"
        >
            <el-form-item
                label="消毒方式"
                prop="disinfect_type"
            >
                <el-input
                    v-model.trim="form.disinfect_type"
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
        </div>
    </el-dialog>
</template>

<script>
import DialogForm from "../base/DialogForm";

export default {
    name: "AddDisinfectType",
    mixins: [DialogForm],
    components: {},
    props: {},
    data() {
        return {
            commitLoading: false,

            form: {
                disinfect_type: ""
            },
            formRules: {
                disinfect_type: [
                    {
                        required: true,
                        message: "请输入消毒类型",
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

            that.$emit('add-item', that.form.type);

            that.closeDialog();
        }
    }
};
</script>
<style lang="less" scoped>
</style>