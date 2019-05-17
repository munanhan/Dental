<template>
    <div class="return-visit">
        <diagnose v-show="showContent == 'diagnose'" @change-show="changeShow"></diagnose>
        <monthly-calendar v-show="showContent == 'monthlyCalendar'" @change-show="changeShow"></monthly-calendar>
        <return-visit v-show="showContent == 'returnVisit'" @change-show="changeShow"></return-visit>
    </div>
</template>

<script>
import Diagnose from "./Diagnose";
import MonthlyCalendar from "./MonthlyCalendar";
import ReturnVisit from "./ReturnVisit";

export default {
    name: "ReturnVisitIndex",
    components: { Diagnose, MonthlyCalendar, ReturnVisit },
    props: {},
    data() {
        return {
            showContent: 'diagnose'
        };
    },
    created() {},
    mounted() {},
    watch: {},
    computed: {},
    methods: {
        changeShow(value){
            let that = this;
            that.showContent = value;
        }

    }
};
</script>
<style lang="less" scoped>
.return-visit {
    height: 100%;
}
</style>