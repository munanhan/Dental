<template>
  <div>
        <!--修改密码-->
      <el-dialog
        title="处置与收费设置"
        :visible.sync="show"
        width="1246px"
        :before-close="closeDialog"
        v-dialog-drag
        >
      <div class="content" ref="menuContent">
      <el-container>
        <el-aside class="left" :style="{'width':200+'px'}">
            <div class="menu_title">
              <el-row>
                <el-col :span="10">
                  <div class="title">
                    费用大类
                  </div>

                  </el-col>
                  <el-col :span="13">
                    <div class="setting">
                      <i
                        class="fa fa-cog"
                        style="margin-top:10px;
                             font-size:20px;
                             cursor:pointer;
                             margin-left:10px"
                             @click="showCostTypeDialog"
                      ></i>
                    </div>
                </el-col>
              </el-row>
              <el-row>
                <el-col :span="24">
                  <div class="menu_content">
                      <el-table
                        :data="menuData"
                        stripe
                        border
                        :show-header="false"
                        highlight-current-row
                        :height="menuHeight"
                        @row-click="getMenuTableData"
                        >
                        <el-table-column
                          prop="catepory"
                        >
                        </el-table-column>
                      </el-table>

                  </div>
                </el-col>
              </el-row>
              
            </div>
        </el-aside>

        <el-main class="right">
        <el-col :span="24">
          <el-row>
            <div class="right">
            <div class="data_content">
                <el-table
                  :data="tableData"
                  stripe
                  :height="tableHeight"
                  highlight-current-row
                  style="width: 100%">
                  <el-table-column
                    label="处置代码"
                    prop="disposal_code"
                  >
                  </el-table-column>
                  <el-table-column
                    label="处置名称"
                    prop="disposal_name"
                  >
                  </el-table-column>
                  <el-table-column
                    label="价格"
                    prop="price"
                  >
                  </el-table-column>
                  <el-table-column
                    label="单位"
                    prop="unit"
                  >
                  </el-table-column>
                  <el-table-column
                    label="按会员折扣"
                    prop="mem_discount"
                  >
                  <template slot-scope="scope">
                      <div v-if="scope.row.mem_discount == 1">
                         是
                      </div>
                      <div v-if="scope.row.mem_discount == 0">
                         否
                      </div>
                  </template>
                  </el-table-column>
                  <el-table-column
                    label="费用类型"
                    prop="cost_type"
                  >
                 
                  </el-table-column>
                  <el-table-column
                    label="计费方式"
                    prop="billing_mode"
                  >
                  <template slot-scope="scope">
                      <div v-if="scope.row.billing_mode == 1">
                         按牙齿数计费
                      </div>
                      <div v-if="scope.row.billing_mode == 2">
                         按其他计费
                      </div>
                  </template>
                  </el-table-column>
                  <el-table-column
                    label="备注"
                    prop="remarks"
                  >
                  </el-table-column>
                  <el-table-column
                    label="操作"
                    prop="operation"
                    width="200"
                  >
                  <template slot-scope="scope">
                    <div v-if="scope.row.status == 0" style="display: inline-block;margin-right: 10px;">
                      <el-tooltip
                            effect="dark"
                            content="停用"
                            placement="bottom"
                        >
                            <el-button
                                type="warning"
                                size="mini"
                                icon="el-icon-minus"
                                circle
                                @click.stop="stop(scope.row.id)"
                            ></el-button>
                        </el-tooltip>
                    </div>
                    <div v-if="scope.row.status == 1" style="display: inline-block;padding-right: 10px">
                      <el-tooltip
                            effect="dark"
                            content="启用"
                            placement="bottom"
                        >
                            <el-button
                                type="success"
                                size="mini"
                                icon="el-icon-check"
                                circle
                                @click.stop="start(scope.row.id)"
                            ></el-button>
                        </el-tooltip>
                    </div>
                      <el-tooltip
                            effect="dark"
                            content="修改"
                            placement="bottom"
                        >
                            <el-button
                                type="primary"
                                size="mini"
                                icon="el-icon-edit"
                                circle
                                @click.stop="edit(scope.row)"
                            ></el-button>
                        </el-tooltip>
                      <el-tooltip
                            effect="dark"
                            content="删除"
                            placement="bottom"
                        >
                            <el-button
                                type="danger"
                                size="mini"
                                icon="el-icon-delete"
                                circle
                                @click.stop="del(scope.row.id)"
                            ></el-button>
                        </el-tooltip>
                        
                    </template>

                  </el-table-column>
                </el-table>
            </div>
          </div>
          </el-row>
          <el-row>
              <div class="btn_content">
                  <el-col :span="24">
                        <span class="">
                            <el-button style="margin-right: 10px;"  type="primary" @click="showAddDialog">添加</el-button>
                        </span>
                  
                        <span class="">
                            <el-button style="margin-right: 10px;" type="primary" @click="importData">导入Excel</el-button>
                        </span>
                 
                        <span class="">
                            <el-button style="margin-right: 10px;" type="primary" @click="exportData">导出Excel</el-button>
                        </span>
                  </el-col>
              </div>
          </el-row>
        </el-col>
        </el-main>
      </el-container>  
          
    <!-- 费用大类 -->
    <cost-type
      :show.sync="costTypeDialog"
    >
    </cost-type>
    <!-- 添加处置与收费 -->
    <add-disposal-charging
      :show.sync="addDisposalChargingDialog"
    >
    </add-disposal-charging>
    <!-- 修改处置与收费 -->
    <edit-disposal-charging
      :show.sync="editDisposalChargingDialog"
      :editItem="editItem"
    >
    </edit-disposal-charging>


    </div>
      </el-dialog>

      
  </div>
</template> 
<script>

import DialogForm from "@views/base/DialogForm";
import CostType from '../disposal_charging/CostTypeDialog';
import AddDisposalCharging from '../disposal_charging/AddDisposalChargingDialog';
import EditDisposalCharging from '../disposal_charging/EditDisposalChargingDialog';
export default {
    name: 'DisposalCharging',
    mixins: [DialogForm],
    components: {
      CostType,
      AddDisposalCharging,
      EditDisposalCharging
    },
      props: {
        // refresh: {
        //   type: Boolean,
        //   required: true
        // }
      },
      data() {
        return {
          costTypeDialog:false,
          addDisposalChargingDialog:false,
          editDisposalChargingDialog:false,
          editItem:{},
          tableHeight:700,
          menuHeight:667,
          menuData:[
                    {
                      id:1,
                      catepory:'西药费'
                    },
                    {
                      id:2,
                      catepory:'放射费'
                    },
                    {
                      id:3,
                      catepory:'检查费'
                    },
                    {
                      id:4,
                      catepory:'诊疗费'
                    },
                    {
                      id:5,
                      catepory:'补牙费'
                    },
                    {
                      id:6,
                      catepory:'手术费'
                    },
                    {
                      id:7,
                      catepory:'正崎费'
                    },
                    {
                      id:8,
                      catepory:'拔牙费'
                    },
                    {
                      id:9,
                      catepory:'修复费'
                    },
                    {
                      id:10,
                      catepory:'其  他'
                    },
                   ],
          tableData:[
            {
              id:1,
              disposal_code:'001',
              disposal_name:'必兰麻',
              price:50.00,
              unit:'项',
              mem_discount:1,
              cost_type:'西药费',
              billing_mode:1,
              remarks:'无',
              operation:'',
              status:1
            },
            {
              id:2,
              disposal_code:'002',
              disposal_name:'保丽净',
              price:999.99,
              unit:'项',
              mem_discount:0,
              cost_type:'西药费',
              billing_mode:2,
              remarks:'无',
              operation:'',
              status:0
            },
          ]
        };
      },
      created() {},
      mounted() {
        // let that = this;

        // that.$nextTick(() => {
        //     that.resizeTable();
        // });

        // //监听事件,由layout那边的resize抛出的
        // if (window.addEventListener) {
        //     window.addEventListener("bodyChange", that.resizeTable);
        // } else {
        //     window.attachEvent("bodyChange", that.resizeTable);
        // }
    },
    watch: {
        update(newValue, oldValue) {
            let that = this;
            if (newValue) {
                that.resizeTable();

                setTimeout(() => {
                    that.$emit("update:update", false);
                });
            }
        }
    },

      computed: {},
      methods: {
        getMenuTableData(row){
          alert(row.id);
        },
        showCostTypeDialog(){
           let that = this;
           that.costTypeDialog = true;
        },
        resizeTable() {
            let that = this;
                if (that.$refs.menuContent.clientHeight != 0) {
                  let tableHeight = that.$refs.menuContent.clientHeight - 70;
                  that.tableHeight = tableHeight;
                  that.menuHeight = tableHeight - 33; 
                }
                
                    // that.$refs.search.clientHeight -
                    // 70;
                    // console.log(tableHeight);
            
        },
        start(id){
          //开始
          alert(id);
        },
        stop(id){
          //结束
          alert(id);
        },
        edit(editItem){
          //修改
          let that = this;
          that.editItem = editItem;
          that.editDisposalChargingDialog = true;
        },
        del(id){
          //删除
          alert(id);
        },
        showAddDialog(){
          let that = this;
          that.addDisposalChargingDialog = true;
        },
        importData(){

        },
        exportData(){

        },
       
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
//导入全局的颜色
@import "~@css/var";
/deep/ .el-table--striped .el-table__body tr.el-table__row--striped.current-row td, 
/deep/ .el-table__body tr.current-row>td {
  background-color: @linght-background-color;
}


.content{
  background: white;
  height: 100%;

}

.data_content{
  border: 1px solid #dbdbdb;
  margin-bottom: 10px;
}
.left{
  border: 1px solid #dbdbdb;
  height: 100%;
  width: 180px;
  /*height: 800px;*/

  .title{
    padding-top: 10px;
    padding-bottom: 5px;
    padding-left: 16px;
    font-size: 14px;
    font-weight: bold;
    color: @color;
    /*text-align: center;*/
    border-bottom: 2px solid @color;
  }

  .setting{
    float: right;
    /*padding-right: 10px;*/
  }

  .menu_content{

    /deep/ .el-table--enable-row-hover .el-table__body tr:hover>td {
      background-color: @linght-background-color;
      cursor:pointer;
    }
    /deep/ .el-table__body td{
      padding: 3px 0;
    }

  }
}
.right{
  /*border: 1px solid #dbdbdb;*/
  padding: 0 0 0 5px;
  /*height: 800px;*/
  height: 100%;
  /deep/ .el-table--enable-row-hover .el-table__body tr:hover>td {
      background-color: @linght-background-color;
  }
}
.btn_content {
    padding: 0 0 10px 10px;
    /*border-bottom: 1px solid #e3e3e3;*/
    height: 40px;
    /*width: 100%;*/
}
</style>