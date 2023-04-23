$(document).ready(function() {


	/*
	 *common functions
	*/
	/*===============AJAX=================================*/
	function dynamicAjax(fileName , reqType , dataObj)
	{
		return new Promise((resolve,reject) => {

		    $.ajax({
		        url     : fileName,
		        type    : reqType,
		        async   : true,
		        data    : dataObj,
		        beforeSend: function() {
                    callLoader();
                },
                complete: function() {
                    endLoader();
                },
		        dataType:'json',
		        success : function (response)  { resolve(response); },
		        error   : function (response)  { reject(response);  }
		    });

		});
	}
	/*=====================================================================*/
    
    /*==============Get-category-triggers===========================*/
	function categoryTriggers(milestone_category_id,selected=''){
		
		dynamicAjax(configUrl['milestone-category-triggers'],'GET',{milestone_category_id:milestone_category_id}).then((response) => {

			if(response.status == 1) {
                
                let data = response.data;
                if(data.length > 0) {
                	let html = '<option value="">-Select-</option>';
                	$.each(data,function(index,trigger) {

                        if(selected != '' && selected == trigger.trigger_id){
                              
                            html += `<option value="${trigger.trigger_id}" selected>${trigger.trigger_name}</option>`;
                        }
                        else
                        {

                		  html += `<option value="${trigger.trigger_id}">${trigger.trigger_name}</option>`;
                        }
                	});
                	$('select#milestone_trigger_id').html(html);
                }
			}

		}).catch((response) => {

			$('select#milestone_trigger_id').html('<option value="">-select-</option>');
		})
	}
    /*=====================================================================*/

    /*==================Initial-Datatable===========================*/
    function initDataTable(id) {

        let dt = $('body #'+id).DataTable({
            searching: false,
            paging: true,
            bSort: false,
            responsive: true,
            fixedHeader: {
                header: true,
            },
            pageLength: '100',
            dom: 'Bfrtip'
        });

        return dt;

    }
    /*=====================================================================*/


    /*====================dateTimePicker============================*/
     function setDateTimePicker(elementSelector,dateObje = null)
     {
        let element      = $(elementSelector);
        let elementValue = element.val();
        element.datepicker();
        if(dateObje) 
        { element.datepicker('setDate', dateObje); }
        else
        {  element.datepicker('setDate', new Date()); }
        // element.daterangepicker({

        //     singleDatePicker : true,
        //     showDropdowns    : true,
        //     //autoUpdateInput  : false,
        //     locale           : {
        //                            format: 'YYYY/MM/DD'
        //                         }
        //   }) 
     }
    /*=====================================================================*/
	/*
	 *common functions End
	*/

    /* *intialize datepicker */
    /*=====================================================================*/ 
    setDateTimePicker('input[name="due_date"]');
    /*=====================================================================*/ 
    
    /* *set reward point value on click of badge-buttons */
    /*=====================================================================*/ 
	$(document).delegate('body button.point-reward','click',function() {
        $('body form#milestone_Form input[name="points"]').val($(this).attr('data-points'));
    });
    /*=====================================================================*/

    /* *Multi-select */
    /*=====================================================================*/
    $('#agents_list').select2({ placeholder: "Choose elements", width: "100%" });
    /*=====================================================================*/

    /*check all staff agents */
    /*=====================================================================*/
    $("#select-all").click(function() {

        if ($("#select-all").is(':checked')) { //select all
            $("#agents_list").find('option').prop("selected", true);
            $("#agents_list").trigger('change');
        } else { //deselect all
            $("#agents_list").find('option').prop("selected", false);
            $("#agents_list").trigger('change');
        }

    });
    /*=====================================================================*/

    /**Get Trigger on change of category*/
    /*=====================================================================*/
    $('select#milestone_category_id').on('change', function() {
	    
	     let selectedVal = $(this).val();   
	     if(selectedVal != '') {
	     	categoryTriggers(selectedVal);
	     } 
	});
	/*=====================================================================*/
    
    /*=====================================================================*/
	$(document).delegate('#btn_milestone','click',function() {
        
		let selectedMilestoneCategoryVal = $('select#milestone_category_id').val();
		if(!empty(selectedMilestoneCategoryVal)) {
			categoryTriggers(selectedMilestoneCategoryVal);
		}
        $('select#agents_list').val('').select2({ placeholder: "Choose elements",width: "100%"}).trigger('change');
        $('#milestone_Modal #milestone_Form input[name="milestone_id"]').val('');
        $('#milestone_Modal #milestone_Form input[name="action"]').val('add');
        $('#milestone_Modal .modal-header .modal-title').text('Add New Milestone');
        milestoneValidator.resetForm();
        $('#milestone_Form').trigger('reset');
		$('#milestone_Modal').modal('show');
	});
	/*=====================================================================*/
    
    /*Saving milestone*/
    /*=====================================================================*/
	let milestoneValidator = $("#milestone_Form").validate({

        rules: {

            milestone_category_id : { required: true },
            milestone_trigger_id  : { required: true },
            "agents_list[]"       : { required: true },
            points                : { required: true, number: true, range: [1, 5000] },
            due_date              : { required: true }
        },

        submitHandler: function(form) {
           
            let event = window.event;
            event.preventDefault();
            let url = configUrl['milestone-save']; 
        	dynamicAjax(url,'POST',$(form).serialize()).then((response) => {

                getMilestone_List();
                $('#milestone_Modal').modal('hide');

        	}).catch((response) => {
               
                console.log(response);
        	});
        }
    });
    /*=====================================================================*/


    /*Init Datatable*/
    /*=====================================================================*/
     let milestone_table = initDataTable('milestone_table');
    /*=====================================================================*/


    /*Getting milestone*/
    /*=====================================================================*/
    function getMilestone_List(){

        dynamicAjax(configUrl['milestone-list'],'GET').then((response) => {

                milestone_table.clear();

                if(response.status == 1) {

                    if (response.data.length > 0) {

                        $.each(response.data,function(index,record){

                            let triggers = JSON.parse(record.triggers);
                            let milestone_trigger_id = parseInt(record.milestone_trigger_id);
                            let milestone_trigger_name = '';

                            $.each(triggers,function(index,trigger){

                                 if(parseInt(trigger.trigger_id) == milestone_trigger_id) {
                                    milestone_trigger_name = trigger.trigger_name;
                                 }
                            });

                            let action = `<div style="white-space:nowrap">
                                           <a href="javascript:void(0);" class="btn btn-xs btn-warning btn_edt_milestone" data-id="${record.id}">Edit</a>
                                           <a href="javascript:void(0);" class="btn btn-xs btn-danger btn_dlt_milestone" data-id="${record.id}">Delete</a>
                                          </div>`

                            milestone_table.row.add([
                                  record.category_name,
                                  milestone_trigger_name,
                                  record.points,
                                  record.due_date,
                                  action   
                                ])
                        });    
                    }
                }

                milestone_table.draw();

            }).catch((response) => {

                console.log(response);
            });
    }

    $(document).delegate('a[href="#newMtab"]','click',function() { getMilestone_List(); });
    /*=====================================================================*/

    /*Delete Milestone*/
    /*=====================================================================*/
        $(document).delegate('.btn_dlt_milestone','click',function(event) {
           event.preventDefault();

        if (confirm('Are you sure to delete this record ?')) {

            let id = $(this).attr('data-id');

            dynamicAjax(configUrl['milestone-delete'],'POST',{id}).then(() => {

                milestone_table.row($(this).parents('tr')).remove().draw(false);

            }).catch((e) => {


            });
        }

        return false;
    });
    /*=====================================================================*/


    /*Edit Milestone*/
    /*=====================================================================*/
        $(document).delegate('.btn_edt_milestone','click',function(event) {
           event.preventDefault();
           milestoneValidator.resetForm();
           $('#milestone_Form').trigger('reset');

           let id = $(this).attr('data-id');

           dynamicAjax(configUrl['milestone-get'],'POST',{id}).then((response) => {

                if(response.status == 1){

                    let record = response.data;
                    
                    let milestone_id          = parseInt(record.id);
                    let milestone_category_id = parseInt(record.milestone_category_id);
                    let milestone_trigger_id  = parseInt(record.milestone_trigger_id);
                    let active                = record.active;
                    let due_date              = record.due_date;
                    let points                = parseInt(record.points);
                    let agents_list           = JSON.parse(record.agents_list);
                    let timestamp             = Date.parse(due_date);
                    let dateObject            = new Date(timestamp);

                    setDateTimePicker('input[name="due_date"]',dateObject);

                    $('select#milestone_category_id option[value="'+milestone_category_id+'"]').attr("selected", "selected");

                    categoryTriggers(milestone_category_id,milestone_trigger_id);

                    $('input[name="points"]').val(points);

                    if(active == 1)
                    { 
                       $('input[type="checkbox"]').prop('checked',true); 
                    }
                    else 
                    { 
                       $('input[type="checkbox"]').prop('checked',false); 
                    }

                    $('input#select-all').prop('checked',false);
                    $('select#agents_list').val(agents_list).select2({ placeholder: "Choose elements",width: "100%"}).trigger('change');

                    $('#milestone_Modal #milestone_Form input[name="milestone_id"]').val(milestone_id);
                    $('#milestone_Modal #milestone_Form input[name="action"]').val('update');
                    $('#milestone_Modal .modal-header .modal-title').text('Edit Milestone');
                    
                    $('#milestone_Modal').modal('show');
                }

            }).catch((e) => {


            });

           return false;
        });
    /*=====================================================================*/


});