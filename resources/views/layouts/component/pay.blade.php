<!-- 支付 -->
<div class="modal fade" id="payModal" tabindex="-1" role="dialog" aria-labelledby="payModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content border-0">
      <div class="modal-header border-0 py-4 px-4">
        <h5 class="modal-title font-heavy" id="payModalLabel">支付<span class="ml-2 pl-2">服务器</span> </h5>
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> -->
      </div>
      <div class="modal-body py-0 px-4">
        <select name="business" tabindex="1" multiple size="20">
            <option value="20180930181438.8473">服务器-20180930181438.8473</option>
            <option value="20180930181438.8473">服务器-20180930181438.8473</option>
            <option value="20180930181438.8473">服务器-20180930181438.8473</option>
            <option value="20180930181438.8473">服务器-20180930181438.8473</option>
            <option value="20180930181438.8473">服务器-20180930181438.8473</option>
            <option value="20180930181438.8473">服务器-20180930181438.8473</option>
        </select>
       
        <div class="price d-flex mt-5">
          <span class="font-regular align-self-center mr-3">需要支付</span>
          <span class="amount">888.00</span>
        </div>
        <div class="balance d-flex mt-2 border-bottom pb-4"> 
          <span class="font-regular align-self-center mr-3">账户余额</span>
          <p class="amount font-medium align-self-center my-0">
            0&nbsp;元
            <span class="tip font-regular">(余额不足！请及时充值)</span>
          </p>
        </div>
      </div>
      <div class="modal-footer border-0 px-4 pb-4 mt-1 pt-3 mb-2">
        <button type="button" class="btn btn-secondary font-regular rounded" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary font-regular rounded" data-toggle="modal" data-target="#rechargeModal">充值</button>
        <button type="button" id="postPay" class="btn bg-danger font-regular rounded">支付</button>
      </div>
    </div>
  </div>
</div>