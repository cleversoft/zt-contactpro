function newFieldtype()
{
	var d = document;
	var fieldtype_new = d.adminForm.jv_fieldtype_new.value;
	var fieldtype_del = d.adminForm.jv_fieldtype_delete.value;
	var value_new  = d.adminForm.jv_value_new.value;
	var lbl_property      = d.adminForm.js_lbl_property.value;
	var lbl_type         = d.adminForm.js_lbl_type.value;
	var lbl_fieldname	 = d.adminForm.js_lbl_fieldname.value;
	var lbl_fieldtitle	 = d.adminForm.js_lbl_fieldtitle.value;
	var lbl_requie	 = d.adminForm.js_lbl_requie.value;
	
	var container = $('jvmaincontact');
	var next_inc  = container.getElementsByTagName('table').length;
	var toolbar   = "<a class='btn active btn-success' href='javascript:newFieldtype();'>"+fieldtype_new+"</a> | <a class='btn active btn-danger' href='javascript:deleteFieldtype("+next_inc+")'>"+fieldtype_del+"</a> | <a id='newpro"+next_inc+"' class='btn active btn-success' href='javascript:newValue("+next_inc+")'>"+value_new+"</a>";
	var fieldorder = '';
	fieldorder = $('fieldorder').value +'|'+next_inc; 
	$('fieldorder').value = fieldorder;
	var table = d.createElement('table');
	    table.id  = 'fileType_'+next_inc;
	    table.className = 'adminform';
	var numbtype = next_inc+1;
	$('countType').setProperty('value', numbtype);
	var thead     = d.createElement("thead");
	var tbody     = d.createElement("tbody");
		tbody.id  = "jvelement"+next_inc;
	var tr        = d.createElement('tr');
	var tr2       = d.createElement('tr');
	    tr2.id    = "fieldType_tr_"+next_inc+"_0";
	var tr3   	  = d.createElement('tr');
	    tr3.id    = "fieldType_tr_"+next_inc+"";
	var tr4   	  = d.createElement('tr');
	    tr4.id    = "fieldType_tr_"+next_inc+"_0";
	var tr5   	  = d.createElement('tr');
    var td_00 = d.createElement('td');
	    td_00.align = 'left';
	    td_00.colSpan = '3';
	    td_00.innerHTML = '<div class="ztmove"><h2>Order <span id="textorder">'+next_inc+'</span></h2><span class="jv-iconmover" style="cursor: move;"><input type="text" size="2" value="'+next_inc+'" id="order" name="order[]"></span></div>';
    var td_01 = d.createElement('td');
	    td_01.style.width = '5%';
	    td_01.innerHTML = lbl_type;
	var td_02 = d.createElement('td');
	    td_02.align = 'left';
	    td_02.style.width = '200px';
	    td_02.innerHTML = '<select id="type'+next_inc+'" name="element['+next_inc+'][type]" onchange="javascript:changeElement('+next_inc+', value)"><option value="">--Select Type--</option><option value="textfield">Text Field</option><option value="selected">Drop-down selection</option><option value="radio">Radio buttons</option><option value="checkbox">Checkbox buttons</option><option value="textarea">Textarea</option><option value="text">Text</option>	</select>';
	var td_03 = d.createElement('td');
	    td_03.align = 'left';
	    td_03.innerHTML = toolbar;
	var td_05 = d.createElement('td');
	    td_05.style.width = '10%';
	    td_05.align = 'left';
	    td_05.innerHTML = lbl_property;
	var td_06 = d.createElement('td');
	    td_06.align = 'left';
	    td_06.innerHTML = "<input type='text' name='element["+next_inc+"][value][]' value='' size='30'/><a href='javascript:deleteProperty("+next_inc+",\""+next_inc+"_0\");'>X</a>";
	var td_07 = d.createElement('td');
	    td_07.style.width = '14%';
	    td_07.align = 'left';
	    td_07.innerHTML = lbl_fieldtitle;
	var td_08 = d.createElement('td');
		td_08.colSpan = '2';
		td_08.style.width = '80%';
		td_08.align = 'left';

		td_08.innerHTML = "<input type='text' name='element["+next_inc+"][fieldtitle]' size='30' value=''/>  Required: <input type='radio' value='1' name='element["+next_inc+"][required]'> Yes <input type='radio' checked='checked' value='0' name='element["+next_inc+"][required]'> No";
	var td_09 = d.createElement('td');
	    td_09.style.width = '14%';
	    td_09.align = 'left';
	    td_09.innerHTML = lbl_fieldname;
	var td_10 = d.createElement('td');
		td_10.colSpan = '2';
	    td_10.style.width = '80%';
	    td_10.align = 'left';
	    td_10.innerHTML = "<input type='text' name='element["+next_inc+"][fieldname]' size='30' value=''/>";
   table.appendChild(thead);
   thead.appendChild(tr5);
   		tr5.appendChild(td_00);
   thead.appendChild(tr);
        tr.appendChild(td_01);
        tr.appendChild(td_02);
      thead.appendChild(tr);
        tr.appendChild(td_03);
        thead.appendChild(tr4);
        tr4.appendChild(td_07);
        tr4.appendChild(td_08);
   table.appendChild(tbody);
      tbody.appendChild(tr3);  
        tr3.appendChild(td_09);
        tr3.appendChild(td_10);
        tbody.appendChild(tr2);  
        tr2.appendChild(td_05);
        tr2.appendChild(td_06);
	container.appendChild(table);
	
}
function deleteFieldtype(attribute_id)
{
	var container = document.getElementById('jvmaincontact');
	var table = document.getElementById("fileType_"+attribute_id);
	
	var numbtype = $('countType').value-1;
	$('countType').setProperty('value', numbtype);
	container.removeChild(table);
}
function newValue(attribute_id)
{
	var d = document;
    var lbl_property      = d.adminForm.js_lbl_property.value;
    var lbl_typename      = d.adminForm.js_lbl_fieldname.value;
    
	var table = document.getElementById("fileType_"+attribute_id);
	var tbody = table.getElementsByTagName('tbody')[0];
	var tr_id = table.getElementsByTagName('tr').length + 1;
	var tr = d.createElement('tr');
	    tr.id = "fieldType_tr_"+attribute_id+"_"+tr_id;
	var td_02 = d.createElement('td');
	    td_02.style.width = '10%';
	    td_02.align = 'left';
	    td_02.innerHTML = lbl_property;
	var td_03 = d.createElement('td');
		td_03.colSpan = '3';
	    td_03.style.width = '20%';
	    td_03.align = 'left';
	    td_03.innerHTML = "<input type='text' name='element["+attribute_id+"][value][]' value='' size='30'/><a href='javascript:deleteProperty("+attribute_id+",\""+attribute_id+"_"+tr_id+"\");'>X</a>";
	tbody.appendChild(tr);
	   tr.appendChild(td_02);
	   tr.appendChild(td_03);
}
function deleteProperty(attribute_id, property_id)
{
	var d     = document;
	var table = document.getElementById("fileType_"+attribute_id);
	var tbody = table.getElementsByTagName('tbody')[0];
	var tr    = d.getElementById("fieldType_tr_"+property_id);
	tbody.removeChild(tr);
}
function changeElement(attribute_id, fieldType){
	
	var table = $("fileType_"+attribute_id);
	var tbody = $("jvelement"+attribute_id);
	var tr    = $$("tr.jvelement"+attribute_id);
	var tr_id = table.getElementsByTagName('tr').length + 1;
	switch (fieldType){
		case 'textfield':
			$('newpro'+attribute_id).setStyle('visibility', 'hidden');
			$('fieldType_tr_'+attribute_id + '_0').setStyle('display', '');
			tbody.innerHTML = "<tr>"+
								  "<td width='15%'>Field name</td>"+
								  "<td colspan='2'><input type='text' name='element["+attribute_id+"][fieldname]' size='30' value=''/></td>"+
							  "</tr>"+
							  "<tr>"+
							  	  "<td align='left'>Size</td>"+
							  	  "<td colspan='2'><input type='text' name='element["+attribute_id+"][size]' value='' size='10' /></td>"+
							  "</tr>"+
							  "<tr>"+
								  "<td align='left'>Max Length</td>"+
								  "<td colspan='2'><input type='text' name='element["+attribute_id+"][maxlength]' value='' size='10' /></td>"+
							  "</tr>";
		break;
		case 'textarea':
			$('newpro'+attribute_id).setStyle('visibility', 'hidden');
			$('fieldType_tr_'+attribute_id + '_0').setStyle('display', '');
			tbody.innerHTML = "<tr>"+
							      "<td width='15%'>Field name</td>"+
							      "<td colspan='2'><input type='text' name='element["+attribute_id+"][fieldname]' value='' size='30' /></td>"+
							  "</tr>"+
							  "<tr>"+
							  	  "<td align='left'>Cols</td>"+
							  	  "<td colspan='2'><input type='text' name='element["+attribute_id+"][cols]' value='' size='10' /></td>"+
							  "</tr>"+
							  "<tr>"+
								  "<td align='left'>Rows</td>"+
								  "<td colspan='2'><input type='text' name='element["+attribute_id+"][rows]' value='' size='10' /></td>"+
							  "</tr>";
		break;
		case 'selected':
			$('newpro'+attribute_id).setStyle('visibility', 'visible');
			valueattribute = '"'+attribute_id + '_0"';
			$('fieldType_tr_'+attribute_id + '_0').setStyle('display', '');
			tbody.innerHTML = "<tr id='fieldType_tr_"+attribute_id+"'>"+
								 "<td align='left' style='width: 14%;'>Field name</td>"+
								 "<td align='left' colspan='2' style='width: 80%;'><input type='text' value='' size='30' name='element["+attribute_id+"][fieldname]'></td>"+
							  "</tr>"+
							  "<tr>"+
								 "<td align='left'>Multiple</td>"+
								 "<td colspan='2'><select name='element["+attribute_id+"][multi]'><option value='0'>No</option><option value='1'>Yes</option></select></td>"+
							  "</tr>"+
							  "<tr>"+
								 "<td align='left'>Size</td>"+
								 "<td colspan='2'><input type='text' name='element["+attribute_id+"][size]' value='' size='10' /></td>"+
							  "</tr>"+
							  "<tr id='fieldType_tr_"+attribute_id+"_0'>"+
							     "<td align='left' style='width: 10%;'>Value</td>"+
							     "<td align='left' colspan='2'>"+
							        "<input type='text' size='30' value='' name='element["+attribute_id+"][value][]'>"+
							        "<a href='javascript:deleteProperty("+attribute_id+", "+valueattribute+");'>X</a>"+
							     "</td>"+
							  "</tr>";
		break;
		case 'checkbox':
		case 'radio':
			$('newpro'+attribute_id).setStyle('visibility', 'visible');
			valueattribute = '"'+attribute_id + '_0"';
			$('fieldType_tr_'+attribute_id + '_0').setStyle('display', '');
			tbody.innerHTML = "<tr id='fieldType_tr_"+attribute_id+"'>"+
								 "<td align='left' style='width: 14%;'>Field name</td>"+
								 "<td align='left' colspan='2' style='width: 80%;'><input type='text' value='' size='30' name='element["+attribute_id+"][fieldname]'></td>"+
							  "</tr>"+
							  "<tr id='fieldType_tr_"+attribute_id+"_0'>"+
							     "<td align='left' style='width: 10%;'>Value</td>"+
							     "<td align='left' colspan='2'>"+
							        "<input type='text' size='30' value='' name='element["+attribute_id+"][value][]'>"+
							        "<a href='javascript:deleteProperty("+attribute_id+", "+valueattribute+");'>X</a>"+
							     "</td>"+
							  "</tr>";
		break;
		case 'text':
			$('newpro'+attribute_id).setStyle('visibility', 'hidden');
			valueattribute = '"'+attribute_id + '_0"';
			//$('fieldType_tr_'+attribute_id + '_0').innerHTML='';
			$('fieldType_tr_'+attribute_id + '_0').setStyle('display', 'none');
			tbody.innerHTML = "<tr id='fieldType_tr_"+attribute_id+"_0'>"+
							     "<td align='left' style='width: 10%;'>Text</td>"+
							     "<td align='left' colspan='2'>"+
							        "<textarea type='text' cols='57' rows='6' name='element["+attribute_id+"][fieldtext]'></textarea>"+
							     "</td>"+
							  "</tr>";
		break;
		default:
			$('newpro'+attribute_id).setStyle('visibility', 'visible');
			valueattribute = '"'+attribute_id + '_0"';
			$('fieldType_tr_'+attribute_id + '_0').setStyle('display', '');
			tbody.innerHTML = "<tr id='fieldType_tr_"+attribute_id+"'>"+
								 "<td align='left' style='width: 14%;'>Field name</td>"+
								 "<td align='left' colspan='2' style='width: 80%;'>"+
								     "<input type='text' value='' size='30' name='element["+attribute_id+"][fieldname]'>"+
								 "</td>"+
							  "</tr>"+
							  "<tr id='fieldType_tr_"+attribute_id+"_0'>"+
							      "<td align='left' style='width: 10%;'>Value</td>"+
							      "<td align='left' colspan='2'>"+
							          "<input type='text' size='30' value='' name='element["+attribute_id+"][value][]'>"+
							          "<a href='javascript:deleteProperty("+attribute_id+", "+valueattribute+");'>X</a>"+
							      "</td>"+
							   "</tr>";
		break;

	}
}