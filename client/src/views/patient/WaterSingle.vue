<template>
  <el-dialog
    title="流水单   "
    :visible.sync="show"
    :before-close="closeDialog"
    class="custom-dialog"
    v-dialog-drag
    width="1000px"
    center
  >
    <el-form
      ref="form"
      :model="form"
      :rules="form.rules"
      label-width="80px"
    >
      <div class="Water-content ">
        <div class="Advan-top">
          <div class="one"> 1503010120</div>
          <div class="one"> 8岁</div>
          <div class="one"> *(无病历号)</div>
          <el-form-item size="mini">
            <el-button
              style="margin-top:7px;margin-left:500px"
              type="primary"
            >重算对账单</el-button>
          </el-form-item>
        </div>
        <div class="Water-bottom">
          <el-table
            border
            style="width: 100%"
            :header-cell-style="{backgroundColor:'#e3e3e3',color:'#3a3a3a'}"
          >
            <el-table-column
              prop="date"
              label="打印"
            >
            </el-table-column>
            <el-table-column
              prop="name"
              label="操作"
            >
            </el-table-column>
            <el-table-column
              prop="address"
              label="操作时间"
            >
            </el-table-column>
            <el-table-column
              prop="date"
              label="收费方式"
            >
            </el-table-column>
            <el-table-column
              prop="name"
              label="开票方式"
            >
            </el-table-column>
            <el-table-column
              prop="address"
              label="收入"
            >
            </el-table-column>
            <el-table-column
              prop="date"
              label="支出"
            >
            </el-table-column>
            <el-table-column
              prop="name"
              label="余额"
            >
            </el-table-column>
            <el-table-column
              prop="address"
              label="经手人"
            >
            </el-table-column>
            <el-table-column
              prop="address"
              label="备注"
              width="120"
            >
            </el-table-column>
          </el-table>
        </div>
      </div>
    </el-form>

    <div
      slot="footer"
      class="dialog-footer"
    >
      <el-button @click="closeDialog">取 消</el-button>
      <el-button
        :loading="commitLoading"
        type="primary"
      >确 定</el-button>
    </div>
  </el-dialog>
</template>

<script>
import DialogForm from "../base/DialogForm";
export default {
  name: "WaterSingle",

  mixins: [DialogForm],

  data() {
    return {
      form: {
        rules: {}
      }
    };
  },

  methods: {}
};
</script>
<style lang="less" scoped>
.Water-content {
  .Advan-top {
    display: flex;
    border: 1px solid red;
    font-size: 15px;
    width: 100%;
    height: 40px;
    background-color: #f9f9f9;
    border: 1px solid #f6f6f6;
    .one {
      margin-top: 10px;
      margin-left: 20px;
    }
    .two {
      margin-top: 6px;
      margin-left: 10px;
      font-size: 20px;
      font-weight: bold;
    }
  }
  .Water-bottom {
    margin-top: 20px;
  }
}
</style>