<template>
    <div class="return-visit">
        <diagnose v-show="showContent == 'diagnose'" :type.sync="showContent"></diagnose>
        <monthly-calendar v-show="showContent == 'monthlyCalendar'" :type.sync="showContent"></monthly-calendar>
        <return-visit v-show="showContent == 'returnVisit'" :type.sync="showContent"></return-visit>
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
    }
};
</script>
<style lang="less" scoped>
.return-visit {
    height: 100%;
}
</style>