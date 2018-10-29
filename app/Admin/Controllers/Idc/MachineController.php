<?php

namespace App\Admin\Controllers\Idc;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Models\Idc\MachineModel;
use App\Admin\Requests\Idc\MachineRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * 机器的相关操作接口
 */
class MachineController extends Controller
{
    use ModelForm;

    /**
     * 根据传递的条件查找对应的机器
     * @return [type] [description]
     */
    public function showMachine(Request $request){
		$where = $request->only(['business_type']);
    	$showmachine = new MachineModel();
    	$return = $showmachine->showMachine($where);
    	return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
    	
    	
    }

    /**
     * 新增机器信息
     * @param  MachineRequest $request 字段验证
     * @return json                  将相关的状态和提示信息返回
     */
    public function insertMachine(MachineRequest $request){
    	
		$data = $request->only(['machine_num','cpu','memory','harddisk','cabinet','ip_id','machineroom','bandwidth','protect','loginname','loginpass','machine_type','used_status','machine_status','business_type','machine_note']);
		$insertmachine = new MachineModel();
		$return = $insertmachine->insertMachine($data);
		return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
    }

    /**
     * 修改机器的信息
     * @param  MachineRequest $request 字段验证
     * @return json                  相关的提示信息和状态返回
     */
    public function editMachine(MachineRequest $request){
		$editdata = $request->only(['id','machine_num','cpu','memory','harddisk','cabinet','ip_id','machineroom','bandwidth','protect','loginname','loginpass','machine_type','used_status','machine_status','business_type','machine_note']);
		$editmachine = new MachineModel();
		$return = $editmachine->editMachine($editdata);
		return tz_ajax_echo($return,$return['msg'],$return['code']);
    }

    /**
     * 删除对应的机器信息
     * @param  Request $request [description]
     * @return json           相关的信息提示和状态返回
     */
    public function deleteMachine(Request $request){
    		$id = $request->get('delete_id');
    		$deletemachine = new MachineModel();
    		$result = $deletemachine->deleteMachine($id);
    		return tz_ajax_echo($result,$result['msg'],$result['code']);
    }

    /**
     * 查找机房的接口
     * @return json 返回机房的相关的数据
     */
    public function machineroom(){
    	$machineroom = new MachineModel();
    	$result = $machineroom->machineroom();
    	return tz_ajax_echo($result['data'],$result['msg'],$result['code']);
    }

    /**
     * 查找对应机房的机柜
     * @param  Request $request 机房的id
     * @return json           对应机房的机柜的数据
     */
    public function cabinets(Request $request){
    	
		$roomid = $request->only(['roomid','business_type']);
		$cabinet = new MachineModel();
		$result = $cabinet->cabinets($roomid);
		return tz_ajax_echo($result['data'],$result['msg'],$result['code']);
    	
    }

    /**
     * 查找对应机房的IP地址数据
     * @param  Request $request 机房的id和IP所属的运营商
     * @return json           对应机房的IP信息
     */
    public function ips(Request $request){
        
		$data = $request->only(['roomid','ip_company','id']);
		$ips = new MachineModel();
		$result = $ips->ips($data);
		return tz_ajax_echo($result['data'],$result['msg'],$result['code']);
    	
    }

    /**
     * 下载excel模板
     * @return [type] [description]
     */
    public function excelTemplate(){
        $spreadsheet = new Spreadsheet();
        $worksheet = $spreadsheet->getActiveSheet();
        $worksheet->setTitle('机器批量导入表格');
        $worksheet->setCellValueByColumnAndRow(1, 1, '机器批量导入表格(此为测试功能)');
        $row_value = ['机器编号','CPU','内存','硬盘','机房','机柜','IP','带宽(M)','防护(G)','登录名','登录密码','机器型号','使用状态','业务类型','上下架','备注'];//填写的字段
        $row = $worksheet->fromArray($row_value,NULL,'A4');//分配字段从A4开始填写（横向）
        $highest_row = $worksheet->getHighestRow();//总行数
        $highest_colum = $worksheet->getHighestColumn();//总列数
        //标题样式
        $title_font = [
            'font' => [
                'bold' => true,//加粗
                'size' => '24px',//字体大小
            ],
            'alignment' => [//内容居中
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];
        $worksheet->mergeCells('A1:'.$highest_colum.'1')->getStyle('A1:'.$highest_colum.'1')->applyFromArray($title_font);//设置标题样式
        //说明内容
        $worksheet->getCell('A2')->setValue("填写说明:填写机房时请参照右边的机房信息,填写对应id(例如A机房的id为1,此时填1);填写机柜时请填写对应机房的机柜id(例如A机房的B机柜的id为2,此时填2);填写IP时请填写对应机房的IP的id(例如:A机房的192.168.1.13的id为3,此时填3);填写防护(单位:G)和带宽(单位:M)只须填写数字即可,填写使用状态,业务类型,上下架时请参照右边对应所需的数字,以上字段请参照右边的对照表");
        $worksheet->getStyle('A2')->getFont()->applyFromArray(['bold'=>TRUE,'size'=>'12px']);//说明内容样式
        $worksheet->getRowDimension('2')->setRowHeight(31);//说明内容行高
        $worksheet->mergeCells('A2:'.$highest_colum.'3')->getStyle('A2:'.$highest_colum.'3')->getAlignment()->setWrapText(true);//说明内容自动换行
        //设置字段宽度
        for($i='A';$i<=$highest_colum;$i++){
            $worksheet->getColumnDimension($i)->setWidth(12);
        }
        $colum = ++$highest_colum;//字段名的列数 
        //列名样式
        $row_font = [
            'font' => [
                'size' => '11px',//字体大小
            ],
            'alignment' => [//内容居中
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];
        $colum = ++$highest_colum;//说明字段的开始列数
        $note_value = ['机房(id-名称)','机柜(所属机房-id-机柜编号(适用范围))','IP(所属机房-id-IP详情)','使用状态','业务类型','上下架'];//说明字段
        $row_note = $worksheet->fromArray($note_value,NULL,$colum.'4');//分配说明字段（横向）
        $highest_colum = $worksheet->getHighestColumn();//总的列数
        $row->getStyle('A4:'.$highest_colum.'4')->applyFromArray($row_font);//设置字段样式
        //设置说明字段样式
        for($i=$colum;$i<=$highest_colum;$i++){
            $worksheet->getColumnDimension($i)->setWidth(30);
        }
        $worksheet->mergeCells($colum.'1:'.$highest_colum.'3')->getStyle($colum.'1:'.$highest_colum.'3')->applyFromArray($title_font);//合并说明字段
        $worksheet->getCell($colum.'1')->setValue('字段填写对照表(注意:由于数据的随时变化,为了准确性,每次批量前都请重新下载模板)');
        $model = new MachineModel();
        /**
         * 机房数据
         * @var [type]
         */
        $machineroom = $model->machineRooms();
        $machineroom = array_chunk($machineroom,1);
        $worksheet->fromArray($machineroom,NULL,$colum.'5');
        /**
         * 机柜数据
         * @var [type]
         */
        $cabinet = $model->cabinet();
        $cabinet = array_chunk($cabinet,1);
        $worksheet->fromArray($cabinet,NULL,++$colum.'5');
        /**
         * IP数据
         * @var [type]
         */
        $ips = $model->ip();
        $ips = array_chunk($ips,1);
        $worksheet->fromArray($ips,NULL,++$colum.'5');
        /**
         * 使用状态
         * @var [type]
         */
        $use = ['0--未使用','1--使用中','2--锁定'];
        $use = array_chunk($use,1);
        $worksheet->fromArray($use,NULL,++$colum.'5');
        /**
         * 业务类型
         * @var [type]
         */
        $business = ['1--租用','2--托管','3--备用'];
        $business = array_chunk($business,1);
        $worksheet->fromArray($business,NULL,++$colum.'5');
        /**
         * 上下架
         * @var [type]
         */
        $machine_status = ['0--上架','1--下架'];
        $machine_status = array_chunk($machine_status,1);
        $worksheet->fromArray($machine_status,NULL,++$colum.'5');
        /**
         * 下载模板
         * @var [type]
         */
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = '机器批量导入表格模板.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        $spa->disconnectWorksheets();
        unset($spa);
        exit;
    }

    /**
     * 处理excel批量添加机器
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function handleExcel(Request $request){
        $file = $request->file('handle_excel');
        if(!$file){
            $return['data'] = '';
            $return['code'] = 0;
            $return['msg'] = '请上传文件!';
        }
        if($file->getClientOriginalExtension() != 'xlsx'){//判断上传文件的后缀
            $return['data'] = '';
            $return['code'] = 0;
            $return['msg'] = '仅支持类型为xlsx的文件!';
        }
        $excel = new MachineModel();
        $return = $excel->handleExcel($file);
        return tz_ajax_echo($return['data'],$return['msg'],$return['code']);
    }

}
