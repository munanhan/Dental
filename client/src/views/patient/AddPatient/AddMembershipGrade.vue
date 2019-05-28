<template>
    <el-dialog
        title="会员等级设置"
        :visible.sync="show"
        :before-close="closeDialog"
        class="custom-dialog"
        :close-on-click-modal="false"
        :append-to-body="true"
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
                prop="name"
            >
                <el-input
                    v-model.trim="form.name"
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
import DialogForm from "@/views/base/DialogForm";
export default {
    name: "AddMembershipGrade",
    mixins: [DialogForm],
    components: {},
    props: {},
    data() {
        return {
            commitLoading: false,

            form: {
                name: ""
            },
            formRules: {
                name: [
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
            that.$api.patient_member
                .add(that.form)
                .then(res => {
                    that.$emit("flush", res.data);
                    that.closeDialog();
                })
                .catch(res => {
                    console.log(res);
                });
        }
    }
};
</script>
<style lang="less" scoped>
</style>