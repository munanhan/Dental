<template>
    <div></div>
</template>

<script>
import Base from './Base';
export default {
    name: 'ExternalProcessing',
    components:{},

    mixins: [Base],

    props:{
            refresh: {
      type: Boolean,
      required: true
    }
    },
    data(){
      return {
      }
    },
    created(){},
    mounted(){},
    watch:{

    },
    computed:{},
    methods:{
                afterGetData(res) {
            let that = this;
        }
    },
}
</script>
<style lang="less" scoped>

</style>