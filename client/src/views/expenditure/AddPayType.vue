<template>
    <el-dialog
        title="新增付款方式"
        :visible.sync="show"
        :before-close="closeDialog"
        class="custom-dialog"
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
                prop="type"
            >
                <el-input
                    v-model.trim="form.type"
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
    name: "AddPayType",
    mixins: [DialogForm],
    components: {},
    props: {},
    data() {
        return {
            commitLoading: false,

            form: {
                type: ""
            },
            formRules: {
                type: [
                    {
                        required: true
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

            that.$emit('add-item', that.form.expenditure);

            that.closeDialog();
        }
    }
};
</script>
<style lang="less" scoped>
</style>