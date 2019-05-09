<template>
    <el-dialog
        title="付款方式选择"
        :visible.sync="show"
        :before-close="closeDialog"
        class="custom-dialog pay-dialog"
        :close-on-click-modal="false"
        v-dialog-drag
    >

    </el-dialog>
</template>

<script>
import DialogForm from "../base/DialogForm";
export default {
    name: "PayType",
    mixins: [DialogForm],

    components: {},
    props: {},
    data() {
        return {};
    },
    created() {},
    mounted() {},
    watch: {},
    computed: {},
    methods: {}
};
</script>
<style lang="less" scoped>
</style>