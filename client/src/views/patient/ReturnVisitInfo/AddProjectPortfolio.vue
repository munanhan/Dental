<template>
    <el-dialog
        title="新增计划组合"
        :visible.sync="show"
        :before-close="closeDialog"
        class="custom-dialog"
        :close-on-click-modal="false"
        :append-to-body="true"
        v-dialog-drag
    >
        <!-- :model="changePwd" -->
        <el-form
            ref="form"
            :model="form"
            label-width="100px"
            :rules="rules"
        >
            <el-form-item
                label="组合名称"
                prop="combination"
            >
                <el-input
                    v-model="form.combination"
                    type="text"
                    autocomplete="off"
                ></el-input>
            </el-form-item>
        </el-form>
            <!-- class="dialog-footer" -->
        <div
            slot="footer"
        >
            <el-button @click="closeDialog">取 消</el-button>
            <el-button type="primary">确 定</el-button>
            <!-- :loading="commitLoading" -->
        </div>
    </el-dialog>
</template>

<script>
import DialogForm from "@/views/base/DialogForm";
export default {
    name: "AddProjectPortfolio",

    mixins: [DialogForm],

    data() {
        return {
            form: {
                combination: ""
            },
            rules: {}

            // commitLoading: false
        };
    },

    methods: {
        afterClose() {
            this.$refs["form"].resetFields();
        }
    }
};
</script>
<style lang="less" scoped>
</style>