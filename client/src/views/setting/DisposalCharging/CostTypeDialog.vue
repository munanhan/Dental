<template>
    <div class="content">
      <el-dialog
        title="费用类型设置"
        :visible.sync="show"
        width="500px"
        :before-close="closeDialog"
        v-dialog-drag
        >
      <el-row>
      <div class="search">
        <el-col :span="2">
              <span>
                  <el-button type="primary" @click="addDialog = true">新增</el-button>
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
                prop="cost_type"
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
                                @click.stop="del(scope.row.id)"
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
    >
    </add-cost-type>
    <!--修改-->
    <edit-cost-type 
        :show.sync="editDialog"
        :editItem="editItem"
    >
    </edit-cost-type>
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
          editItem:{},
           tableData: [
                {
                id: 1,
                cost_type: '西药费',
                operation:''
                },
                {
                id: 2,
                cost_type: '放射费',
                operation:''
                },
                {
                id: 3,
                cost_type: '检查费',
                operation:''
                },
                {
                id: 4,
                cost_type: '诊疗费',
                operation:''
                },
                {
                id: 5,
                cost_type: '补牙费',
                operation:''
                },
                {
                id: 6,
                cost_type: '手术费',
                operation:''
                },
                {
                id: 7,
                cost_type: '正畸费',
                operation:''
                },
                {
                id: 8,
                cost_type: '拔牙费',
                operation:''
                },
                {
                id: 9,
                cost_type: '修复费',
                operation:''
                },
                {
                id: 10,
                cost_type: '其他',
                operation:''
                },
          ]
          // tableData:[]
        };
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
        del(id){
           alert(id);
        },
        showEditDialog(editItem){
          let that = this;
          that.editItem = editItem;
          that.editDialog = true;
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