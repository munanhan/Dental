<script>
export default {
    name: "Base",

    props: {
        refresh: {
            type: Boolean,
            required: true
        }
    },

    data() {
        return {
            api: "",
            apiMethods: "",
            params: {},
        };
    },

    watch: {
        refresh(newValue, oldValue) {
            let that = this;

            if (newValue) {
                that.getData();
            }
        }
    },

    methods: {
        beforeGetData(params) {},
        afterGetData(res) {},

        getData() {
            let that = this;

            if (that.api) {
                that.$api[that.api]
                    [that.apiMethods](params)
                    .then(res => {
                        if (res.code == 0) {
                            that.afterGetData(res);
                        } else {
                            that.$message.error(
                                res.msg || "获取数据失败，请重试."
                            );
                        }
                    })
                    .catch(e => {
                        that.$message.error("获取数据失败，请重试.");
                    });
            }
        }
    }
};
</script>
