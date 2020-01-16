<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">{{ $title }}</h3>
  </div>
  <div class="panel-body">
    <table class="table table-bordered table-striped">
        <tr>
            @foreach ($headers as $header)
                <th>{{ $header }}</th>
            @endforeach
            <th>操作</th>
        </tr>
        @foreach ($data as $items)
            <tr>
                @foreach ($items as $key => $item)
                    @if ($key === 'ip')
                    <td><b>@join($item)</b></td>
                    @else
                    <td>{{ $item }}</td>
                    @endif
                @endforeach
                <td class="text-center">
                  @includeIf('show.widgets.action',['id' => $items['id']])
                    <button type="button" class="btn btn-primary" style="margin-top: 5px;" data-business="{{ $items['business_number'] }}" data-toggle="modal" data-target="#underIpModal">
                     IP资源
                    </button>
                </td>
            </tr>
        @endforeach
    </table>
  </div>
</div>

<!-- 批量IP下架 -->
<div class="modal fade" id="underIpModal" tabindex="-1" role="dialog" aria-labelledby="underIpModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="underIpModalLabel">下架IP</h4>
      </div>
      <div class="modal-body">
        <table id="data">
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary" id="underPost">下架</button>
      </div>
    </div>
  </div>
</div>
<script>
  $(function() {
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $("#underIpModal").on('shown.bs.modal', function (e) {
      // do something...
      var self = this;
      $(this).find("#underPost").off("click");
      $(this).find("#underPost").click(function() {
        var remove_reason = prompt("请简单说明一下下架理由,取消将不会提交申请,不需要填写请直接按确定");
        if(remove_reason==null) {
          return ;
        }
        var request_all = $(self).find("#data").bootstrapTable("getSelections").map(function(item) {
          return new Promise((resolve, reject) => {
            $.post("/tz_admin/under/apply_under",{
              order_sn: item.order_sn,
              remove_reason: remove_reason,
              type: 2
            },resolve).fail(reject);
          })
        });
        Promise.all(request_all).then(function(posts) {
          alert("一共下架成功："+posts.length+"个IP");
        }).catch(function(reason) {
          console.error(reason);
        });
      });
      $(this).find("#data").bootstrapTable({
        locale: "zh-CN",
        columns: [
          {
            checkbox: true
          },
          {
            field: 'order_sn',
            title: '资源单号',
            class: 'text-center'
          },
          {
            field: 'machine_sn',
            title: '资源编号',
            class: 'text-center'
          },
          {
            field: 'resource',
            title: '资源详情',
            class: 'text-center'
          },
          {
            field: 'end_time',
            title: '到期时间',
            class: 'text-center'
          }
        ],
        url: "/tz_admin/under/batch_getip",
        responseHandler: function(res) {
          if(res.code==1) {
            return res.data;
          } else {
            console.warn(res.msg);
            return [];
          }
        },
        queryParams: function(params) {
          params.business_sn = $(e.relatedTarget).attr("data-business");
          return params
        }
      });
      
    });
  });
</script>
