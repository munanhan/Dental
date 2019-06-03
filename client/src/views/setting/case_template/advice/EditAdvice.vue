<template>
    <el-dialog
        :title="title"
        :visible.sync="show"
        :before-close="closeDialog"
        class="custom-dialog edit-advice"
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
                :label="type"
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
                @click="editCommit"
                :loading="commitLoading"
            >确 定</el-button>
        </div>

    </el-dialog>
</template>

<script>
import EditDialogForm from "../../../base/EditDialogForm";

export default {
    name: "EditAdvice",
    mixins: [EditDialogForm],

    components: {},
    props: {
        type: {
            default: ''            
        }

    },
    data() {
        return {
            apiType:'advice',
            form: {
                advice_name: "",
            },
            formRules: {
                advice_name: [
                    {
                        required: true,
                        message: "请输入" + this.type,
                        trigger: "blur"
                    }
                ]
            }
        };
    },
    created() {},
    mounted() {},
    watch: {},
    computed: {
        title(){
            return '修改' + this.type
        }

    },
    methods: {}
};
</script>
<style lang="less" scoped>
.edit-advice {
    /deep/ .el-dialog__body {
        padding-bottom: 0;
    }
}
</style>