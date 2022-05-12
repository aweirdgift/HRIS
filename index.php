<?php
require 'config/config.php';
require GLOBAL_FUNC;
require CL_SESSION_PATH;
require CONNECT_PATH;
require ISLOGIN; 

/*
if(!($g_user_role[0] == "REGISTRAR" OR $g_user_role[0] == "ADMIN")){ 
	include HTTP_404;
	exit();
}

$default_get_id = get_school_year();

$select_academic_year_id = isset($_GET['academic_year']) ? trim($_GET['academic_year']) : 0;

if(!is_digit($select_academic_year_id)){
//$list_select_ay = explode(',',$select_academic_year);
	include HTTP_404;
	exit();
}

$select_academic_year = json_encode(array($select_academic_year_id));
$data_array =array();
$error=false;
$filter_year =array();
if($query = call_mysql_query("SELECT school_year_id, school_year, sem FROM school_year ORDER BY school_year_id DESC")){
    while($data=mysqli_fetch_array($query,MYSQLI_ASSOC)){
		array_push($filter_year , $data);
    }
}



//sql sample
$collect_teacher = implode(",",$collect_teacher);
$sql_conds = (empty($collect_teacher)) ? 'LIMIT 1' : 'WHERE t.teacher_id IN ('.$collect_teacher.')';
$collect_teacher = array();
$default_query = "SELECT t.teacher_id,CONCAT(t.firstname,' ',t.lastname) as teacher_name FROM teacher as t ".$sql_conds;
if($query = call_mysql_query($default_query)){
	if($num = call_mysql_num_rows($query)){
		while($data = call_mysql_fetch_array($query)){
			$id = $data['teacher_id'];
			$collect_teacher[$id] = $data['teacher_name'];
		}
	}
	mysqli_free_result($query);
}


*/


$data_row=array();
$teacher_array =array();
$query = "SELECT teacher_id,CONCAT(firstname,' ',lastname) as teacher_name FROM teacher WHERE teacher_id!='".$s_user_id."' ";
$result = mysqli_query($db_connect,$query);			
if($result){
	$count = mysqli_num_rows($result);
	if($count != 0){
		while($data_row  = mysqli_fetch_assoc($result)){
			$data_row = array_html($data_row);
			array_push($teacher_array,$data_row);
		}
		
	}
	
}

$teacher_list = empty($teacher_array) ? '[]' :output($teacher_array);

$select_academic_year_id = 0;
$select_academic_year = json_encode(array($select_academic_year_id));
$temp = array();
$temp['sem'] = '2nd Semester';
$temp['school_year'] = '2022-2023';
$temp['school_year_id'] = '1';
$filter_year[] = $temp;

$filter_year = json_encode($filter_year);
//$table_array = json_encode($table_array);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php
    include DOMAIN_PATH."/app/global/meta_data.php";
    include DOMAIN_PATH."/app/global/include_top.php";
?>
</head>
	<?php
	//for fine-uploader.
	?>
	<link href="<?php echo BASE_URL;?>js/fine-uploader/fine-uploader-gallery.min.css?v=<?php echo FILE_VERSION;?>" rel="stylesheet">
    <script src="<?php echo BASE_URL;?>js/fine-uploader/fine-uploader.min.js?v=<?php echo FILE_VERSION;?>"></script>
    <script type="text/template" id="qq-template">
        <div class="qq-uploader-selector qq-uploader qq-gallery" qq-drop-area-text="Drop files here">
            <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
                <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
            </div>
            <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
                <span class="qq-upload-drop-area-text-selector"></span>
            </div>
            <div class="qq-upload-button-selector qq-upload-button">
                <div>Select a file</div>
            </div>
            <div>

            </div>
            <span class="qq-drop-processing-selector qq-drop-processing">
                <span>Processing dropped files...</span>
                <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
            </span>
            <ul class="qq-upload-list-selector qq-upload-list" role="region" aria-live="polite" aria-relevant="additions removals">
                <li>
                    <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
                    <div class="qq-progress-bar-container-selector qq-progress-bar-container">
                        <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
                    </div>
                    <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
                    <div class="qq-thumbnail-wrapper">
                        <img class="qq-thumbnail-selector" qq-max-size="120" qq-server-scale>
                    </div>
                    <button type="button" class="qq-upload-cancel-selector qq-upload-cancel">X</button>
                    <button type="button" class="qq-upload-retry-selector qq-upload-retry">
                        <span class="qq-btn qq-retry-icon" aria-label="Retry"></span>
                        Retry
                    </button>

                    <div class="qq-file-info">
                        <div class="qq-file-name">
                            <span class="qq-upload-file-selector qq-upload-file"></span>
                            <span class="qq-edit-filename-icon-selector qq-btn qq-edit-filename-icon" aria-label="Edit filename"></span>
                        </div>
                        <input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
                        <span class="qq-upload-size-selector qq-upload-size"></span>
                        <button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">
                            <span class="qq-btn qq-delete-icon" aria-label="Delete"></span>
                        </button>
                        <button type="button" class="qq-btn qq-upload-pause-selector qq-upload-pause">
                            <span class="qq-btn qq-pause-icon" aria-label="Pause"></span>
                        </button>
                        <button type="button" class="qq-btn qq-upload-continue-selector qq-upload-continue">
                            <span class="qq-btn qq-continue-icon" aria-label="Continue"></span>
                        </button>
                    </div>
                </li>
            </ul>

            <dialog class="qq-alert-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">Close</button>
                </div>
            </dialog>

            <dialog class="qq-confirm-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">No</button>
                    <button type="button" class="qq-ok-button-selector">Yes</button>
                </div>
            </dialog>

            <dialog class="qq-prompt-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <input type="text">
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">Cancel</button>
                    <button type="button" class="qq-ok-button-selector">Ok</button>
                </div>
            </dialog>
        </div>
    </script>
<style>
#header_table{
	font-weight : bold;
}
</style>
<body data-layout="detached">
    <!-- HEADER -->
  <?php include DOMAIN_PATH."/app/global/top_bar.php"; ?>     <!--topbar -->
    <div class="container-fluid active">
        <div class="wrapper in">
            <!-- BEGIN CONTENT -->
            <!-- SIDEBAR -->
   <?php include DOMAIN_PATH."/app/global/sidebar.php";  ?>
            <!--END SIDEBAR-->
            <!-- PAGE CONTAINER-->
            <div class="content-page">
                <div class="content">
                    <!-- BEGIN PlACE PAGE CONTENT HERE -->
					
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
							
                                        <h4 class="mb-3 header-title"></h4>
		
                                        <div class="table-responsive-sm mt-4">

										    <div class="row">
												<div class="col-lg-6">
												<label>FORM EXAMPLE</label>
												
												<div class="input-group mb-3">
												 <select  class="form-control" name ="school_year_id" id="school_year_id" placeholder="Fiscal Year & Semester" required></select>
												  <div class="input-group-append d-block">
												   <button id="btn_gen_year" type="button" class="btn btn-outline-dark btn-rounded btn-sm ml-1 " style="padding: 6px 12px !important; ">Generate</button>
												  </div>
												</div>
												</div>
											
                                            </div>


										    <div class="row">
												<div class="col-lg-6">
													<button id="btn_modal" type="button" class="btn btn-outline-dark btn-rounded btn-sm ml-1 " style="padding: 6px 12px !important; ">SHOW MODAL</button>
												</div>
											
                                            </div>



											
												<div  class="table  table-bordered col-xl-12 mb-4  mt-3 p-0" style="min-width:600px;overflow:auto;" >	
													<div class="row col-sm-12 col-md-12 col-lg-12 p-0 m-0">
													<div  class="col-sm-12  col-md-12 col-lg-12 " >
														
														<div id="header_table" class="col-lg-12 mt-2">
			
														</div>
														 <?php if($g_user_role[0] == "REGISTRAR") { ?>
														 <button id="delete_sel_btn"  class="btn btn-outline-dark btn-rounded btn-sm ml-1" > <i class="fas fa-trash" ></i> Delete</button>
														 <button id="change_status"  class="btn btn-outline-dark btn-rounded btn-sm ml-1" > <i class="fas fa-user-tag" ></i> Change Status</button>
														  <button id="load_all_data"  class="btn btn-outline-dark btn-rounded btn-sm ml-1" > <i class="fas fa-spinner" ></i> LOAD ALL DATA</button>
														
														
														 <br><hr/>
														  <button id="select_visible" class="btn btn-outline-dark btn-rounded btn-sm ml-1" > <i class="fas fa-check" ></i> SELECT ACTIVE</button>
														  <button id="deselect_visible" class="btn btn-outline-dark btn-rounded btn-sm ml-1" > <i class="fas fa-times" ></i> DESELECT ALL</button><b><label class="pl-5">Selected: <span id="selected_no"> 0 </span></label></b><br><hr/>
														 <?php } ?>
														<div  class="table-bordered  " id="table_project"> </div>
														<div>  
															<button id="download-csv-proj">Download CSV</button>
															<button id="download-json-proj">Download JSON</button>
															<button id="download-xlsx-proj">Download EXCEL</button>
															<button id="print-proj">Print</button>
														</div>
													</div>
													</div>
												</div>
										 
											

                                        </div>
                                    </div>
                                </div>

                            </div> <!-- end col-->
                        </div>



                    <!-- END PLACE PAGE CONTENT HERE -->
                </div>
            </div>
            <!-- END CONTENT -->
        </div>
    </div>
    <!-- all the js files -->
    <!-- bundle -->
	
	
<div class="modal fade " id="modal_form_upload" tabindex="-1" role="dialog"  aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="modalTitle_upload"><?php echo $modal_title; ?></h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">

<div class="panel-body">
<div id="msg" class="alert alert-info alert-dismissable" style="display: block;">
**Limit 20MB per Uploading.
</div>
<div id="upload_form_msg" class="alert alert-warning alert-dismissable <?php echo isset($message['errors']) ? 'd-block':'d-none';?>" >
    <?php echo isset($message['errors']) ? $message['errors']:'';?>
</div>
  <!-- <form class="form-group" id="modalform" name='add_form' action="#" method="POST"> -->
    <div class="row">
      
        <div class="form-group col-sm-12 col-lg-12">
        <label for="content_title">Title :</label>
        <input type="text" class="form-control" name="content_title" id="content_title" value="<?php echo $g_selected['title'];?>" required="">
        </div>
<?php
if(($g_selected['data_type'] == "UPLOAD_FILE" OR $g_selected['data_type'] == "UPLOAD_ASSIGN") AND $param_id!=0){ 
			$table_id = 'file_id';
		?>			
		<div id="table_uploaded" class="form-group  col-sm-12 col-lg-12 table-responsive ">
		<table class="table">
		  <thead class="thead-dark">
			<tr>
			  <th scope="col">DATE</th>
			  <th scope="col">FILENAME</th>
			  <th scope="col">ACTION</th>
			</tr>
		  </thead>
		  <tbody>
		   
			<tr>
			  <th scope="row" data-date_display="<?php echo $g_selected['fdatein'];?>"></th>
			  <td><?php echo $g_selected['fname']; ?></td>
			  <td><a href=<?php echo "'".BASE_URL."app/privatefiles.php?id=".$g_selected['file_id']."'"; ?>  target='_blank' title="DOWNLOAD"><i class="fa fa-download"> </i></a></td>
			</tr>	  

		  </tbody>
		</table>			
		</div>
<?php } ?>
		
		<div class="form-group  col-sm-6 col-lg-6" id="attach_input">
        <label for="">Attachment(s) :</label>
			 <div id="traditional-uploader_file"></div>
        </div>

		<div class="form-group col-sm-12 col-lg-12">
        <label for="content_summary">Summary/Notes:</label>
			<textarea class="form-control" name="content_summary" id="content_summary" rows=8 > <?php echo $g_selected['fdesc'];?></textarea>
	
        </div>
		<div class="table_shared form-group col-sm-12 col-lg-12">
			<label for="shared_to">Shared To: </label>
				<select  class="form-control" style="width:100%;" id="teacher_select" placeholder="Add Instructor" >
					<option value="">Select Instructor</option>
				</select>
		</div>
		  
      </div>
      
</div>
</div>
    <div class="modal-footer">
    <button  type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
    <button id="button_modal_upload" type="button" name="submit" value="<?php echo $text_action;?>" class="btn btn-primary">Save</button>
    </div>
   <!-- </form>-->
</div>

</div>
</div> 	
<?php  include FOOTER_PATH; ?>
</body>
<?php include DOMAIN_PATH."/app/global/include_bottom.php"; ?>
<script>


(function() { //starting anonymous function

/*
sample add event listener
addListener(element, action, function() {
	//code here
});

addListener(document.getElementById('download-csv-proj'), "click", function() {
	//code here
});

*/

//initialize global js variable
var collection_select = [];
var list_academic_year = <?php echo $filter_year; ?>;
var table_project ="";
var school_year_id = <?php echo $select_academic_year_id; ?>;
var total_record =0;
var  check_box_all = false;
var selected_ck = false;









//for fine-uploader
var manualUploader = new qq.FineUploader({
	element: document.getElementById("traditional-uploader_file"),
	autoUpload: false,
	warnBeforeUnload: true,
	validation: {
		   allowedExtensions: [],
		   itemLimit: 1,
		},
	request: {
		endpoint: "<?php echo BASE_URL;?>app/ajax_fileupload.php",
	   // params: {id:123,task:'upload'}
	},
	chunking: {
		enabled: true,
		concurrent: {
			enabled: false
		},
		success: {
			endpoint: "<?php echo BASE_URL;?>app/ajax_fileupload.php?done"
		}
	},
	resume: {
		enabled: false
	},
	retry: {
		enableAuto: false,
		showButton: false,
		preventRetryResponseProperty:'preventRetry',
	},
	callbacks: {
	onError: function(id, name, errorReason, xhrOrXdr) {
		error_notif("Error :"+ errorReason);
		qq(manualUploader.getItemByFileId(id)).remove();
	},
	onValidate: function(data) {
		if (totalSizeSoFar + data.size > totalAllowedSize) {
			error_notif("Error : Exceed Allowable File Size to Upload 20MB");
			return false;
		}
		totalSizeSoFar += data.size;
	},onAllComplete: function() {
		
		var tempA = manualUploader.getUploads({status: [qq.status.UPLOAD_SUCCESSFUL]});
		if(tempA.length > 0){
				success_notif("Successfully Saved");
				setTimeout(function(){ refresh_aftersave(); }, 1000);
		}else{
				error_notif("Error Occured!");
		}
		isPaused = false;
		removeClass(document.querySelector('body'),"loading");
		
	},onSubmit: function (id, fileName) {

	},
	onProgress: function(id, name, uploadedBytes, totalBytes) {
		 addClass(document.querySelector('body'),'loading');
	},
	onManualRetry: function (id, fileName) {
		
		}

	}
});

//end fine-uploader






//for tabulator

function numbering(cell,formatterParams){
	var val = ""+ cell.getValue(); 
	val = "CL-" + zeroPad(val,5);
	return  val;
}

var table_for_project = new Tabulator("#table_project", {
	printAsHtml:true,
    height:"700px",
    headerFilterPlaceholder:"",
    layout:"fitDataFill",
    placeholder:"No Data Found",
	printHeader:document.getElementById('header_table').innerHTML,
    movableColumns:true,
	selectable:true,
	ajaxURL:"<?php echo BASE_URL;?>ajax_table.php", 
	ajaxParams:{load_all:0,school_year_id:school_year_id}, 
    ajaxProgressiveLoad:"scroll",
    ajaxProgressiveLoadScrollMargin:1,
    ajaxLoader: true,
    ajaxLoaderLoading: 'Fetching data from Database..',	
	ajaxSorting:true,  
    ajaxFiltering:true,
	printConfig:{
        columnGroups:true, 
        rowGroups:true,
		formatCells:false,
    },
	selectableRollingSelection:false,
    paginationSize:<?php echo QUERY_LIMIT; ?>, 
    columns:[

		{formatter:"rowSelection",field:'checkbox',width:50,hozAlign:"center",print:false,download:false,frozen:true},
		{title:"Date", field:"date_added",sorter:"date",frozen:true,download:false, headerSort:false,headerFilterLiveFilter:false},
		{title:"Class Ref",hozAlign:"center", field:"teacher_class_id",bottomCalc:record_details, sorter:"string",formatter:numbering,frozen:true,headerFilter:"input",headerFilterLiveFilter:false},
		{title:"Status",hozAlign:"center", field:"status", headerSort:false,sorter:"string",frozen:true,headerFilter:"input",headerFilterLiveFilter:false}, 
		{title:"Student ID",hozAlign:"center", field:"username", sorter:"string",frozen:true,headerFilter:"input",headerFilterLiveFilter:false}, 
		{title:"Student Name",hozAlign:"left", field:"student_name", sorter:"string",frozen:true,headerFilter:"input", headerFilterLiveFilter:false},		
		{title:"Subject",hozAlign:"center", field:"subject_code",headerSort:false,headerFilter:"input", headerFilterLiveFilter:false},
		{title:"Course Desc. ",hozAlign:"left", field:"subject_text",headerSort:false,headerFilter:"input", headerFilterLiveFilter:false},
		{title:"Units",hozAlign:"center", field:"subject_unit", sorter:"number",headerFilter:"input", headerFilterLiveFilter:false},
		{title:"Section",hozAlign:"center", field:"class_name",headerSort:false,headerFilter:"input", headerFilterLiveFilter:false},
		{title:"Program",hozAlign:"center", field:"course_short", sorter:"string",headerFilter:"input", headerFilterLiveFilter:false},	
		{title:"Student Program ID",hozAlign:"center", field:"student_program",visible:false,download:true,print:false, headerFilterLiveFilter:false},
		{title:"Enrolled Program ID",hozAlign:"center", field:"program_id",visible:false,download:true,print:false, headerFilterLiveFilter:false},
		{title:"Year Level",hozAlign:"center", field:"year_level", sorter:"string",headerFilter:"input", headerFilterLiveFilter:false},	
		{title:"Student Year Level",hozAlign:"center", field:"student_yrlvl",visible:false,download:true,print:false, headerFilterLiveFilter:false},	
		{title:"Day / Time",hozAlign:"left", field:"day_time", headerSort:false,headerFilter:"input", headerFilterLiveFilter:false},
		{title:"Instructor Name", field:"teacher_name",headerFilter:"input",headerSort:false,headerFilterLiveFilter:false},	
		
	],downloadComplete:function(){
		removeClass(document.querySelector('body'),"loading");
    },renderComplete:function(){
		var table =this;
		this.selectRow(collection_select); 
		
	},rowSelected:function(row){
		if(collection_select.indexOf(row.getData().teacher_class_student_id) === -1){
			collection_select.push(row.getData().teacher_class_student_id);
		}
		if(document.getElementById('selected_no')){
			document.getElementById('selected_no').innerHTML = collection_select.length;	
		}
    },rowDeselected:function(row){
        if(collection_select.indexOf(row.getData().teacher_class_student_id) !== -1){
            collection_select.splice(collection_select.indexOf(row.getData().teacher_class_student_id), 1);
		}
		if(document.getElementById('selected_no')){
			document.getElementById('selected_no').innerHTML = collection_select.length;	
		}
    },ajaxResponse:function(url, params, response){  
		if(response.total_record){
			total_record = response.total_record;
		}		
        return response; 
    },ajaxRequesting: function (url, params) {
		if(typeof this.modules.ajax.showLoader() != "undefined" ){
			this.modules.ajax.showLoader();
		}	
		 if (check_box_all) {
			params['load_all'] = 1;
		}
	},
});


function record_details(values, data, calcParams) { 
	if (values && values.length) {
       
	
      return values.length + ' of '+total_record;
	}
}

	addListener(document.getElementById('load_all_data'), "click", function() {
		if(check_box_all == false) {
			Swal.fire({
			  title: 'Are you sure to load all data?',
			  text: "This may take a long time to load.",
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Yes!'
			}).then((result) => {
			  if (result.isConfirmed) {
				check_box_all = true;
				table_for_project.setData();
			  }else{
				check_box_all = false;
			  }
			});
		}
	});
	
	addListener(document.getElementById('download-csv-proj'), "click", function() {
		addClass(document.querySelector('body'),'loading');
		table_for_project.download("csv", 'study_load_' + getFormattedTime() +'.csv',{bom:true});
	});
	addListener(document.getElementById('download-json-proj'), "click", function() {
		addClass(document.querySelector('body'),'loading');
		table_for_project.download("json", 'study_load_' + getFormattedTime() +'.json');
	});
	addListener(document.getElementById('download-xlsx-proj'), "click", function() {
		addClass(document.querySelector('body'),'loading');
		table_for_project.download("xlsx", 'study_load_' + getFormattedTime() +'.xlsx',{bom:true});
	});

	addListener(document.getElementById('print-proj'), "click", function() {
		 table_for_project.print(false, true);
	});
//end tabulator


//for selection
var select_academic_year=$('#school_year_id').selectize({
	valueField: 'school_year_id',
	labelField: ['school_year'],
	searchField: ['school_year'],
	options: list_academic_year,
	items: <?php echo $select_academic_year; ?>,
	persist: false,
	maxItems: 1,
	dropdownParent: "body",
	render: {
		option: function(item, escape) {
			return '<div> <h5 class="title">F.Y : ' + escape(item.school_year)  +' - '+ escape(item.sem)  +'</h5></div>';
	  
		},
		item: function(item, escape) {
			return '<div> F.Y. <span class="title">' + escape(item.school_year) +' - '+ escape(item.sem)  +'</span></div>';
	  
		}
	},
	onChange: function(value) {
     	//insertParam("academic_year",value);
    }

});


var btn_year = document.getElementById('btn_gen_year');
if(btn_year){
addListener(btn_year,"click",function(){
	var val =select_academic_year[0].selectize.getValue();
	if(val==''){
	
	}else{
		//console.log(val);
		insertParam("academic_year",val);
	}
});	
}

//overlay loading when ajax call
function add_overlay(){
	var body = document.querySelector('body');	
	var overlay = document.querySelector('.overlay');	
	if(overlay){
	}else{
		var div = document.createElement('div');
		div.className = "overlay";
		body.appendChild(div);
	}
}

add_overlay();

$(document).on({
	
	ajaxStart: function(){
		addClass(document.querySelector('body'),'loading');
		isPaused = true;
	},
	ajaxStop: function(){ 
		removeClass(document.querySelector('body'),"loading");
		isPaused = false;
	}    
});

//end overlay



addListener(document.getElementById('delete_sel_btn'), "click", function() {
        if(collection_select.length == 0){
            warning_notif('Please select Item in the table!');
        }else{
			
			Swal.fire({
			  title: 'Are you sure?',
			  text: "You won't be able to revert this!",
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Yes, delete it!'
			}).then((result) => {
				   if (result.isConfirmed) {      
					var json_id = JSON.stringify(collection_select);
					$.post("<?php echo BASE_URL;?>app/admin/ajax_delete_studentclass.php", { action : 'DELETE_STUDENTLIST',teacher_class_student_ids:json_id}, 
						function(returnedData){
							var obj = returnedData;// JSON.parse(returnedData);
							if(obj.result == "success"){
								table_for_project.deleteRow(collection_select);
								var len = collection_select.length;
								total_record = total_record - len;
								table_for_project.deselectRow();
								collection_select=[];
								table_for_project.recalc();
								Swal.fire(
								  'Deleted!',
								  'Data has been deleted.',
								  'success'
								);
							}else{
								warning_notif("Error: "+obj.errors);                    
							}
					}).fail(function(){
						  warning_notif("Error Encounter");
					});
			  }
			});
			
	
}
});

addListener(document.getElementById('select_visible'), "click", function() {
   if(table_for_project){
		table_for_project.selectRow();
		var temp  = (table_for_project.getSelectedRows()) ? table_for_project.getSelectedRows() : [];
		forEach(temp,function(values,i){
			if(collection_select.indexOf(values.getData().teacher_class_student_id) === -1){
				 collection_select.push(values.getData().teacher_class_student_id);
			}
		});	
		
		if(document.getElementById('selected_no')){
			document.getElementById('selected_no').innerHTML = collection_select.length;	
		}
   }
});

addListener(document.getElementById('deselect_visible'), "click", function() {
   if(table_for_project){
		//var temp  = (table_for_project.rowManager.displayRows[1]) ? table_for_project.rowManager.displayRows[1] : [];
		table_for_project.deselectRow();
		collection_select = [];
		if(document.getElementById('selected_no')){
			document.getElementById('selected_no').innerHTML = collection_select.length;	
		}
   }
});

var options= [{'id':'0','status':'ACTIVE'},{'id':'1','status':'DROP'},{'id':'2','status':'LOA'}];
var select_class="";
addListener(document.getElementById('change_status'), "click", function() {
		if(collection_select.length == 0){
			warning_notif('Please select Item in the table!');
		}else{
			var reason = "";	
			swal.mixin({
			  confirmButtonText: 'Next <i class="fas fa-chevron-right"></i>',
			  showCancelButton: true,
			  progressSteps: ['1', '2']
			}).queue([
				{
					title: 'CHANGE STATUS TO:',
					html: '<select id="class_select"></select>',
					onBeforeOpen: () => {
					select_class=$('#class_select').selectize({
						valueField: 'status',
						labelField: ['status'],
						searchField: ['status'],
						options:options,
						persist: false,
						maxItems: 1,
						dropdownParent: "body",
						render: {
							option: function(item, escape) {
								return '<div> <h5 class="title">' + escape(item.status)  +'</h5>' + '</div>';
						  
							},
							item: function(item, escape) {
								return '<div> <span class="title">' + escape(item.status)  +'</span>' + '</div>';
						  
							}
						}

					});

				  },preConfirm: () => {
						if(select_class.val().length == 0){
							Swal.showValidationMessage('Please select Status!');
							return '';
						}
	
					}
				},
				{
					title: 'Are you sure to change the status of selected items?',
					text: "You won't be able to revert this!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, change it!',
					preConfirm: function(result){
						if(result){
							var json_id = JSON.stringify(collection_select);
							$.post("<?php echo BASE_URL;?>app/admin/ajax_change_status.php", { action : 'UPDATE_STUDENT_LOAD',teacher_class_student_ids:json_id,status:select_class.val()}, 
								function(returnedData){
									var obj = returnedData;// JSON.parse(returnedData);
									if(obj.result == "success"){
										//table_for_project.updateData([{id:1, name:"bob"}]); //update data
										var len = collection_select.length;
										total_record = total_record - len;
										table_for_project.deselectRow();
										collection_select=[];
										table_for_project.replaceData()
										Swal.fire(
										  'Updated!',
										  'Data has been updated.',
										  'success'
										);
									}else{
										warning_notif("Error: "+obj.errors);                    
									}
							}).fail(function(){
								  warning_notif("Error Encounter");
							});
						
						  
						  
						  
						  
					
						}
					}
			  }
			]).then((result) => {
				if (result.value) {
					  
				}
			});
	}
});

//modal
var modalBtn = document.getElementById('btn_modal');
addListener(modalBtn, "click", function() {
		openModal();
});

function openModal(){
		
		var modal ="#modal_form_upload";
		
		var title = "Edit Files";
      
        if(document.getElementById('button_modal_upload')){
            document.getElementById('button_modal_upload').value ="save";
        }
        if(document.getElementById('modalTitle_upload')){
            document.getElementById('modalTitle_upload').innerHTML =title
        }
		if(document.getElementById('teacher_select')){
           // document.getElementById('class_form_msg').innerHTML ="";
		   teacher_select[0].selectize.setValue("");
        }
			
        $(modal).modal({
            backdrop: 'static',
            keyboard: false
        });
}
//modal end
var teacher_options = <?php echo $teacher_list; ?>;

var teacher_select=$('#teacher_select').selectize({
    valueField: 'teacher_id',
    labelField: 'teacher_name',
    searchField: ['teacher_name'],
	create:false,
	plugins: ['remove_button'],
	//persist: false,
    maxItems: null,
	dropdownParent: "body",
	options: teacher_options,
	render: {
		 item: function(item, escape) {
            return '<div>' +
                (item.teacher_name ? '<span class="name">' + escape(item.teacher_name) + '</span>' : '') +               
            '</div>';
        },
        option: function(item, escape) {
            return '<div> <h5 class="title">' + escape(item.teacher_name) +'</small></h5></div>';
      
        }
    }
});
})(); //end anonymous


//modify url
function insertParam(key, value) {
        key = escape(key); value = escape(value);

		var url = window.location.href;
		var page_y = 0;
		var py = false;
		var update =false;
		if( document.documentElement){
			page_y =  document.documentElement.scrollTop;
		}

        var kvp = document.location.search.substr(1).split('&');
        if (kvp == '') {
           // document.location.search = '?' + key + '=' + value;
        }else {
			
			

            var i = kvp.length-1;
			var x;
			
			while (i >=0) {
                x = kvp[i].split('=');
				if (x[0] == 'page_y') {
					
                    x[1] = page_y;
                    kvp[i] = x.join('=');
					py =true;
                }
				
                if (x[0] == key) {
                    x[1] = value;
                    kvp[i] = x.join('=');
					update = true;
                }
				i--;
            }
			
			

			if(update == false){
				kvp[kvp.length] = [key, value].join('=');
			}
  
		}

			if(url.indexOf('?') !==-1 ){
				url = url.slice(0,url.indexOf('?'));
			}
			
			var separator = "?";
			var addlink = ""; 

			if(kvp==''){
				url = url + "?page_y="+ page_y +"&"+ key + '=' + value;;
				separator = "&";
			}else{
				addlink = separator + kvp.join('&')
			}
			//return;
		window.location =  url + addlink;

    }
	
	//end modify url
<?php

		$msg_success =$session_class->getValue('success');
    	if(isset($msg_success) AND $msg_success !=""){
			echo "success_notif('".$msg_success."');";
			$session_class->dropValue('success');
    	}

    	$msg_error =$session_class->getValue('error');
    	if(isset($msg_error) AND $msg_error !=""){
			echo "error_notif('".$msg_error."');";
			$session_class->dropValue('error');
    	}
?>
</script>
</html>
