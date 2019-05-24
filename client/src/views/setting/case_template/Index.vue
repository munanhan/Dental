<template>
    <div class="case-template">
        <div class="left-container">
            <div>
                <span>大纲目录</span>
                <i
                    class="el-icon-share"
                    title="新增节点"
                ></i>
                <i
                    class="el-icon-edit"
                    title="修改"
                ></i>

                <i
                    class="el-icon-delete"
                    title="删除节点"
                ></i>
            </div>
            <div>
				树
			</div>
        </div>
        <div class="right-container">
            <div></div>
            <div>
                块
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "CaseTemplate",
    components: {},
    props: {
        refresh: {
            type: Boolean,
            required: true
        }
    },
    data() {
        return {};
    },
    created() {},
    mounted() {},
    watch: {
        refresh(newValue, oldValue) {
            let that = this;

            if (newValue) {
            }
        }
    },
    computed: {},
    methods: {}
};
</script>
<style lang="less" scoped>
.case-template {
    display: flex;
    height: 100%;

    .left-container {
        width: 250px;
        border-right: 1px solid #e3e3e3;
    }

    .right-container {
        flex: 1;
        padding: 10px;
    }
}
</style>