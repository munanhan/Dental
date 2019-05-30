<template>
    <div class="content">
      <el-dialog
        title="费用类型设置"
        :visible.sync="show"
        width="500px"
        :before-close="closeDialog"
        v-dialog-drag
        append-to-body
        >
      <el-row>
      <div class="search">
        <el-col :span="2">
              <span>
                  <el-button type="primary" @click="addDialog = true" style="background-color:#2f6386;border:1px solid #2f6386;">新增</el-button>
              </span>
        </el-col>
      </div>
      </el-row>

      <el-row>
        <el-col :span="24">
          <div>
            <el-table
              :data="tableData"
              style="width: 100%">
              <el-table-column
                prop="category"
                label="费用类型"
                >
              </el-table-column>
              <el-table-column
                prop="operation"
                label="操作">

                    <template slot-scope="scope">
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
                                style="background-color:#2f6386;border:1px solid #2f6386;"
                                @click.stop="showEditDialog(scope.row)"
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
        </el-col>
      </el-row>
    </el-dialog>

    <!--添加-->
    <add-cost-type 
        :show.sync="addDialog"
        @flush="flush"
    >
    </add-cost-type>
    <!--修改-->
    <edit-cost-type 
        :show.sync="editDialog"
        :editItem="editItem"
        @flushData="flushData"
    >
    </edit-cost-type>

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
// import SetPassword from "./SetPassword";
// import AddDialog from "./AddDialog";
// import EditDialog from "./EditDialog";
import DialogForm from "@views/base/DialogForm";
import EditCostType from "./EditCostTypeDialog";
import AddCostType from "./AddCostTypeDialog";
export default {
    name: 'CostType',
    mixins: [DialogForm],
    components: {
       AddCostType,
       EditCostType
    },
      props: {
        
      },
      data() {

        return {
          addDialog:false,
          editDialog:false,
          id:'',
          is_del:false,
          del_id:0,
          editItem:{},
           tableData: [
                // {
                // id: 1,
                // cost_type: '西药费',
                // operation:''
                // },
                // {
                // id: 2,
                // cost_type: '放射费',
                // operation:''
                // },
                // {
                // id: 3,
                // cost_type: '检查费',
                // operation:''
                // },
                // {
                // id: 4,
                // cost_type: '诊疗费',
                // operation:''
                // },
                // {
                // id: 5,
                // cost_type: '补牙费',
                // operation:''
                // },
                // {
                // id: 6,
                // cost_type: '手术费',
                // operation:''
                // },
                // {
                // id: 7,
                // cost_type: '正畸费',
                // operation:''
                // },
                // {
                // id: 8,
                // cost_type: '拔牙费',
                // operation:''
                // },
                // {
                // id: 9,
                // cost_type: '修复费',
                // operation:''
                // },
                // {
                // id: 10,
                // cost_type: '其他',
                // operation:''
                // },
          ]
          // tableData:[]
        };
      },
      created() {},
      mounted() {
        //let that = this;
        //that.getData();
      },
      watch: {
        show(newValue, oldValue) {
          let that = this;

          if (newValue) {
            let that = this;
            that.getData();
          }
        }
      },
      computed: {},
      methods: {
        showDel(id){
          //删除框
          let that = this;
          that.del_id = id;
          that.is_del = true;
        },
        del(){
          let that = this;
          let id = that.del_id;
          that.$api.cost_category.del({id})
            .then(res => {
              if(res.code == 200){
                for (var i = 0, length = that.tableData.length - 1; i <= length; i++) {

                     if (that.tableData[i].id == id) {

                         that.tableData.splice(i,1);
                     }
                }
                this.$message({
                    message: res.msg,
                    type: "success",
                    duration: 800
                });
                that.is_del = false;
                that.$emit("delMenu",id);
               }
               else{
                   that.$message.error(
                        res.msg || "delete error."
                    );
               }
            })
            .catch(res => {
               // console.log(res);
            });
        },
        flush(data){
          let that = this;
          that.tableData.push(data);
          that.$emit("flushMenu",data);//刷新父级
        },
        flushData(data){
          let that = this;
          for (var i = 0, length = that.tableData.length - 1; i <= length; i++) {
               if (that.tableData[i].id == data.id) {
                   that.tableData[i] = data;
                   break;
               }
          }
          that.$emit("updateMenu",data);//刷新父级
        },
        showEditDialog(editItem){
          let that = this;
          that.editItem = editItem;
          that.editDialog = true;
        },
        getData() {
            let that = this;
            that.$api.cost_category.get()
            .then(res => {
               that.tableData = res.data;
            })
            .catch(res => {

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

.staff_name{
  padding: 10px;
}
.btn_class{
    background: white;
    text-align: center;
}
.search {
    padding: 10px;
    border-bottom: 1px solid #e3e3e3;
    height: 40px;
    width: 100%;
    background: white;
}
.content{
    background: white;
    height: 800px;
}

/*.title{
  text-align: center;
  margin-bottom: 10px;
}*/
</style>