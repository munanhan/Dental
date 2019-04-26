<template>
  <div>
      <div style="width:1000px;margin-left:10px;margin-bottom:10px;" >
sadasdsa
      </div>
      <div dis-bottom>
        <div style="border:1px solid #e4e4e4;
                    background-color:#e3e3e3;
                    position:absolute;
                    left;0;bottom:0;
                    width:100%;
                    height:59px">

      <el-button style="width:130px;margin-left:10px;margin-top:10px" type="primary" @click="add_cons">增加</el-button>
    </div>
      </div>
      <add-consulting :show.sync="addcons_show"></add-consulting>
  </div>
  
</template>

<script>
import AddConsulting from "./AddConsulting";

export default {
  name: "ConsultingInfo",
  components: {
    AddConsulting
  },
  props: {
    refresh: {
      type: Boolean,
      required: true
    }
  },
  data() {
    return {
      addcons_show:false,
    };
  },
  created() {},
  mounted() {},
  watch: {
    refresh(newValue, oldValue) {
      let that = this;

      if (newValue) {
        that.getDisposalRecords();
      }
    }
  },
  computed: {},
  methods: {
    getDisposalRecords() {},

    getDataDone() {
      setTimeout(() => {
        that.$emit("update:refresh", false);
      }, 6e3);
    },
    add_cons(){
      this.addcons_show = true;
    }
  }
};
</script>
<style lang="less" scoped>
//导入全局的颜色
@import "~@css/var";

.dis-button{
   width: 130px;
  margin-left: 10px;
  margin-top: 10px;
}
</style>