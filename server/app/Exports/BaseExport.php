<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Events\AfterSheet;    // 在工作表流程结束时会引发事件
use Maatwebsite\Excel\Concerns\WithEvents;     // 自动注册事件监听器

class BaseExport implements FromArray,WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $data = [];
    //数据源
    protected $width = [];
    //表头宽度

    public function __construct($data,$width = []){
    	$this->data = $data;
    	$this->width = $width;
    }
    public function array():array
    {
        return $this->data;
    }

   public function registerEvents(): array
   {
       return [
           AfterSheet::class => function(AfterSheet $event) {
           	// 合并单元格
               // $event->sheet->getDelegate()->setMergeCells(['A1:O1', 'A2:C2', 'D2:O2']);
               // 冻结窗格
               // $event->sheet->getDelegate()->freezePane('A4');

           	   $data = $this->data;
           	   $list = $this->list();
               // 设置单元格内容居中
               $event->sheet->getDelegate()
               				->getStyle('A1:'.$list[count($data[0])].count($data))
               				->getAlignment()
               				->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

               // 定义列宽度\			
               $get_width = function() use($data,$list){
               		$widths = [];

               		$length = count($data[0]);
               		for ($i=0; $i < $length ; $i++) { 
               			//自动计算宽度
               			$widths[$list[$i]] = strlen($data[0][$i])*1.5;
               		}
               		return $widths;
               };

               $widths = empty($this->width)?$get_width():array_merge($get_width(),$this->width);

               foreach ($widths as $k => $v) {
               	// 设置列宽度
                   $event->sheet->getDelegate()->getColumnDimension($k)->setWidth($v);
               }
               // 其他样式需求（设置边框，背景色等）处理扩展中给出的宏，也可以自定义宏来实现，详情见官网说明
               
           },
       ];
   }

   public function list(){
   	//集合
   		return [ 'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z' ];
   }

}
