/**
 * 
 */

(function($){
	if((typeof $.rkt) == "undefined"){
	        $.extend({
	            rkt:{version:1,rocket:"G3258"}
	        })
	    }else if($.rkt.rocket != "G3258"){
	        console.log("rocket插件有冲突，$.rkt被占用");
	    }
})(jQuery);
//表格生成
(function($){

	var tableId = 0;
	$.extend($.rkt,{
		makeTable: makeTable
	});
	
	function makeTable(jqObj,o){
		var fields = o.fields;
		var thisTable = jqObj;
		var about = Math.random();
		var thead = $("<thead></thead>").appendTo(thisTable);
		var tr = $("<tr></tr>").appendTo(thead);
		//表头生成
		for(var i in fields){
			var html = fields[i].text;
			$("<th></th>").html(html).appendTo(tr);
		}
		//表内容生成
		var tbody = $("<tbody></tbody>").appendTo(thisTable);
		
		for(var i in o.rows){
			var row = o.rows[i];
			var tbodyTr = $("<tr></tr>").appendTo(tbody);
			for(var j in fields){
				var theField = fields[j];
				var theTd = $("<td></td>").appendTo(tbodyTr);
				//添加值
				var htmlText = row[theField.name];
				if(typeof theField.filter == "function"){
					theTd.html(theField.filter(row));
				}else{
					theTd.html(htmlText);
				}
				//执行handler
				if(typeof theField.handler == "function"){
					theField.handler(theTd,row)
				}
			}
			//执行rowHandler
			if(typeof o.rowHandler == "function"){
					o.rowHandler(tbodyTr,row,i);
			}
		}
		this["rkt-table-id"] = tableId++;
	}
})(jQuery);