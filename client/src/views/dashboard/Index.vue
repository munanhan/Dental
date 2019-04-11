<template>
    <div class="dashboard">

    </div>
</template>

<script>
export default {
    data() {
        return {
        };
    },

    created() {
    },

    mounted() {
        let that = this;

        that.$nextTick(() => {
            that.resize();
        });

        //监听事件,由layout那边的resize抛出的
        if (window.addEventListener) {
            window.addEventListener("bodyChange", that.resize);
        } else {
            window.attachEvent("bodyChange", that.resize);
        }
    },

    destroyed() {
        let that = this;

        //销毁的时候删除事件
        if (window.removeEventListener) {
            window.removeEventListener("bodyChange", that.resize);
        } else {
            window.removeEvent("bodyChange", that.resize);
        }
    },

    methods: {
        resize() {
            let that = this;

            clearTimeout(that.chartTimer);

            // that.chartTimer = setTimeout(() => {
            //     that.chartHeight = that.$refs.blockContent.offsetHeight + "px";
            // }, 100);
        },

        getData() {
            let that = this;

        }
    }
};
</script>
<style lang="less" scoped>
.dashboard {
}

</style>