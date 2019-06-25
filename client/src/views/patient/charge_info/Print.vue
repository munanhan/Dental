<template>
    <el-dialog
        title="警告"
        :visible.sync="show"
        width="30%"
        class="custom-dialog"
        v-dialog-drag
        center
    >
        <i
            class="fa fa-exclamation-triangle"
            style="font-size:30px;margin-right:10px"
        ></i>
        <span style="font-size:20px;margin-right:10px">请先选择一条记录</span>
        <span
            slot="footer"
            class="dialog-footer"
        >
            <el-button @click="dialogClose">取 消</el-button>
            <el-button
                type="primary"
                @click="dialogClose"
            >确 定</el-button>
        </span>
    </el-dialog>
</template>

<script>
export default {
    props: ["show"],
    created() {},
    data() {
        return {
            dialogVisible: false
        };
    },
    methods: {
        dialogClose() {
            this.$emit("update:show", false);
        }
        // handleClose(done) {
        //   this.$confirm("确认关闭？")
        //     .then(_ => {
        //       this.dialogClose();
        //       done();
        //     })
        //     .catch(_ => {});
        // }
    }
};
</script>
