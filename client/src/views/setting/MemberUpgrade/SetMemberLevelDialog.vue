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
              :data="form"
              style="width: 100%">
              <el-table-column
                prop="mem_level"
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
                                @click.stop="del(scope.row)"
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
      >
      </edit-member-level>
      <!--新增-->
      <add-member-level
        :show.sync="addMemberDialog"
      >
      </add-member-level>
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
          editMemberDialog:false,
          addMemberDialog:false,
          editItem:{},
          form: [
            {
              id:1,
              mem_level: '金牌会员',
              discount: 50
            },
            {
              id:2,
              mem_level: '白银会员',
              discount: 70
            },
            {
              id:3,
              mem_level: '铜牌会员',
              discount: 90
            }
          ],
          rules:{
            
          },
          commitLoading: false,

          // tableData:[]
        };
      },
      created() {

      },
      mounted() {},
      watch: {
        // refresh(newValue, oldValue) {
        //   let that = this;

        //   if (newValue) {
        //     that.getPatientInfo();
        //   }
        // }
        
      },
      computed: {},
      methods: {
        addMemberLevel(){
          let that = this;
          that.addMemberDialog = true;
        },
        showEditDialog(item){
          let that = this;
          that.editItem = item;
          that.editMemberDialog = true;
        },
        del(item){
          alert(item.id);
        },
        submitForm(formName) {
          let id = this.id;
          this.$refs[formName].validate((valid) => {
            if (valid) {
              alert('submit!');
            } else {
              console.log('error submit!!');
              return false;
            }
          });
        },
        closePassDialog(){
           let that = this;
           that.$refs["form"].resetFields();
           that.closeDialog();
        }
      }
}
</script>