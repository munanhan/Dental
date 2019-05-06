<template>
    <el-container>
      <el-aside class="left">
        <el-row class="left_top">
          <el-col :span="6">
            操作时间
          </el-col>
          <el-col :span="3">
               <el-button 
                      type="primary" 
                      icon="el-icon-arrow-left" 
                      size="mini" 
                      circle
                      style="margin-top: -5px;
                             margin-left: 5px;
                             background-color: #efefef;
                             border:1px solid black;
                             color: black;
                      "
                      >
                        
                </el-button>
          </el-col>
          <el-col :span="3">
            今
          </el-col>
          <el-col :span="3">
            →
          </el-col>
          <el-col :span="3">
            天
          </el-col>
          <el-col :span="3">
            周
          </el-col>
          <el-col :span="3">
            月
          </el-col>
        </el-row>
        <el-row>
        </el-row>
        <el-row>
        </el-row>
        <el-row>
        </el-row>
      </el-aside>
      <el-main class="right">Main</el-main>
    </el-container>
</template>

<script>
export default {
    name: 'OperationRecord',
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
            that.getPatientInfo();
          }
        }
      },
      computed: {},
      methods: {
        getPatientInfo() {
          let that = this;

          that.$api.aaaa.aaaa
            .then(res => {
              that.getDataDone();
            })
            .catch(res => {
              that.getDataDone();
            });
        },

        getDataDone() {
          setTimeout(() => {
            that.$emit("update:refresh", false);
          }, 6e3);
        }
      }
}
</script>
<style lang="less" scoped>
/deep/ .el-aside {
    background-color: #efefef;
    color: #333;
    text-align: center;
    font-size: 17px;
}
.left{
  width: 300px;
  height: 700px;
  border:1px solid black;
  .left_top{
    border-bottom: 1px solid black;
    height: 40px;
    padding: 10px;
  }
}
.right{
  border:1px solid black;
  height: 700px;
}
</style>