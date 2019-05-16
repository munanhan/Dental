<template>
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
                          prop="category"
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
                    width="300"
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
                    prop="category"
                  >
                 
                  </el-table-column>
                  <el-table-column
                    label="计费方式"
                    prop="billing_mode"
                  >
                  <!-- <template slot-scope="scope">
                      <div v-if="scope.row.billing_mode == 1">
                         按牙齿数计费
                      </div>
                      <div v-if="scope.row.billing_mode == 2">
                         按其他计费
                      </div>
                  </template> -->
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
                                @click.stop="showDel(scope.row.id)"
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
      @flushMenu="flushMenu"
      @delMenu="delMenu"
      @updateMenu="updateMenu"
    >
    </cost-type>
    <!-- 添加处置与收费 -->
    <add-disposal-charging
      :show.sync="addDisposalChargingDialog"
      @flush="flushData"
    >
    </add-disposal-charging>
    <!-- 修改处置与收费 -->
    <edit-disposal-charging
      :show.sync="editDisposalChargingDialog"
      :editItem="editItem"
      @flush="flush"
    >
    </edit-disposal-charging>

    <!-- 删除提示框 -->
    <el-dialog title="提示" :visible.sync="is_del" width="300px" center>
       <div class="del-dialog-cnt">删除不可恢复，是否确定删除？</div> 
       <span slot="footer" class="dialog-footer">
          <el-button @click="is_del = false">取 消</el-button>
          <el-button type="primary" @click="del" >确 定</el-button>
      </span>
    </el-dialog>

    </div>
</template>

<script>
import CostType from './CostTypeDialog';
import AddDisposalCharging from './AddDisposalChargingDialog';
import EditDisposalCharging from './EditDisposalChargingDialog';
export default {
    name: 'DisposalCharging',
    components: {
      CostType,
      AddDisposalCharging,
      EditDisposalCharging
    },
      props: {
        refresh: {
          type: Boolean,
          required: true
        }
      },
      data() {
        return {
          is_del:false,//删除窗口
          
          del_id:0,

          menu_id:0,//当前菜单id
                   
          costTypeDialog:false,//费用类型窗口
          
          addDisposalChargingDialog:false,//添加处置窗口
          
          editDisposalChargingDialog:false,//修改处置窗口
          
          editItem:{},//修改数据组合
          
          tableHeight:700,//高度设定

          menuHeight:667,

          menuData:[
                    // {
                    //   id:1,
                    //   catepory:'西药费'
                    // },
                    // {
                    //   id:2,
                    //   catepory:'放射费'
                    // },
                    // {
                    //   id:3,
                    //   catepory:'检查费'
                    // },
                    // {
                    //   id:4,
                    //   catepory:'诊疗费'
                    // },
                    // {
                    //   id:5,
                    //   catepory:'补牙费'
                    // },
                    // {
                    //   id:6,
                    //   catepory:'手术费'
                    // },
                    // {
                    //   id:7,
                    //   catepory:'正崎费'
                    // },
                    // {
                    //   id:8,
                    //   catepory:'拔牙费'
                    // },
                    // {
                    //   id:9,
                    //   catepory:'修复费'
                    // },
                    // {
                    //   id:10,
                    //   catepory:'其  他'
                    // },
                   ],
          tableData:[
            // {
            //   id:1,
            //   disposal_code:'001',
            //   disposal_name:'必兰麻',
            //   price:50.00,
            //   unit:'项',
            //   mem_discount:1,
            //   cost_type:'西药费',
            //   billing_mode:1,
            //   remarks:'无',
            //   operation:'',
            //   status:1
            // },
            // {
            //   id:2,
            //   disposal_code:'002',
            //   disposal_name:'保丽净',
            //   price:999.99,
            //   unit:'项',
            //   mem_discount:0,
            //   cost_type:'西药费',
            //   billing_mode:2,
            //   remarks:'无',
            //   operation:'',
            //   status:0
            // },
          ]
        };
      },
      created() {},
      mounted() {
        let that = this;

        that.$nextTick(() => {
            that.resizeTable();
        });

        //监听事件,由layout那边的resize抛出的
        if (window.addEventListener) {
            window.addEventListener("bodyChange", that.resizeTable);
        } else {
            window.attachEvent("bodyChange", that.resizeTable);
        }
    },
    watch: {
        refresh(newValue, oldValue) {
            let that = this;

            if (newValue) {
                that.resizeTable();

                //更新原来的refresh, 防止下次点击时不通知更新
                that.$emit("update:refresh", false);

                that.getMenu();
                // that.getData();
            }
        }
    },

      computed: {},
      methods: {
        getMenuTableData(row){
          let that = this;
          that.menu_id = row.id;
          that.getData(row.id);
        },
        showCostTypeDialog(){
           let that = this;
           that.costTypeDialog = true;
        },
        resizeTable() {
            let that = this;
                // if (that.$refs.menuContent.clientHeight != 0) {
                  let tableHeight = that.$refs.menuContent.clientHeight - 70;
                  that.tableHeight = tableHeight;
                  that.menuHeight = tableHeight - 33; 
                // }
                
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
          // that.getById(editItem);
          that.editDisposalChargingDialog = true;
        },
        showDel(id){
          //删除框
          let that = this;
          that.del_id = id;
          that.is_del = true;
        },
        del(){
          //删除
          let that = this;
          let id = that.del_id;
           
          that.$api.disposal.del({id})
          .then(res => {

                if(res.code == 200){
                  for (var i = 0, length = that.tableData.length - 1; i <= length; i++) {
                        console.log(id);
                        console.log(that.tableData[i].id);
                         if (that.tableData[i].id == id) {
                             that.tableData.splice(i,1);
                             break;
                         }
                    }

                    that.$message({
                        message: res.msg,
                        type: "success",
                        duration: 800
                    });
                    that.is_del = false;
                }
                else{
                     that.$message.error(
                          res.msg || "操作异常请重试."
                      );
                }
          })
          .catch(res => {
            console.log(res);
          });
        },
        showAddDialog(){
          let that = this;
          that.addDisposalChargingDialog = true;
        },
        importData(){

        },
        exportData(){

        },
        // getById(editItem){
        //     let that = this;
        //     let id = editItem.id
        //     that.$api.disposal.getById({'id':id})
        //     .then(res => {
        //        that.editItem = res.data;
        //        that.editDisposalChargingDialog = true;
        //     })
        //     .catch(res => {
        //       // console.log(res)
        //     });
        // },
        getData(id){
          //获取列表数据
          let that = this;
            that.$api.disposal.get({'id':id})
            .then(res => {
               that.tableData = res.data;
            })
            .catch(res => {

            });

        },
        getMenu() {
          //获取菜单
            let that = this;
            that.$api.cost_category.get()
            .then(res => {
               that.menuData = res.data;
            })
            .catch(res => {

            });
        },
        flushData(data){
          //刷新数据
          let that = this;
          that.menu_id == data.cate_id?that.flush():'';
        },
        flushMenu(data){
          //刷新菜单
            let that = this;
            that.menuData.push(data);
        },
        flush(){
          //刷新列表
          let that = this;
          that.getData(that.menu_id);
        },
        delMenu(id){
          //删除菜单
          let that = this;
          for (var i = 0, length = that.menuData.length - 1; i <= length; i++) {
               if (that.menuData[i].id == id) {
                   that.menuData.splice(i,1);
                   break;
               }
          }
        },
        updateMenu(data){
          //刷新菜单2
          let that = this;
          for (var i = 0, length = that.menuData.length - 1; i <= length; i++) {
               if (that.menuData[i].id == data.id) {
                   that.menuData[i] = data;
                   that.menuData.push({});//为了刷新数据新增一个空对象，然后删除
                   that.menuData.pop();
                   break;
               }
          }
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