<template>
    <div
        class="content"
        ref="menuContent"
    >
        <el-container>
            <el-aside
                class="left"
                :style="{'width':255+'px'}"
            >
                <div class="menu_title">
                    <el-row>
                        <el-col :span="8">
                            <div class="title">
                                处置组合
                            </div>

                        </el-col>
                        <el-col :span="15">
                            <div class="setting">
                                <i
                                    class="fa fa-sitemap combo_btn"
                                    @click="addComboDirDialog = true"
                                ></i>
                                <i
                                    class="fa fa-share-alt combo_btn"
                                    @click="showAddComboDialog"
                                ></i>
                                <i
                                    class="fa fa-edit combo_btn"
                                    @click="showEditComboDialog"
                                ></i>
                                <i
                                    class="fa fa-trash-alt combo_btn"
                                    @click="delCombo"
                                ></i>
                            </div>
                        </el-col>
                    </el-row>
                    <el-row>
                        <el-col>
                            <div class="menu_content">
                                <el-tree
                                    :data="menuData"
                                    :props="treeField"
                                    @node-click="getMenuTableData"
                                    @current-change="clickNode"
                                    :highlight-current="selectThis"
                                    :style="{'height': menuHeight+'px'}"
                                    ref="tree"
                                    node-key="id"
                                >
                                <span slot-scope="{ node }">
                                    <span>
                                        <div v-if="node.level == 1">
                                          <i class="fa fa-folder-open"></i> 
                                          {{ node.label }} 
                                        </div>
                                        <div v-if="node.level == 2">

                                          <i class="fa fa-file-alt"></i> 
                                           {{ node.label }}
                                          
                                        </div>
                                    </span>              
                                </span>

                                </el-tree>
                            </div>
                        </el-col>
                    </el-row>

                </div>
            </el-aside>
            <el-main class="right">
                <el-col :span="24">
                    <el-row>

                        <div class="data_content">
                            <el-table
                                :data="tableData"
                                stripe
                                :height="tableHeight"
                                highlight-current-row
                                style="width: 100%"
                            >
                                
                                <el-table-column
                                    label="费用类型"
                                    prop="category"
                                >
                                </el-table-column>
                                <el-table-column
                                    label="处置名称"
                                    prop="disposal_name"
                                >
                                </el-table-column>
                                <el-table-column
                                    label="处置说明"
                                    prop="remarks"
                                >
                                </el-table-column>
                                <el-table-column
                                    label="单价"
                                    prop="price"
                                >
                                </el-table-column>
                                <el-table-column
                                    label="数量"
                                    prop="combo_qty"
                                >
                                </el-table-column>
                                <el-table-column
                                    label="费用"
                                    prop="cost"
                                >
                                </el-table-column>

                                <el-table-column
                                    label="操作"
                                    prop="operation"
                                    width="200"
                                >
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
                                                @click.stop="showDel(scope.row.disposal_id)"
                                            ></el-button>
                                        </el-tooltip>

                                    </template>

                                </el-table-column>
                            </el-table>
                        </div>

                    </el-row>
                    <el-row>
                        <div class="btn_content">
                            <el-col :span="24">
                                <!-- <span :style="{'display':add_btn}">
                                    <el-button
                                        type="primary"
                                        style="margin-right: 10px;"
                                        @click="showAddDialog"
                                    >添加</el-button>
                                </span> -->
                                <span :style="{'display':edit_btn}">
                                    <el-button
                                        type="primary"
                                        style="margin-right: 10px;"
                                        @click="showAddDialog"
                                    >设置处置组合明细</el-button>
                                </span>
                            </el-col>
                        </div>
                    </el-row>
                </el-col>
            </el-main>
        </el-container>

        <!-- 添加组合目录 -->
        <add-combo-dir
            :show.sync="addComboDirDialog"
            @flush="addMenu"
        >
        </add-combo-dir>
        <!-- 添加处置与收费 -->
        <add-combo
          :show.sync="addComboDialog"
          :p_id="parentId"
          @flush="addMenu"
        >
        </add-combo>
        <!-- 修改组合 -->
        <edit-combo
          :show.sync="editComboDialog"
          :editItem="editItem"
          @flush="updateItem"
        >
        </edit-combo>
        <!-- 修改数量 -->
        <edit-qty
          :show.sync="editQtyDialog"
          :editItem="editItem"
          @flush="updateData"
        >
        </edit-qty>
        <!-- 添加 -->
        <add
          :show.sync="addDialog"
          :itemList="itemList"
          :comboId=" comboId"
          @flush="flushData"
        >
        </add>
    <!-- 删除提示框 -->
    <el-dialog title="提示" :visible.sync="is_del" width="300px" center>
       <div class="del-dialog-cnt">删除不可恢复，是否确定删除？</div> 
       <span slot="footer" class="dialog-footer">
          <el-button @click="is_del = false">取 消</el-button>
          <el-button type="primary" @click="delData" >确 定</el-button>
      </span>
    </el-dialog>
    <!-- 删除菜单提示框 -->
    <el-dialog title="提示" :visible.sync="is_menu_del" width="300px" center>
       <div class="del-dialog-cnt">删除不可恢复，是否确定删除？</div> 
       <span slot="footer" class="dialog-footer">
          <el-button @click="is_menu_del = false">取 消</el-button>
          <el-button type="primary" @click="delMenu" >确 定</el-button>
      </span>
    </el-dialog>

    </div>
</template>

<script>
import AddComboDir from './AddComboDirDialog';
import AddCombo from './AddComboDialog';
import EditCombo from './EditComboDialog';
import EditQty from './EditQtyDialog';
import Add from './AddDialog';
export default {
    name: "DisposalCombination",
    components: {
      AddComboDir,
      AddCombo,
      EditCombo,
      EditQty,
      Add
    },
    props: {
        refresh: {
            type: Boolean,
            required: true
        }
    },
    data() {
        return {
            del_menu_id:0,
            //删除菜单id
            is_menu_del:false,
            //删除菜单窗口
            del_id:0,
            //删除id
            is_del:false,//删除窗口
            //当前组合
            comboId:0,
            //添加列表
            itemList:[],
            //修改列表
            editItem: {},
            //表格高度
            tableHeight: 708,
            //菜单高度
            menuHeight: 667,
            //记录选中这列的数据
            selectThis: false,
            //记录当前节点的数据
            currentNode: {},
            //添加组合目录的窗口
            addComboDirDialog:false,
            //添加组合的窗口
            addComboDialog:false,
            //修改组合的窗口
            editComboDialog:false,
            //修改数量的窗口
            editQtyDialog:false,
            //添加的窗口
            addDialog:false,
            //记录父id
            parentId:0,
            //对应tree的字段
            // add_btn:'none',
            // //添加按钮
            edit_btn:'none',
            //修改按钮
            treeField:{
              id:'id',
              children:'children',
              label:'combo_name'
            },
            //左菜单的数据
            menuData: [
                // {
                //     id: 1,
                //     combo_name: "蛀牙用药组合",
                //     level: 1,
                //     p_id:0,
                //     children: [
                //         {
                //             id: 6,
                //             combo_name: "白+黑",
                //             level: 2,
                //             p_id:1
                //         },
                //         {
                //             id: 8,
                //             combo_name: "必兰麻+保丽净",
                //             level: 2,
                //             p_id:1
                //         }
                //     ]
                // },
                // {
                //     id: 2,
                //     combo_name: "拔牙用药组合",
                //     level: 1,
                //     p_id:0,
                //     children: [
                //         {
                //             id: 7,
                //             combo_name: "西药+中药",
                //             level: 2,
                //             p_id:2
                //         }
                //     ]
                // },
                // {
                //     id: 3,
                //     combo_name: "服用类组合",
                //     level: 1,
                //     p_id:0
                // },
                // {
                //     id: 4,
                //     combo_name: "外敷类组合",
                //     level: 1,
                //     p_id:0
                // },
                // {
                //     id: 5,
                //     combo_name: "日常类组合",
                //     level: 1,
                //     p_id:0
                // }
            ],
            //表单数据
            tableData: [
                // {
                //     id: 1,
                //     disposal_name: "必兰麻",
                //     price: 50.00,
                //     cost_type: "西药费",
                //     remarks: "无",
                //     qty:2,
                //     cost:100.00
                // },
                // {
                //     id: 2,
                //     disposal_name: "保丽净",
                //     price: 99.99,
                //     cost_type: "西药费",
                //     remarks: "无",
                //     qty:1,
                //     cost:99.99
                // },
            ]
        };
    },
    created() {

    },
    mounted() {
        let that = this;
        
        that.$nextTick(() => {
            that.resizeTable();
            that.getMenu();
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
      delCombo(){
          //删除菜单组合
          let that = this;
          if (Object.keys(that.currentNode).length == 0) {
            that.$message.error("请选择一项.");
          }
          else{
            that.del_menu_id = that.currentNode.id;
            that.is_menu_del = true;
            // that.delMenu(that.currentNode.id);
            // alert(that.currentNode.id);
          }


        },
        showEditComboDialog(){
          //显示修改组合窗口
          let that = this;
          if (Object.keys(that.currentNode).length == 0) {
            that.$message.error("请选择一项.");
          }
          else{
            // that.editItem = that.currentNode;
            that.getMenuById(that.currentNode.id);
            // that.editComboDialog = true;
          }


        },
        clickNode() {
            //点击该节点
            // let that = this;
            // that.selectThis = true;
        },
        getMenuTableData(data) {
            //获取点击菜单数据
            let that = this;
            that.selectThis = true;
            that.currentNode = data;
            // console.log(data);
            if(data.level == 1){
                that.edit_btn = 'none';
            }
            if (data.level == 2) {
                that.edit_btn = 'block';
                that.getData(data.id);
            }
        },

        showAddComboDialog(){
          //弹出添加组合窗口
          let that = this;
          if (Object.keys(that.currentNode).length==0) {
             that.$message.error("请选择一个目录.");
          }
          else{
            that.parentId = that.currentNode.level == 1?that.currentNode.id:that.currentNode.p_id;
            // console.log(that.parentId);
            that.addComboDialog = true;
          }
          
          // that.currentNode

        },
        resizeTable() {
            let that = this;
            // console.log(that.$refs.menuContent.clientHeight);
            // if (that.$refs.menuContent.clientHeight != 0) {
                let tableHeight = that.$refs.menuContent.clientHeight - 70;
                that.tableHeight = tableHeight;
                that.menuHeight = tableHeight - 40;
            // }

            // that.$refs.search.clientHeight -
            // 70;
            // console.log(tableHeight);
        },
        start(id) {
            //开始
            alert(id);
        },
        stop(id) {
            //结束
            alert(id);
        },
        edit(editItem) {
            //修改
            // console.log(editItem);
            let that = this;
            that.getById(editItem);
            // that.editItem = editItem;
            // that.editQtyDialog = true;
        },
        showDel(id) {
            //删除
            let that = this;
            that.del_id = id;
            that.is_del = true;
        },
        showAddDialog() {
            let that = this;
            that.getList();
            // that.addDialog = true;
        },
        importData() {
            //导入
        },
        exportData() {
            //导出
        },

        getDataDone() {
            setTimeout(() => {
                that.$emit("update:refresh", false);
            }, 6e3);
        },
        /*****************处理菜单*******************/
        addMenu(data){
            let that = this;
            console.log(data);
            if(data.p_id != 0){
                for (var i = 0, length = that.menuData.length -1 ; i <= length; i++) {
                    if (that.menuData[i].id == data.p_id) {
                        if (typeof that.menuData[i].children != "undefined") {
                            that.menuData[i].children.push(data);
                            // console.log(that.menuData[i]);
                            break;
                        }

                    }

                }

            }
            if(typeof data.p_id == "undefined"){
                that.menuData.push(data);
                console.log(that.menuData[i]);
            }
            
        },
        delMenu(){
          let that = this;
          let id = that.del_menu_id;
          that.$api.disposal_combo_menu.del({id})
          .then(res => {

                if(res.code == 200){
                  for (var i = 0, length = that.menuData.length - 1; i <= length; i++) {
                        // console.log(id);
                        // console.log(that.menuData[i].id);
                         if (that.menuData[i].id == id) {
                             that.menuData.splice(i,1);
                             break;
                         }
                    }
                    that.is_menu_del = false;
                    that.$message({
                        message: res.msg,
                        type: "success",
                        duration: 800
                    });
                    
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
        getMenu(){
            //获取菜单
            let that = this;
            that.$api.disposal_combo_menu.get()
            .then(res => {
               that.menuData = res.data;
            })
            .catch(res => {

            });
        },
        getMenuById(id){
            //获取菜单根据id
            let that = this;
            that.$api.disposal_combo_menu.getById({'id':id})
            .then(res => {
                if (res.code == 200) {
                    that.editItem = res.data;
                    that.editComboDialog = true;
                }else{
                    that.$message.error(
                          res.msg || "操作异常请重试."
                      );
                }
            })
            .catch(res => {

            });
        },
        updateItem(data){
            //更新菜单
            let that = this;

            for (var i = 0, length = that.menuData.length -1 ; i <= length; i++) {

                if (that.menuData[i].id == data.id) {
                    data['children'] = that.menuData[i].children;
                    that.$set(that.menuData,i,data);//修改值
                    break;

                }
                else {

                    for (var j = 0, c_length = that.menuData[i].children.length -1 ; j <= c_length; j++){
                        
                        if (that.menuData[i].children[j].id == data.id) {
                            that.menuData[i].children[j] = data;
                            that.$set(that.menuData[i].children,j,data);
                            break;
                        }
                    }
                }
            }

        },
        /*******************处理数据********************************/
        getList(){
            //获取列表数据
            //获取数据
            let that = this;
            let id = that.currentNode.id;
            that.$api.disposal_combo.getList({'id':id})
            .then(res => {
               that.itemList = res.data;
               that.comboId = id;
               // console.log(that.itemList);
               that.addDialog = true;
            })
            .catch(res => {

            });
        },
        getData(id){
            //获取数据
            let that = this;
            that.$api.disposal_combo.get({'combo_id':id})
            .then(res => {
               that.tableData = res.data;
            })
            .catch(res => {

            });
        },
        getById(parms){
            let that = this;
            let commit = {};
                commit.disposal_id = parms.disposal_id;
                commit.combo_id = parms.combo_id;
            that.$api.disposal_combo.getById(commit)
            .then(res => {
                if (res.code == 200) {
                    parms.combo_qty = res.data.combo_qty;
                    that.editItem = parms;
                    that.editQtyDialog = true;
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
                if (that.tableData[i].disposal_id == data.disposal_id) {
                     that.$set(that.tableData,i,data);
                     break;
                }
            }
        },
        flushData(){
            //刷新数据
            let that = this;
            that.getData(that.comboId);
        },
        delData(){
            //删除数据
          let that = this;
          let id = that.del_id;
          that.$api.disposal_combo.del({id})
          .then(res => {

                if(res.code == 200){
                  for (var i = 0, length = that.tableData.length - 1; i <= length; i++) {

                         if (that.tableData[i].disposal_id == id) {
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
};
</script>
<style lang="less" scoped>
//导入全局的颜色
@import "~@css/var";
/deep/ .el-tree-node:focus > .el-tree-node__content {
    background-color: @linght-background-color !important;
}

/deep/ .el-tree-node__content:hover {
    background-color: @linght-background-color !important;
}

/deep/
    .el-table--striped
    .el-table__body
    tr.el-table__row--striped.current-row
    td,
/deep/ .el-table__body tr.current-row > td {
    background-color: @linght-background-color;
}

.content {
    background: white;
    height: 100%;

    /deep/.el-tree--highlight-current
        .el-tree-node.is-current
        > .el-tree-node__content {
        background-color: @linght-background-color;
    }
}
.data_content {
    border: 1px solid #dbdbdb;
    margin-bottom: 10px;
}
.left {
    border: 1px solid #dbdbdb;
    height: 100%;
    width: 250px;
    /*height: 800px;*/

    .title {
        padding-top: 10px;
        padding-bottom: 10px;
        padding-left: 10px;
        font-size: 18px;
        font-weight: bold;
        color: @color;
    }

    .setting {
        float: right;
        /*padding-right: 10px;*/
    }

    .combo_btn {
        margin-top: 12px;
        font-size: 20px;
        cursor: pointer;
        margin-left: 10px;
        margin-right: 8px;
    }

    .menu_content {
        font-size: 14px;
        /deep/ .el-table--enable-row-hover .el-table__body tr:hover > td {
            background-color: @linght-background-color;
            cursor: pointer;
        }
    }
}
.right {
    /*border: 1px solid #dbdbdb;*/
    /*height: 800px;*/
    padding: 0 0 0 10px;
    height: 100%;
    /deep/ .el-table--enable-row-hover .el-table__body tr:hover > td {
        background-color: @linght-background-color;
    }
}
.btn_content {
    /*padding: 10px 0 10px 0;*/
    /*border-bottom: 1px solid #e3e3e3;*/
    height: 40px;
    /*width: 90%;*/
}
</style>