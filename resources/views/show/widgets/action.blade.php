<div class="btn-group" role="group" aria-label="resource list">
    @php
        $GLOBALS['find_id'] = $id;
        $data = $result;
        $item = array_filter($data,function($item) {
            return $item['id'] == $GLOBALS['find_id'];
        });
        $resultLink = '';
        if(count($item) > 0) {
            $resultData = $item[array_keys($item)[0]];
            $resultLink = "/tz_admin/show/business/order?client_id=".$resultData['client_id']."&client_name=".$resultData['client_name']."&business_number=".$resultData['business_number']."&machine_number=".$resultData['machine_number']."&machineroom_id=".$resultData['machineroom_id'];
        }

    @endphp
    <a type="button" class="btn btn-default" href="{{ $resultLink }}" role="button">资源列表</a>
</div>
