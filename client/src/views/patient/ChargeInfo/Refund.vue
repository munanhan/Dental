<template>
  <el-dialog
    title="退费操作"
    :visible.sync="show"
    width="550px"
    :close-on-click-modal="false"
    class="custom-dialog"
    center
    v-dialog-drag
  >
    <el-form
      ref="form"
      :model="form"
      label-width="80px"
    >
      <div class="Refun-content">
        <div class="fristline">
          <div class="frist-format"> 用户名</div>
          <div class="frist-format"> 用户账号</div>
        </div>
        <div class="secondline">
          <div class="second-format"> 累计欠款:</div>
          <div
            class="second-format"
            style="margin-left:100px;font-weight:bold"
          > 0.00</div>
        </div>
        <div style="display:flex">
          <el-form-item
            label="实退金额"
            size="small"
            class="box"
          >
            <el-input></el-input>
          </el-form-item>
          <el-form-item
            label="退款名称"
            size="small"
            class="box"
          >
            <el-select
              v-model="form.value"
              placeholder="请选择"
            >
              <el-option
                v-for="item in form.options"
                :key="item.value"
                :label="item.label"
                :value="item.value"
              >
              </el-option>
            </el-select>
          </el-form-item>
        </div>
        <div style="display:flex">
          <el-form-item
            label="退 款 人"
            size="small"
            class="box"
          >
            <el-select
              v-model="form.value"
              placeholder="请选择"
            >
              <el-option
                v-for="item in form.options"
                :key="item.value"
                :label="item.label"
                :value="item.value"
              >
              </el-option>
            </el-select>
          </el-form-item>
          <el-form-item
            label="退款方式"
            size="small"
            class="box"
          >
            <el-select
              v-model="form.value"
              placeholder="请选择"
            >
              <el-option
                v-for="item in form.options"
                :key="item.value"
                :label="item.label"
                :value="item.value"
              >
              </el-option>
            </el-select>
          </el-form-item>
        </div>
      </div>
    </el-form>
    <span
      slot="footer"
      class="dialog-footer"
    >
      <el-button @click="dialogClose">取 消</el-button>
      <el-button
        type="primary"
        @click="dialogClose"
      >确 定</el-button>
    </span>
  </el-dialog>
</template>

<script>
export default {
  props: ["show"],
  created() {},
  data() {
    return {
      form:{
       options: [{
          value: '选项1',
          label: '黄金糕'
        }, {
          value: '选项2',
          label: '双皮奶'
        }, {
          value: '选项3',
          label: '蚵仔煎'
        }, {
          value: '选项4',
          label: '龙须面'
        }, {
          value: '选项5',
          label: '北京烤鸭'
        }],
        value: '',
      dialogVisible: false
      }
    };
  },
  methods: {
    dialogClose() {
      this.$emit("update:show", false);
    },
    // handleClose(done) {
    //   this.$confirm("确认关闭？")
    //     .then(_ => {
    //       this.dialogClose();
    //       done();
    //     })
    //     .catch(_ => {});
    // }
  }
};
</script>
<style lang="less" scoped>
.Refun-content {
  .fristline {
    display: flex;
    border: 1px solid red;
    font-size: 15px;
    width: 100%;
    height: 40px;
    background-color: #f9f9f9;
    border: 1px solid #f6f6f6;
    .frist-format {
      margin: 0 30px;
      margin-top: 10px;
    }
  }
  .secondline {
    display: flex;
    .second-format {
      margin: 0 20px;
      margin-top: 20px;
    }
  }
  .box {
    margin-top: 20px;
    margin-left: 7px;
    font-size: 15px;
    width: 220px;
  }
}
</style>
