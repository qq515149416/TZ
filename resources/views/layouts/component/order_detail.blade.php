<!-- 订单概要 -->
<div class="modal fade" id="orderDetailModal" tabindex="-1" role="dialog" aria-labelledby="orderDetailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content border-0">
      <div class="modal-header border-0 py-4 px-4">
        <h5 class="modal-title font-heavy" id="orderDetailModalLabel">订单概要</h5>
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> -->
      </div>
      <div class="modal-body py-0 px-4">
        <div class="container order-info mt-2">
          <div class="row font-medium">
            <div class="col">
              <span class="attr mr-4">
                订单编号
              </span>
              <span class="val">
                2019073098117335
              </span>
            </div>
            <div class="col">
              <span class="attr mr-4">
                订单类型
              </span>
              <span class="val">
                购买服务器
              </span>
            </div>
            <div class="w-100 mt-1 mb-4"></div>
            <div class="col">
              <span class="attr mr-4">创建时间</span>
              <span class="val">2019-07-30 14:31:20</span>
            </div>
            <div class="col">
              <span class="attr mr-4">支付时间</span>
              <span class="val">2019-07-30 14:31:20</span>
            </div>
          </div>
        </div>
        <table 
        class="order-business mt-5" 
        data-toggle="table"
        data-mobile-responsive="true"
        data-check-on-init="true">
          <thead class="border-bottom">
            <tr>
              <th class="border-0 font-heavy">产品</th>
              <th class="border-0 font-heavy">数量</th>
              <th class="border-0 font-heavy">具体配置</th>
              <th class="border-0 font-heavy">单价</th>
              <th class="border-0 font-heavy">金额</th>
            </tr>
          </thead>
          <tbody>
            <tr class="border-bottom">
              <td class="border-0 font-regular">服务器-20190101000000.0000</td>
              <td class="border-0 font-regular">1</td>
              <td class="border-0 font-regular">CPU:0核  内存：0G  带宽3M  防御值0G</td>
              <td class="border-0 font-regular">￥123.00/月</td>
              <td class="border-0 font-regular">￥123.00</td>
            </tr>
          </tbody>
      </table>
      </div>
      <div class="modal-footer border-0 px-4 pb-4 mb-2 justify-content-sm-between">
        <!-- <button type="button" class="btn btn-secondary font-regular rounded" data-dismiss="modal">取消</button> -->
        <div class="d-flex align-items-center order-info">
          <p class="mb-0 mr-5">
            <span class="attr mr-2">应付金额</span>
            <span class="val">￥888.00</span>
          </p>
          <p class="mb-0">
            <span class="attr mr-2">实付金额</span>
            <span class="val">￥888.00</span>
          </p>
        </div>
        <button type="button" class="btn btn-primary font-regular rounded" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>