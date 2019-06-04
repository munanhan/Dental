<template>
  <div>
        <!--修改密码-->
      <el-dialog
        title="会员等级维护"
        :visible.sync="show"
        width="600px"
        :before-close="closeDialog"
        v-dialog-drag
        >
      <el-row :gutter="10">
      <div class="search">

        <el-col :span="2">
              <span class="">
                  <el-button type="primary" @click="addMemberLevel">添加</el-button>
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
                prop="name"
                label="会员等级"
                >
              </el-table-column>
              <el-table-column
                prop="discount"
                label="会员折扣(%)"
              >
              <template slot-scope="scope">
                        
                            {{scope.row.discount}}%

              </template>
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
                                @click.stop="showDel(scope.row)"
                            ></el-button>
                        </el-tooltip>
                    </template>
              </el-table-column>
            </el-table>
          </div>
        </el-col>
      </el-row>
      </el-dialog>

      <!--修改-->
      <edit-member-level
        :show.sync="editMemberDialog"
        :editItem="editItem"
        @flush="updateData"
      >
      </edit-member-level>
      <!--新增-->
      <add-member-level
        :show.sync="addMemberDialog"
        @flush="addData"
      >
      </add-member-level>
    <!-- 删除提示框 -->
    <el-dialog title="提示" :visible.sync="is_del" width="300px" center>
       <div class="del-dialog-cnt">删除不可恢复，是否确定删除？</div> 
       <span slot="footer" class="dialog-footer">
          <el-button @click="is_del = false">取 消</el-button>
          <el-button type="primary" @click="delData" >确 定</el-button>
      </span>
    </el-dialog>
  </div>
</template> 
<script>

import DialogForm from "@views/base/DialogForm";
import EditMemberLevel from "./EditMemberLevelDialog";
import AddMemberLevel from "./AddMemberLevelDialog";
export default {
    name: 'SetMemberLevel',
    mixins: [DialogForm],
    components: {
      EditMemberLevel,
      AddMemberLevel
    },
      props: {
        // refresh: {
        //   type: Boolean,
        //   required: true
        // }
      },
      data() {

        return {
          is_del:false,
          //删除窗口
          del_id:0,
          //删除id
          editMemberDialog:false,
          addMemberDialog:false,
          editItem:{},
          tableData: [],
          rules:{
            
          },
          commitLoading: false,

          // tableData:[]
        };
      },
      created() {

      },
      mounted() {
        //let that = this;
        //that.getData();
      },
      watch: {
        // refresh(newValue, oldValue) {
        //     let that = this;
        //     if (newValue) {
        //         // that.resizeTable();

        //         //更新原来的refresh, 防止下次点击时不通知更新
        //         // that.$emit("update:refresh", false);
        //         that.getData();
        //         // that.getData();
        //     }
        // },
        show(newValue,oldValue){
           let that = this;
           if (newValue) {
              that.getData();
           }
        }
        
      },
      computed: {},
      methods: {
        addMemberLevel(){
          let that = this;
          that.addMemberDialog = true;
        },
        showEditDialog(item){
          let that = this;
          that.getById(item);
        },
        showDel(item){
          let that = this;
          that.del_id = item.id;
          that.is_del = true;
        },
        closePassDialog(){
           let that = this;
           that.$refs["form"].resetFields();
           that.closeDialog();
        },

        /*******获取数据********/
        getData(){
            //获取数据
            let that = this;
            that.$api.patient_member.get()
            .then(res => {
               that.tableData = res.data;
            })
            .catch(res => {

            });
        },
        addData(data){
          //添加数据到列表
          let that = this;
          that.tableData.push(data);
        },
        getById(parms){
            let that = this;
            let id = parms.id;
            that.$api.patient_member.getById({'id':id})
            .then(res => {
                if (res.code == 200) {
                    that.editItem = res.data;
                    that.editMemberDialog = true;
                }else{
                    that.$message.error(
                          res.msg || "操作异常请重试."
                      );
                }
            })
            .catch(res => {

            });
        },
        updateData(data){
            //更新数据
            let that = this;
            for (var i = 0, length = that.tableData.length - 1; i <= length; i++) {
                // console.log(id);
                if (that.tableData[i].id == data.id) {
                     that.$set(that.tableData,i,data);
                     break;
                }
            }
        },
        delData(){
          //删除数据
          let that = this;
          let id = that.del_id;
          that.$api.patient_member.del({id})
          .then(res => {

                if(res.code == 200){
                  for (var i = 0, length = that.tableData.length - 1; i <= length; i++) {

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
        }
      }
}
</script>