<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>添加机房</title>

    <!-- Bootstrap -->
    <link href="/css/bootstrap.css" rel="stylesheet" />

    <!-- HTML5 shim 和 Respond.js 是为了让 IE8 支持 HTML5 元素和媒体查询（media queries）功能 -->
    <!-- 警告：通过 file:// 协议（就是直接将 html 页面拖拽到浏览器中）访问页面时 Respond.js 不起作用 -->
    <!--[if lt IE 9]>
      <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
        .head {
            margin: 5px 0;
        }
        .mt5 {
            padding: 5px 0;
        }
    </style>
  </head>
  <body>
    <div class="container">
        <div class="head">
            <!-- 添加机房 -->
            <button type="button" class="btn btn-primary" data-type="add" data-toggle="modal" data-target="#room">添加机房</button>
        </div>
        <table class="table table-bordered table-striped" id="room_data">
            <thead>
                <tr>
                    <th>#</th>
                    <th>机房编号</th>
                    <th>机房名称</th>
                    <th>机房序号</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>1</td>
                    <td>测试机房</td>
                    <td>1000</td>
                    <td>
                        <button type="button" class="btn btn-primary" data-type="edit" data-toggle="modal" data-target="#room">修改</button>
                        <button type="button" class="btn btn-primary">删除</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- 机房操作 -->
    <div class="modal fade" id="room" tabindex="-1" role="dialog" aria-labelledby="roomModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="roomModalLabel">添加机房</h4>
            </div>
            <div class="modal-body">
                <div class="mt5">
                    <div class="input-group">
                        <span class="input-group-addon" id="room_number">机房编号</span>
                        <input type="text" class="form-control" placeholder="机房编号" aria-describedby="room_number">
                    </div>
                </div>
                <div class="mt5">
                    <div class="input-group">
                        <span class="input-group-addon" id="room_name">机房名称</span>
                        <input type="text" class="form-control" placeholder="机房名称" aria-describedby="room_name">
                    </div>
                </div>
                <div class="mt5">
                    <div class="input-group mt5">
                        <span class="input-group-addon" id="room_order">机房序号</span>
                        <input type="text" class="form-control" placeholder="机房序号" aria-describedby="room_order">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
              <button type="button" class="btn btn-primary post">提交</button>
            </div>
          </div>
        </div>
      </div>

    <!-- jQuery (Bootstrap 的所有 JavaScript 插件都依赖 jQuery，所以必须放在前边) -->
    <script src="/js/jquery.min.js"></script>
    <!-- 加载 Bootstrap 的所有 JavaScript 插件。你也可以根据需要只加载单个插件。 -->
    <script src="/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $(function() {
            var room_data = [
                {
                    room_number: "1",
                    room_name: "西安机房",
                    room_order: "1000"
                }
            ];
            $.get("/tz_admin/machine_room/showByAjax",function(data) {
                if(data.code==1) {
                    room_data = data.data.map(function(item) {
                        return {
                            room_number: item.room_id,
                            room_name: item.room_name,
                            room_order: "100"
                        };
                    });
                    rendData("room_data",room_data);
                }
            });
            
            $("#room_data").on("click",".delRoomdata",function() {
                var id = ($(this).attr("data-id") - 1);
                room_data.splice(id,1);
                rendData("room_data",room_data);
            });
            $('#room').on('shown.bs.modal', function (e) {
                var self = $(this);
                var type = $(e.relatedTarget).attr("data-type");
                if(type=="add") {
                    $(this).find("h4").html("添加机房");
                    setParam($(this),{});
                }else {
                    $(this).find("h4").html("修改机房");
                    var editData = {};
                    // setParam($(this),JSON.parse($(e.relatedTarget).attr("data-roomdata")));
                    $(e.relatedTarget).attr("data-roomdata").split("|").forEach(function(item) {
                        editData[item.split(":")[0]] = item.split(":")[1];
                    });
                    setParam($(this),editData);
                }
                $(this).find(".post").off("click");
                $(this).find(".post").click(function() {
                    // console.log(getParam(self));
                    if(type=="add") {
                        $.post("/tz_admin/machine_room/storeByAjax",{
                            room_id: getParam(self).room_number,
                            room_name: getParam(self).room_name
                        },function(data) {
                            console.log(data);
                            if(data.code==1) {
                                room_data.push(getParam(self));
                                rendData("room_data",room_data);
                                self.modal('hide');
                            } else {
                                alert(data.msg);
                            }
                        });
                        
                    }
                    if(type=="edit") {
                        var currIndex = -1;
                        var newData = {};
                        room_data.forEach(function(item,index) {
                            if(item.room_number==editData.room_number) {
                                currIndex = index;
                                newData = getParam(self);
                            }
                        });
                        room_data[currIndex] = newData;
                        rendData("room_data",room_data);
                        self.modal('hide');
                    }
                });

            });
        });
        function rendData(id,data) {
            var renderStr = "";
            data.forEach(function(item,index) {
                renderStr += '<tr>\
                    <td>'+(++index)+'</td>\
                    <td>'+item.room_number+'</td>\
                    <td>'+item.room_name+'</td>\
                    <td>'+item.room_order+'</td>\
                    <td>\
                        <button type="button" class="btn btn-primary" data-roomdata="id:'+index+'|room_number:'+item.room_number+'|room_name:'+item.room_name+'|room_order:'+item.room_order+'" data-type="edit" data-toggle="modal" data-target="#room">修改</button>\
                        <button type="button" class="btn btn-primary delRoomdata" data-id="'+index+'">删除</button>\
                    </td>\
                </tr>';
            });
            $("#"+id).find("tbody").empty().html(renderStr);
        }
        function setParam(container,data) {
            if(data.room_number) {
                container.find("input[aria-describedby='room_number']").val(data.room_number);
            } else {
                container.find("input[aria-describedby='room_number']").val("");
            }
            if(data.room_name) {
                container.find("input[aria-describedby='room_name']").val(data.room_name);
            } else {
                container.find("input[aria-describedby='room_name']").val("");
            }
            if(data.room_order) {
                container.find("input[aria-describedby='room_order']").val(data.room_order);
            } else {
                container.find("input[aria-describedby='room_order']").val("");
            }
        }
        function getParam(container,rule) {
            var param = {};
            var rule = rule || {};
            if(container.find("input[aria-describedby='room_number']").val()) {
                param.room_number = container.find("input[aria-describedby='room_number']").val();
            } else {
                if(rule["room_number"]) {
                    alert("room_number参数不能为空");
                    throw new Error("room_number参数不能为空");
                }
            }
            if(container.find("input[aria-describedby='room_name']").val()) {
                param.room_name = container.find("input[aria-describedby='room_name']").val();
            } else {
                if(rule["room_name"]) {
                    alert("room_name参数不能为空");
                    throw new Error("room_name参数不能为空");
                }
            }
            if(container.find("input[aria-describedby='room_order']").val()) {
                param.room_order = container.find("input[aria-describedby='room_order']").val();
            } else {
                if(rule["room_order"]) {
                    alert("room_order参数不能为空");
                    throw new Error("room_order参数不能为空");
                }
            }
            return param;
        }
    </script>
  </body>
</html>