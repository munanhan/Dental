<template>
    <div>
        <el-dialog
            title="新增费用支出"
            :visible.sync="show"
            :before-close="closeDialog"
            class="custom-dialog recovery-dialog"
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
                    label="备注"
                    prop="remark"
                >
                    <el-input
                        v-model="form.remark"
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

    </div>
</template>

<script>
import AddDialogForm from "../base/AddDialogForm";
export default {
    name: 'AddRecovery',
    components:{},
    props:{},
    data(){
      return {
      }
    },
    created(){},
    mounted(){},
    watch:{},
    computed:{},
    methods:{},
}
</script>
<style lang="less" scoped>
//导入全局的颜色
@import "~@css/var";

.recovery-dialog {
    .sub-form-item {
        display: flex;

        .form-setting {
            text-align: right;
            width: 30px;
            font-size: 22px;
            margin-top: 10px;
            cursor: pointer;

            &:hover {
                color: @color;
            }
        }
    }
}
</style>