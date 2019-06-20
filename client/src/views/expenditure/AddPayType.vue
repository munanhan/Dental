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
                    v-model.trim="form.expenditure_method"
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
                expenditure_method: ""
            },
            formRules: {
                expenditure: [
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
            that.$api.expenditure_method.add(that.form)
                .then(res => {
                  if(res.code == 200){

                        that.$message({
                            message: res.msg,
                            type: "success",
                            duration: 800
                        });

                        that.$emit("add-item", res.data);

                        that.closeDialog();

                   }
                   else{
                       that.$message.error(
                            res.msg || "edit error."
                        );
                   }
                })
                .catch(res => {
                   // console.log(res);
                });
        }
    }
};
</script>
<style lang="less" scoped>
</style>