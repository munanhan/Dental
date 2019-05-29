<template>
    <el-dialog
        title="新增消毒"
        :visible.sync="show"
        :before-close="closeDialog"
        class="custom-dialog add-disinfect-dialog"
        :close-on-click-modal="false"
        v-dialog-drag
    >
		1312312

    </el-dialog>
</template>

<script>
import DialogForm from "../base/DialogForm";
export default {
	name: "Inquiry",
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