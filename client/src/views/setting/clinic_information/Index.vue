<template>
  <div>
    <el-row :span="12">
      <div class="top">
        <el-col :span="2">
                  <i
                    class="fa fa-shield-alt"
                    style="margin-top:10px;
                           font-size:40px;
                           cursor:pointer;
                           margin-left:10px;
                           color: #2f6386;
                         "
                  ></i>
        </el-col>
        <el-col :span="22">
          <el-col :span="24" class="titel">
            安全中心
          </el-col>
          <el-col :span="24">
            账号:admin
          </el-col>
          <el-col :span="24">
            安全等级:强
          </el-col>
          <el-col :span="24">
            目前账号非常安全
          </el-col>
        </el-col>

      </div>
    </el-row>
      <div class="midden">
        <i
          class="fa fa-paperclip"
          style="margin-top:10px;
                 font-size:40px;
                 cursor:pointer;
                 margin-left:10px;
                 color: #2f6386;
               "
        ></i>
      </div>
    <el-row :span="12">
      <div class="bottom">
        <i
          class="fa fa-hospital"
          style="margin-top:10px;
                 font-size:40px;
                 cursor:pointer;
                 margin-left:10px;
                 color: #2f6386;
               "
        ></i>
      </div>
    </el-row>    
  </div>

</template>

<script>
export default {
    name: 'ClinicInformation',
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
.titel{
  font-size: 20px;
  font-weight: bold;
  margin: 12px 0 10px 8px;
}
.top{
  border: 1px solid black;
  width: 600px;
  height: 150px;
  margin: 0 0 0 40px;
}
.midden{
  border: 1px solid black;
  width: 600px;
  height: 150px;
  margin: 0 0 0 40px;
}
.bottom{
  border: 1px solid black;
  width: 600px;
  height: 150px;
  margin: 0 0 0 40px;
}
</style>