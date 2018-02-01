<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Monthly;
use App\Quarterly;
use App\Yearly;

class FusionCharts extends Controller
{
    public function home(){

    	$quarterly = DB::table('quarterlies')
	        					->where('Year', '=', 2011 )
                				->get();

    	$yearly = yearly::get();

    	$arrData = array(
        	"chart" => array(
	            "caption" => "Yearly Sales - KFC",
	            "xAxisName"=> "Year",
	            "yAxisName"=> "Sales",
	            "paletteColors"=> "#876EA1",
                "useplotgradientcolor"=> "0",
                "plotBorderAlpha"=> "0",
                "bgColor"=> "#FFFFFFF",
                "canvasBgColor"=> "#FFFFFF",
                "showValues"=>"1",
                "showCanvasBorder"=> "0",
                "showBorder"=> "0",
                "divLineColor"=> "#DCDCDC",
                "alternateHGridColor"=> "#DCDCDC",
                "labelDisplay"=> "auto",
                "baseFont"=> "Assistant",
                "baseFontColor"=> "#153957",
                "outCnvBaseFont"=> "Assistant",
                "outCnvBaseFontColor"=> "#8A8A8A",
                "baseFontSize"=> "13",
                "outCnvBaseFontSize"=> "13",
                "yAxisMinValue"=>"40",
                "labelFontColor"=> "#8A8A8A",
                "captionFontColor"=> "#153957",
                "captionFontBold"=> "1",
                "captionFontSize"=> "20",
                "subCaptionFontColor"=> "#153957",
                "subCaptionfontSize"=> "17",
                "subCaptionFontBold"=> "0",
                "captionPadding"=> "20",
                "valueFontBold"=> "0",
                "showAxisLines"=> "1",
                "yAxisLineColor"=> "#DCDCDC",
                "xAxisLineColor"=> "#DCDCDC",
                "xAxisLineAlpha"=> "15",
                "yAxisLineAlpha"=> "15",
                "toolTipPadding"=> "7",
                "toolTipBorderColor"=> "#DCDCDC",
                "toolTipBorderThickness"=> "0",
                "toolTipBorderRadius"=> "2",
                "showShadow"=> "0",
                "toolTipBgColor"=> "#153957",
                "theme"=> "fint"
	            
	        )
    	);
    
    	//Create an array for Parent Chart.
    	$arrData["data"] = array();
    	$arrData["linkeddata"] = array();
    	$year = array();
    
	    // Push data in array.
	    foreach($yearly as $data){
	    	array_push($year, $data->Year);
	        array_push($arrData["data"], array(
	            "label" => $data->Year,
	            "value" => $data->Sales,
	            "link"  => "newchart-json-" . $data->Year
	        ));
	    }

	    foreach ($year as $row) {

	    	$values = array();
	    	$quarterly = DB::table('quarterlies')
	        					->where('Year', '=', $row )
                				->get();

            foreach ($quarterly as $data) {
            	# code...
            	array_push($values, array(

            		"label"=> $data->Quarter,
            		"Value"=> $data->Sales

            	));

            }

	    	 array_push($arrData["linkeddata"], array(
				//Create the data for the monthly charts for each quarter
				"id" => $row,
				"linkedchart" => array(
					"chart" => array(
						//Create dynamic caption based on the year and quarter
						"caption" => "Quarterly Sales - KFC for Year $row",
						"xAxisName"=> "Month",
						"yAxisName"=> "Sales",
						"paletteColors"=> "#876EA1",
		                "useplotgradientcolor"=> "0",
		                "plotBorderAlpha"=> "0",
		                "bgColor"=> "#FFFFFFF",
		                "canvasBgColor"=> "#FFFFFF",
		                "showValues"=>"1",
		                "showCanvasBorder"=> "0",
		                "showBorder"=> "0",
		                "divLineColor"=> "#DCDCDC",
		                "alternateHGridColor"=> "#DCDCDC",
		                "labelDisplay"=> "auto",
		                "baseFont"=> "Assistant",
		                "baseFontColor"=> "#153957",
		                "outCnvBaseFont"=> "Assistant",
		                "outCnvBaseFontColor"=> "#8A8A8A",
		                "baseFontSize"=> "13",
		                "outCnvBaseFontSize"=> "13",
		                "yAxisMinValue"=>"40",
		                "labelFontColor"=> "#8A8A8A",
		                "captionFontColor"=> "#153957",
		                "captionFontBold"=> "1",
		                "captionFontSize"=> "20",
		                "subCaptionFontColor"=> "#153957",
		                "subCaptionfontSize"=> "17",
		                "subCaptionFontBold"=> "0",
		                "captionPadding"=> "20",
		                "valueFontBold"=> "0",
		                "showAxisLines"=> "1",
		                "yAxisLineColor"=> "#DCDCDC",
		                "xAxisLineColor"=> "#DCDCDC",
		                "xAxisLineAlpha"=> "15",
		                "yAxisLineAlpha"=> "15",
		                "toolTipPadding"=> "7",
		                "toolTipBorderColor"=> "#DCDCDC",
		                "toolTipBorderThickness"=> "0",
		                "toolTipBorderRadius"=> "2",
		                "showShadow"=> "0",
		                "toolTipBgColor"=> "#153957",
		                "theme"=> "fint"
					),
				"data" => $values
				)	
	
			));

	    }
		$jsonEncodedData = json_encode($arrData);

    	return view('fusioncharts/index', ['getData'=>$jsonEncodedData]);
    }
}
