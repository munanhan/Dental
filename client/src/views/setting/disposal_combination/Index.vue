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
                                    prop="cost_type"
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
                                    prop="qty"
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
                                                @click.stop="del(scope.row.id)"
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
        >
        </edit-qty>
        <!-- 添加 -->
        <add
          :show.sync="addDialog"
        >
        </add>
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
                {
                    id: 1,
                    disposal_name: "必兰麻",
                    price: 50.00,
                    cost_type: "西药费",
                    remarks: "无",
                    qty:2,
                    cost:100.00
                },
                {
                    id: 2,
                    disposal_name: "保丽净",
                    price: 99.99,
                    cost_type: "西药费",
                    remarks: "无",
                    qty:1,
                    cost:99.99
                },
            ]
        };
    },
    created() {

    },
    mounted() {
        let that = this;
        that.getMenu();
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
                // that.getMenu();
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
            that.delMenu(that.currentNode.id);
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
            console.log(that.$refs.menuContent.clientHeight);
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
            let that = this;
            that.editItem = editItem;
            that.editQtyDialog = true;
        },
        del(id) {
            //删除
            alert(id);
        },
        showAddDialog() {
            let that = this;
            that.addDialog = true;
        },
        importData() {
            //导入
        },
        exportData() {
            //导出
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
        },
        /*****************处理菜单*******************/
        addMenu(data){
            let that = this;
            // console.log(data);
            if(data.p_id != 0){
                for (var i = 0, length = that.menuData.length -1 ; i <= length; i++) {
                    if (that.menuData[i].id == data.p_id) {
                        that.menuData[i].children.push(data);
                        break;
                    }
                }

            }
            else{
                that.menuData.push(data);
            }
            
        },
        delMenu(id){
          let that = this;
           
          that.$api.disposal_combo_menu.del({id})
          .then(res => {

                if(res.code == 200){
                  for (var i = 0, length = that.menuData.length - 1; i <= length; i++) {
                        // console.log(id);
                        console.log(that.menuData[i].id);
                         if (that.menuData[i].id == id) {
                             that.menuData.splice(i,1);
                             break;
                         }
                    }

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
            // console.log(data);
            for (var i = 0, length = that.menuData.length -1 ; i <= length; i++) {
                if (that.menuData[i].id == data.id) {
                    that.$set(that.menuData,i,data);//修改值
                    break;
                }
                if (typeof that.menuData[i].children!="undefined") {

                    for (var j = 0, length = that.menuData[i].children.length -1 ; j <= length; j++){
                        
                        if (that.menuData[i].children[j].id == data.id) {
                            that.menuData[i].children[j] = data;
                            that.$set(that.menuData[i].children,j,data);
                            break;
                        }
                    }
                }
            }

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