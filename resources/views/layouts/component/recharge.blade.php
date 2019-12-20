<!-- 充值 -->
<div class="modal fade" id="rechargeModal" tabindex="-1" role="dialog" aria-labelledby="rechargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content border-0">
      <div class="modal-header border-0 py-4 px-4">
        <h5 class="modal-title font-heavy" id="rechargeModalLabel">账户充值</h5>
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> -->
      </div>
      <div class="modal-body py-0 px-4">
        <p class="font-medium recharge-item mb-3">
            <span class="recharge-name mr-4">账户余额</span>
            <span class="recharge-value"><strong class="mr-1">0.00</strong>元</span>
        </p>
        <p class="font-medium recharge-item mb-3">
            <span class="recharge-name mr-4">充值金额</span>
            <span class="recharge-value">
               <input class="rounded mr-1" type="text" /> 元
            </span>
        </p>
        <div class="font-medium recharge-item d-flex pb-4 border-bottom">
            <span class="recharge-name mr-4">支付平台</span>
            <div class="select-type-pay">
                <ul class="d-flex">
                    <li class="align-self-center mr-3 border rounded">
                        <img src="{{ asset("/user_assets/html_img/alipay.png") }}" alt="支付宝"/>
                    </li>
                    <li class="align-self-center border rounded">
                        <img src="{{ asset("/user_assets/html_img/timg.png") }}" alt="微信"/>
                    </li>
                </ul>
                <p class="recharge-item recharge-value my-0 mt-2">请选择支付平台</p>
            </div>
        </div>
      </div>
      <div class="modal-footer border-0 px-4 pb-4 mb-2">
        <button type="button" class="btn btn-secondary font-regular rounded" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary font-regular rounded">充值</button>
      </div>
    </div>
  </div>
</div>