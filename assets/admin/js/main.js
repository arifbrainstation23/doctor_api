/*
Copyright (c) 2018
------------------------------------------------------------------
[Master Javascript]
-------------------------------------------------------------------*/
(function ($) {
	"use strict";
	var DoctorDirectory = {
		initialised: false,
		version: 1.0,
		mobile: false,
		init: function () {

			if(!this.initialised) {
				this.initialised = true;
			} else {
				return;
			}

			/*-------------- DoctorDirectory Functions Calling ---------------------------------------------------
			------------------------------------------------------------------------------------------------*/
			this.Custom_scroll();
			this.Nav_dropdown_toggle();
			this.Sidebar_toggle();
			this.Popups();
			this.DataTable();
		},
		
		/*-------------- DoctorDirectory Functions definition ---------------------------------------------------
		---------------------------------------------------------------------------------------------------*/
		OnLessLoad: function(){ // define in on load function
            /* initialize jquery when less loaded start */
            less.pageLoadFinished.then(
                function() {
					/* add class on load start */
					setTimeout(function(){
						$('body').addClass('site_loaded');
					}, 300);
					/* add class on load end */

				}
            );
            /* initialize jquery when less loaded end */
        },
		Custom_scroll: function(){
			/* custom scroll bar start */
			if($(".hs_custom_scrollbar").length){
				$(".hs_custom_scrollbar").mCustomScrollbar({
					scrollInertia:200,
				});
			}
			if($(".hs_custom_scrollbar_x").length){
				$(".hs_custom_scrollbar_x").mCustomScrollbar({
					scrollInertia:200,
					axis:"x"
				});
			}
			/* custom scroll bar end */
		},
		Nav_dropdown_toggle: function(){
			$('.hs_nav_dropdown > a').on('click', function(){
				$('.hs_nav_dropdown > ul').slideUp(200);
				$(this).next().slideDown(200);				
			});
		},
		Sidebar_toggle: function(){
			$('.hs_sidebar_toggle').on('click', function(){
				$('body').toggleClass('sidebar_hide');
			});
		},
		Popups: function(){
			if($('.hs_popup_link').length){
				$('.hs_popup_link').magnificPopup({
					callbacks: {
						open: function() {
							$('body').addClass('open_popup');
						},
						close: function() {
							$('body').removeClass('open_popup');
						}
					}
				});
			}
		},
		DataTable: function(){
			if($('.hs_datatable').length){
				$('.hs_datatable').DataTable({
					responsive: true
				});
			}			
		}
		
		
	};

	

	// Load Event
	$(window).on('load', function() {
		DoctorDirectory.OnLessLoad();
	});

	// ready function
	$(document).ready(function() {
		DoctorDirectory.init();

      toastr.options = {
		"closeButton": true,
		"debug": false,
		"newestOnTop": false,
		"progressBar": false,
		"positionClass": "toast-top-right",
		"preventDuplicates": true,
		"onclick": null,
		"showDuration": "300",
		"hideDuration": "1000",
		"timeOut": "5000",
		"extendedTimeOut": "1000",
		"showEasing": "swing",
		"hideEasing": "linear",
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"
	  }	
    
	 $('body').on('dblclick','.dblclicklang',function(){
		        var currentText = $(this).text();
		        var dataAttr = $(this).attr('data-id');
		        $('#langText').val(currentText);
		        $('#langText').attr('data-db',dataAttr);
		        $('#commonLanguageModel').modal('show');
	 });
	 
	 $('.languageUpdateBtn').on('click',function(){
			var basepath = $('#base_url').val();
			var currentText = $('#langText').val();
			var dataId = $('#langText').attr('data-db');
			var dataArr = {};
			dataArr [ 'currentText' ] = currentText;
			dataArr [ 'dataId' ] = dataId;
			$.post(basepath+"settings/update_languagetext",dataArr,function(data, status) {
				if(data == '1'){
					$('[ data-id = "'+dataId+'" ]').text(currentText);
					toastr.success('Language updated successfully.');
				}
				else {
					toastr.error('Language cannot be updated.');
				}
				$('#commonLanguageModel').modal('hide');
			});
	   });
	   
	   if($( ".timepicker" ).length){
	   $('.timepicker').bootstrapMaterialDatePicker({ 
			format: 'HH:mm',
			clearButton: true,
			date: false
		});
	   }
	   
	   $('#search_year_graph').change(function(){
		  $(this).closest('form').submit();
	   })
	
   
	 
 });
	

})(jQuery);

 
 function add_category(cat_id='' , thiss=''){
	 $('#add_new_category #cateimage').val('');
	 if(cat_id==''){
		 $('#add_new_category .modal-title span').text('Add New') ;
		 $('#add_new_category .modal-body .btn').text('Add');
		 $('#add_new_category #catename').val('');
		 $('#add_new_category #old_cateid').val(0);
	 }else{
		$('#add_new_category .modal-title span').text('Update');
		$('#add_new_category .modal-body .btn').text('Update');
		$('#add_new_category #catename').val($(thiss).attr('data-name'));
		$('#add_new_category #old_cateid').val(cat_id);
		 
	 }
     $('#add_new_category').modal('show');	   
 }
 
 function add_subcategory(sub_id='' , parent_id = '' , thiss){
	 $('#add_new_subcategory #subcateimage').val('');
	 if(sub_id==''){
		 $('#add_new_subcategory .modal-title span').text('Add New') ;
		 $('#add_new_subcategory .modal-body .btn').text('Add') ;
		 $('#add_new_subcategory #sub_catename').val('');
		 $('#add_new_subcategory #old_sub_cateid').val(0);
		 $('#add_new_subcategory #sub_parent').val('');
	 }else{
		$('#add_new_subcategory .modal-title span').text('Update');
		$('#add_new_subcategory .modal-body .btn').text('Update');
		$('#add_new_subcategory #sub_catename').val($(thiss).attr('data-name'));
		$('#add_new_subcategory #old_sub_cateid').val(sub_id);
		 $('#add_new_subcategory #sub_parent').val(parent_id);
		 
	 }
     $('#add_new_subcategory').modal('show');	   
 }
 
 function add_plan(plan_id='' ){
	 
	 if(plan_id==''){
		 $('#add_new_plan .modal-title span').text('Add New') ;
		 $('#add_new_plan #plan_name').val('');
		 $('#add_new_plan #plan_amount').val('');
		 $('#add_new_plan #plan_duration_count').val(1);
		 $('#add_new_plan #plan_duration_type').val('Days');
		 $('#add_new_plan #old_planid').val(0);
	 }else{
		$('#add_new_plan .modal-title span').text('Update');
		var basepath = $('#base_url').val();
		var dataArr = {};
		dataArr [ 'plan_id' ] = plan_id;
		$.post(basepath+"settings/get_plan_detail",dataArr,function(data, status) {
			resp= JSON.parse(data);
			 if(resp['status']==true){ 
			 $('#add_new_plan .modal-title span').text('Update') ;
			      var duration_txt=resp['data']['plan_duration_txt'];
				  var duration_txt = duration_txt.split(" ");
				  
				  $('#add_new_plan #plan_name').val(resp['data']['plan_name']);
				  $('#add_new_plan #plan_amount').val(resp['data']['plan_amount']);
				  $('#add_new_plan #plan_duration_count').val(duration_txt[0]);
				  $('#add_new_plan #plan_duration_type').val(duration_txt[1]);
				  $('#add_new_plan #plan_description').val(resp['data']['plan_description']);
				  $('#add_new_plan #old_planid').val(resp['data']['plan_id']);
				}else{
				  toastr.error(resp['message']); 
			  }
			
		}); 
	 }
     $('#add_new_plan').modal('show');	   
 }
 
 
 function add_speciality(spe_id='' , spe_name=''){
	 $('#add_new_speciality #cateimage').val('');
	 if(spe_id==''){	
		 $('#add_new_speciality .modal-title span').text('Add New') ;
		 $('#add_new_speciality #spename').val('');
		 $('#add_new_speciality #old_speid').val(0);
	 }else{
		$('#add_new_speciality .modal-title span').text('Update');
		$('#add_new_speciality #spename').val(spe_name);
		$('#add_new_speciality #old_speid').val(spe_id);
		 
	 }
     $('#add_new_speciality').modal('show');	   
 }


/********** Update Settings *************/

function updateSettings(commonclass) {
    if( commonclass == 'logoform' ) {
        // image upload
        $('#logoform').submit();
    }
	 else if( commonclass == 'languageSettings' ) {
        // language settings
        var addnewlanguage = ($.trim($('#addnewlanguage').val())).toLowerCase();
        var existinglanguage = $('#existinglanguage').val();
        if( addnewlanguage != '' ) {
            if( existinglanguage.search(addnewlanguage) != '-1' ) {
                // already exists
               toastr.error(addnewlanguage+' is already added.');
                return false;
            }
            else if( existinglanguage.search(' ') != '-1' ) {
                // Space cannot be allowed
                toastr.error('Space is not allowed.');
                return false;
            }
        }
        $('#addnewlanguage').val(addnewlanguage);
        $('#languageForm').submit();
    }
    else if( commonclass == 'add_cate_form' ) {
        // Category Section
        $(this).removeAttr('onlick');
        var err = 0;
        $('.add_cate_form').each(function(){
            if($.trim($(this).val()) == '') {
                err++;
            }
        });

        if(err == 0) {
            $('#add_cate_form').submit();
        }
        else {
            toastr.error("Category name is required");
            
        }

    }
    else if( commonclass == 'add_sub_cate_form' ) {
        // Sub Category Section
        $(this).removeAttr('onlick');
        var err = 0;
        $('.add_sub_cate_form').each(function(){
            if($.trim($(this).val()) == '') {
                err++;
            }
        });

        

        if(err == 0) {
            $('#add_sub_cate_form').submit();
        }
        else {
            $(this).attr('onlick',"updateSettings('add_sub_cate_form')");
			toastr.error("Please, fill in the details.");
        }

    }
	else if( commonclass == 'add_plan_form' ) {
        // Sub Category Section
        $(this).removeAttr('onlick');
        var err = 0;
        $('.add_plan_form').each(function(){
            if($.trim($(this).val()) == '') {
                err++;
            }
        });

        

        if(err == 0) {
            $('#add_plan_form').submit();
        }
        else {
            $(this).attr('onlick',"updateSettings('add_plan_form')");
			toastr.error("Please, fill in the details.");
        }

    }
	else if( commonclass == 'add_spe_form' ) {
        // Sub Category Section
        $(this).removeAttr('onlick');
        var err = 0;
        $('.add_spe_form').each(function(){
            if($.trim($(this).val()) == '') {
                err++;
            }
        });

        

        if(err == 0) {
            $('#add_spe_form').submit();
        }
        else {
            $(this).attr('onlick',"updateSettings('add_spe_form')");
			toastr.error("Please, fill in the details.");
        }

    }
    else {
        var allData = {};
        var dataArr = {};
        $('.'+commonclass).each(function(){
            if( $(this).attr('id').search("_checkbox") != '-1' ) {
                var chk = $('#'+$(this).attr('id')).is(':checked') ? '1' : '0' ;
                allData[ $(this).attr('id') ] = chk;
            }else if ( $(this).attr('id').search("_status") != '-1' ) {
                var chk = $('#'+$(this).attr('id')).is(':checked') ? '1' : '0' ;
                allData[ $(this).attr('id') ] = chk;
            }
            else {
                allData[ $(this).attr('id') ] = $.trim($(this).val()) ;
            }
        });
        var basepath = $('#base_url').val();
        dataArr [ 'updateform' ] = 'yes';
        dataArr [ 'updatedata' ] = JSON.stringify(allData);
        $.post(basepath+"settings/update_settingsdetails",dataArr,function(data, status) {
            if(data == '1'){
                $('.ts_message_popup_text').text('Data updated successfully.');
                 toastr.success("Data updated successfully.");
            }
            else {
                toastr.error("Data can not be updated.");
            }
           
        });
    }
}

/*********** Update basic values of tables STARTS ******************/
function updatethevalue($this,type){
    var dataArr = {};
    var id = $($this).attr('id');

    if( type == 'categories' ) {
        var vlu = $($this).is(':checked') ? '1' : '0' ;
    }
    else {
        var vlu = $($this).val();
    }
	
    var basepath = $('#base_url').val();
    dataArr [ 'id' ] = id;
    dataArr [ 'type' ] = type;
    dataArr [ 'vlu' ] = vlu;
	
	var serverUrl = basepath+"settings/updatethevalue";
    $.post(serverUrl,dataArr,function(data, status) {
    console.log(data);
        if(data == '1'){  
			toastr.success("Data updated successfully");
        }
        else {
			toastr.error("Data can not be updated.");
        }


    });
}
/*********** Update basic values of tables ENDS ******************/

/******** update revenue model STARTS ********/
		    $('#update_revenuemodel').on('click',function(){
				var dataArr = {};
                var planDataArr = {};
		        $(this).text('WAIT');
		        $(this).removeAttr('id');
		        var settingsArr = {};
                $('.revenuefields').each(function(){
                    settingsArr[ $(this).attr('id') ] = $.trim($(this).val()) ;
                });
                var basepath = $('#base_url').val();
                dataArr [ 'updateform' ] = 'yes';
                dataArr [ 'updatedata' ] = JSON.stringify(settingsArr);

                $.post(basepath+"settings/update_settingsdetails",dataArr,function(data, status) {
                    if(data == '1'){
                       toastr.success("Data updated successfully.");
					   $('#update_revenuemodel').text('UPDATE');
		               $('#update_revenuemodel').attr('id','update_revenuemodel');
					   setTimeout(function(){location.reload(); }, 3000);
                    }
                });
  

		    });
		    /******** update revenue model ENDS ********/

 
 
/******************** Delete Language STARTS ********************/

	function delete_selected_language(){
		var basepath = $('#base_url').val();
		
		var t = confirm("Do you really want to delete the language ?");
		if ( t == true ) {
			window.location= basepath+"settings/delete_selected_language/"+$('#lan_to_delete').val();
		}
		return false;
	}
	function delete_clinic(cl_id){
		var basepath = $('#base_url').val();
		
		var t = confirm("Do you really want to delete this clinic ?");
		if ( t == true ) {
			window.location= basepath+"common/delete_clinic/"+cl_id;
		}
		return false;
	}

/******************** Delete Language ENDS ********************/

/************* Payment Settings STARTS *****************/

function updatePaymentSettings(commonclass){
    var dataArr = {};
    var allData = {};
    var err=0;
    $('.'+commonclass).each(function(){

        if( $(this).attr('id').search("_status") != '-1' ) {
            var chk = $('#'+$(this).attr('id')).is(':checked') ? '1' : '0' ;
            dataArr[ $(this).attr('id') ] = chk;
        }
        else {
            if($.trim($(this).val()) == '') {
                err++;
            }
            else {
                dataArr[ $(this).attr('id') ] = $.trim($(this).val()) ;
            }
        }
    });
    if( err != '0' ) {
        $('.ts_message_popup_text').text('Details can not be empty.');
        $('.ts_message_popup').addClass('ts_popup_error');
       
    }
    else {
        var basepath = $('#base_url').val();
        allData [ 'updateform' ] = 'yes';
        allData [ 'updatedata' ] = JSON.stringify(dataArr);
        $.post(basepath+"settings/update_settingsdetails",allData,function(data, status) {
            if(data == '1'){
                toastr.success("Data updated successfully.");
            }
            else {
				toastr.error("Data can not be updated.");
            }
           
        });
    }
}
/************* Payment Settings ENDS *****************/



/************* Get Sub Categories STARTS ****************/
    function getSubCategories($this){
        var cateId = $($this).val();
        if( cateId != '0') {
            var allData = {};
            var basepath = $('#base_url').val();
            allData [ 'cateId' ] = cateId;
             var serverUrl = basepath+"ajax/getSubCategories"; 
            $.post(serverUrl,allData,function(data, status) {
				toastr.success("Check sub category now.");
				$('#user_subcategory').html(data);
			});
        }
        else {
        	toastr.error("Please select a category");
        }
    }
/************* Get Sub Categories ENDS ****************/

/*********** Add / Update Products START  *********************/

function adddoctorbutton($this){
	var email = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
    var mobile = /^[\s()+-]*([0-9][\s()+-]*){6,20}$/;
    var number = /^[\s()+-]*([0-9][\s()+-]*){0,20}$/;
    
    var errCount = 0; 
    $('.required').each(function(){
    	var id_val = $.trim($(this).val());
    	if( id_val == '' || id_val == '0' ) {
			 toastr.error("You missed out some fields.");
    		 errCount++;
			 $(this).focus();
			 return false;
    	}
		if( id_val != '' || id_val != '0' ) {
			var valid = $(this).attr('data-valid'); 
			if(typeof valid != 'undefined'){
				if(!eval(valid).test($(this).val().trim())){
					toastr.error($(this).attr('data-error') , 'Error');
					 errCount++;
					 $(this).focus();
					return false; 
				}
			}
		}
    	
    });
	
	
    if( errCount != 0 ) {  return false;}

    var errCount = 0;
   
	if( errCount == 0 ) {
	  if($('#cl_name').length){
		  $('#add_clinic_form').submit();
	  }else{
		
	   var user_id=$('#user_id').val();
	   var user_email=$('#user_email').val().trim();
       if(user_id!=0){
		   $('#add_user_form').submit();
	   }else{
		    var allData = {};
            var basepath = $('#base_url').val();
            allData [ 'user_email' ] = user_email;
		  $.post(basepath+'ajax/check_user',allData,function(data, status) {
				if(data == 1){
					 $('#add_user_form').submit();
				}
				else {
					 toastr.error("This email already exists,Please try other email ");
				}
			}); 
	   }	   
    }
  }
}


function updateadd(type=""){
	$('#custom_add_form').submit();
	return false;
	var ad_image =$('#ad_image').val();
	var ad_image_chk =$('#ad_image_chk').val();
	if(ad_image !=''){
	var fileExtension = ['jpeg', 'jpg' ,'png' ,'svg'];
		if ($.inArray(ad_image.split('.').pop().toLowerCase(), fileExtension) == -1) {
			toastr.error('Please upload image file');
			$('#ad_image').val('');
			return false;
		}
		
	}else if(ad_image_chk==''){
		toastr.error('Please upload ad image ');
		return false;
	}
	$('#custom_add_form').submit();

}


function delete_user(user_id='',user_level=''){
   var cnf=confirm('Are you sure?');
   if(cnf){
	   var basepath = $('#base_url').val();
	   window.location.href=basepath+'admin/delete_user/'+user_id+'/'+user_level;
   }   
}
function logout(){
	 localStorage.removeItem("user");
	   var base_url = $('#base_url').val();
	 window.location.href=base_url+'home/logout';
 }

