/*
Copyright (c) 2018 DoctorListing
------------------------------------------------------------------
[Master Javascript]

Project:	DoctorListing

-------------------------------------------------------------------*/
var base_url = $('#base_url').val();
(function ($) {
	"use strict";
	
	var DoctorListing = {
		initialised: false,
		version: 1.0,
		mobile: false,
		init: function () {

			if(!this.initialised) {
				this.initialised = true;
			} else {
				return;
			}

			/*-------------- DoctorListing Functions Calling ---------------------------------------------------
			------------------------------------------------------------------------------------------------*/
			this.RTL();
			if($('.dd_login').length){
				this.loginTab();
				this.login();
			}
			this.PopUps();
			this.SidebarOpen();
			//this.datepicker();
			
		},
		
		/*-------------- DoctorListing Functions definition ---------------------------------------------------
		---------------------------------------------------------------------------------------------------*/
		RTL: function () {
			// On Right-to-left(RTL) add class 
			var rtl_attr = $("html").attr('dir');
			if(rtl_attr){
				$('html').find('body').addClass("rtl");	
			}		
        },
        loginTab: function(){
            $('.dd_auth_tab_link > ul').each(function(){
                var $active, $content, $links = $(this).find('a');
                $active = $($links.filter('[href="'+location.hash+'"]')[1] || $links[1]);
                $active.addClass('active');
                $content = $($active[0].hash);
                $links.not($active).each(function () {
                $(this.hash).hide();
                });
                $(this).on('click', 'a', function(e){
                    $active.removeClass('active');
                    $content.hide();
                    $active = $(this);
                    $content = $(this.hash);
                    $active.addClass('active');
                    $content.show();
                    e.preventDefault();
                });
            });
        },
        PopUps: function(){
            if($('.dd_popup_link').length){
				$('.dd_popup_link').on('click', function(e){
					e.preventDefault();
					var href = $(this).attr('href');
					$(href).addClass('popup_open');
				});
				$('.dd_popup_close').on('click', function(){
					$('.dd_popup_wrapper').removeClass('popup_open');
				});
				$(document).keydown(function(e) {
					if (e.keyCode == 27) {
						$('.dd_popup_wrapper').removeClass('popup_open');
					}
				});
			}
        },
        SidebarOpen: function(){
			$('.dd_nav_toggle').on('click', function(){
				$('body').removeClass('dd_cat_sidebar_open');
				$('body').toggleClass('dd_sidebar_open');
			});
			$('.dd_category_toggle').on('click', function(){
				$('body').removeClass('dd_sidebar_open');
				$('body').toggleClass('dd_cat_sidebar_open');
			});
			$('.dd_sidebar_close').on('click', function(){
				$('body').removeClass('dd_sidebar_open');
				$('body').removeClass('dd_cat_sidebar_open');
			});
            
        },
		BackToTop: function(){
			//Goto Top
			$(window).scroll(function() {
				if ($(this).scrollTop() > 100) {
					$("#dd_backToTop").addClass('btt_show')
				} else {
					$("#dd_backToTop").removeClass('btt_show')
				}
			});
			$("#dd_backToTop").on("click", function() {
				$("html, body").animate({
					scrollTop: 0
				}, 600);
				return false
			});
		},
		clinic_slider: function(){
			if($('.dd_clinic_slider .owl-carousel').length){
				var $owl = $('.dd_clinic_slider .owl-carousel');
				$owl.children().each( function( index ) {
				  $(this).attr( 'data-position', index ); // NB: .attr() instead of .data()
				});
				$owl.owlCarousel({
					loop:false,
					margin:30,
					smartSpeed:600,
					nav:true,
					navText:['<svg enable-background="new 0 0 129 129" height=28px version=1.1 viewBox="0 0 129 129" width=15px><g><path d="m88.6,121.3c0.8,0.8 1.8,1.2 2.9,1.2s2.1-0.4 2.9-1.2c1.6-1.6 1.6-4.2 0-5.8l-51-51 51-51c1.6-1.6 1.6-4.2 0-5.8s-4.2-1.6-5.8,0l-54,53.9c-1.6,1.6-1.6,4.2 0,5.8l54,53.9z"fill=#ff0000 /></g></svg>','<svg enable-background="new 0 0 129 129" height=28px version=1.1 viewBox="0 0 129 129" width=15px><g><path d="m40.4,121.3c-0.8,0.8-1.8,1.2-2.9,1.2s-2.1-0.4-2.9-1.2c-1.6-1.6-1.6-4.2 0-5.8l51-51-51-51c-1.6-1.6-1.6-4.2 0-5.8 1.6-1.6 4.2-1.6 5.8,0l53.9,53.9c1.6,1.6 1.6,4.2 0,5.8l-53.9,53.9z"fill=#ff0000 /></g></svg>'],
					center: true,
					responsive:{
						0:{
							items:1
						},
						600:{
							items:2
						},
						1000:{
							items:3
						}
					}
				});
				$(document).on('click', '.owl-item>div', function() {
				  $owl.trigger('to.owl.carousel', $(this).data( 'position' ) ); 
				});
			}
			
		},
		datepicker: function(){
			if($( "#datepicker" ).length){
				$( "#datepicker" ).datepicker();
			}
		},
		login: function(){
			/*$('.dd_login').click(function(e){
				e.preventDefault();
				toastr.error('erro');
			});	*/		
		}
		
		
	};

	
	
	$(window).on('load', function() {
		$(".dd_loading_wrapper").delay(350).fadeOut("slow");
		
		var body_h = window.innerHeight;
		$('body').css('height',body_h);
		
		// add class on body
		setTimeout(function(){
			$('body').addClass('dd_site_loaded');
		},1000);
	});

	// Resize Event
	$(window).on('resize', function () {
		var body_h = window.innerHeight;
		$('body').css('height',body_h);
	});
	
	$(window).on('scroll', function () {
		
	});
	
	
  // ready function start
  $(document).ready(function() {
	DoctorListing.init();
	DoctorListing.BackToTop();
	DoctorListing.clinic_slider();

		var header_h = $('.dd_header').innerHeight();
		var titlebar_h = $('.dd_page_title').innerHeight();
		var total_h = titlebar_h + header_h - 70;
		
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
	  if($( ".timepicker" ).length){
	   $('.timepicker').bootstrapMaterialDatePicker({ 
			format: 'HH:mm',
			clearButton: true,
			date: false
		});
	   }
	 /* if($( ".book_datepicker" ).length){
	   $('.book_datepicker').bootstrapMaterialDatePicker({ 
			format: 'YY-MM-DD',
			clearButton: true,
			date: false
		});
	   }*/
	   var d = new Date();
       var datestring = d.getDate()  + "-" + (d.getMonth()+1) + "-" + d.getFullYear();
	   $('.dd_appointment_date').html(datestring);
	   $('.selected_clinic').click(function(){
		   var cl_id=$(this).attr('data-id');
		   var cl_address=$(this).find('.selected_clinic_address').text();
		   $('.dd_clinic_address .dd_clinic_location .cl_address').text(cl_address);
		   $('#cl_id').val(cl_id);
		   $('.book_datepicker').val('');
		   $('.booking_time_slot').val('');
		   $('.dd_time_slot_wrapper').addClass('hide'); 
		   
	   });
	   
	   if($('.book_datepicker').length){
	   $('.book_datepicker').bootstrapMaterialDatePicker({
		   format : 'DD-MM-YYYY',
		   minDate : new Date(),
		   time: false
		   }).on('change', function(e, date){
			 $('.dd_time_slot_wrapper').addClass('hide'); 
			var cl_id=$('#cl_id').val();
			if(cl_id==''){
				toastr.error($('#selectclinic').val());
				$('.book_datepicker').val('');
                 return false;				
			}
			var date = $('.book_datepicker').val()
			
			$('.dd_appointment_date').html(date);
				
		   $.ajax({
				method : 'post',
				url : base_url+'webservice/get_slot',
				data : {'cl_id' : cl_id, 'date' :date }
			}).done(function(resp){
				$('.morning_slot').html('');
				$('.afternoon_slot').html('');
				$('.evening_slot').html('');
				$('.night_slot').html('');
			  if(resp['status']=='true'){
				 $('.dd_time_slot_wrapper').removeClass('hide'); 
				if (typeof resp['data']['morning'] !== 'undefined') {
					var morning=resp['data']['morning'];
					if(morning.length){
						var i=0;
						for (i = 0; i < morning.length; i++) { 
							$( ".morning_slot" ).append( '<li class="booking_slot">'+morning[i] +'</li>' );
						}
					}
                 }
				 
				 if (typeof resp['data']['afternoon'] !== 'undefined') {
					 var afternoon=resp['data']['afternoon'];
					if(afternoon.length){
						var i=0;
						for (i = 0; i < afternoon.length; i++) { 
							$( ".afternoon_slot" ).append( '<li class="booking_slot">'+afternoon[i] +'</li>' );
						}
					}
                 }
				 if (typeof resp['data']['evening'] !== 'undefined') {
					 var evening=resp['data']['evening'];
					if(evening.length){
						var i=0;
						for (i = 0; i < evening.length; i++) { 
							$( ".evening_slot" ).append( '<li class="booking_slot">'+evening[i] +'</li>' );
						}
					}
                 }
				 if (typeof resp['data']['night'] !== 'undefined') {
					var night=resp['data']['night'];
					if(night.length){
						var i=0;
						for (i = 0; i < night.length; i++) {   
							$( ".night_slot" ).append( '<li class="booking_slot">'+night[i] +'</li>' );
						}
					}
                 }
			  }else{
				  alert(resp['message']);
			  }
				
			});
			
			
			//alert($('.book_datepicker').val());
			
			
		  });
	   }
	   
	   
	  
	$(document).on('click' , 'li.booking_slot' , function(){
		   $('li.booking_slot').removeClass('active');
		   $(this).addClass('active');
		   var booking_slot=$(this).html();
		   $('.booking_time_slot').val(booking_slot);
		   
		   $('html, body').animate({scrollTop: $('.dd_btn').offset().top}, 1000);
		   
	  })
	   
	  //submit form on enter
		$("input").keypress(function(event) {
			if (event.which == 13) {  
				event.preventDefault();
				$(this).parent().parent().parent().find('.target-submit').trigger('click');
			}
		});
		
	  //logn section
		$('a[button-type="login"]').click(function(){
			var user_email = $('#login_form #user_email').val().trim();
			var user_pass = $('#login_form #user_pass').val().trim();
			var email_rex = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
            if(user_email == '' || user_pass == ''){
			  toastr.error($('#emptyerr_text').val()); return false;	
			}
            
			if(!email_rex.test(user_email)){
			  toastr.error($('#emailerr_text').val()); return false;	
			}
			var rem = ($('#chk_all').is(':checked'))?1:0;
			blockUi(); 
			$.ajax({
					method : 'post',
					url : base_url+'authentication/login',
					data : {'user_email' : user_email, 'user_pass' : user_pass , 'rem' :rem , 'user_offset' : new Date().getTimezoneOffset()}
				}).done(function(resp){ 
				unblockUi();
					var resp = JSON.parse(resp);
					if(resp['status'] == 'true'){
						location.reload();
						toastr.success(resp['message']); 
					}else{
						toastr.error(resp['message']); 
					}
			});	
		});	
		
		//signup section
		$('a[button-type="signup"]').click(function(){
			var user_name = $('#signup_form #user_name').val().trim();
			var user_email = $('#signup_form #user_emails').val().trim();
			var user_pass = $('#signup_form #user_passs').val().trim();
			var user_cpass = $('#signup_form #user_cpass').val().trim();
			
			var email_rex = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
            
			if(user_name == '' || user_email == '' || user_pass =='' || user_cpass == '' ){
			  toastr.error($('#emptyerr_text').val()); return false;	
			}
			
			if(!email_rex.test(user_email)){
			 toastr.error($('#emailerr_text').val()); return false;
			}
           
			if(user_pass.length < 8){
			  toastr.error($('#pwderr_text').val()); return false;	
			}
			
			if(user_cpass != user_pass){
			  toastr.error($('#repwderr_text').val()); return false;	
			}
			
			$.ajax({
					method : 'post',
					url : base_url+'authentication/signup',
					data : {'user_name' : user_name, 'user_email' : user_email, 'user_pass' : user_pass }
				}).done(function(resp){
					var resp = JSON.parse(resp);
					if(resp['status'] == 'true'){
						toastr.success(resp['message']);
                        setTimeout(function(){ location.reload(); }, 2000);						
					}else{
						toastr.error(resp['message']); 
					}
			});	
		});	
		
		// forget section
		$('a[button-type="forget_pass"]').click(function(){
			var email = $('#forget_email').val().trim();
			var email_rex = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;	
			if(email != ''){
				if(email_rex.test(email)){
					$('#forget_email').parent().removeClass('Error');
					var target = $(this);
					target.addClass('btn_loading');
					$.ajax({
					method : 'post',
					url : base_url+'authentication/fwd_section',
					data : {'email' : email}
				}).done(function(resp){
					var resp = JSON.parse(resp);
					if(resp['status'] == 'true'){
                        toastr.success(resp['message']);
                        setTimeout(function(){ location.reload(); }, 2000); 						
					}else{
						toastr.error(resp['message']); 		
					}
				});
					
				}else{ 
					 toastr.error($('#emailerr_text').val()); return false;
				}
			}else{ 
				toastr.error($('#emptyerr_text').val()); return false;	
			}
		});
		
			// reset section
		$('a[button-type="reset_password"]').click(function(){
			var user_pass = $('#reset_form #users_pwd').val().trim();
			var user_cpass = $('#reset_form #users_repwd').val().trim();
			var user_key = $('#reset_form #user_key').val().trim();
			
			if(user_pass =='' || user_cpass == '' ){
			 toastr.error($('#emailerr_text').val()); return false;	
			}
			if(user_pass.length < 8){
			   toastr.error($('#pwderr_text').val()); return false;	
			}
			
			if(user_cpass != user_pass){
			  toastr.error($('#repwderr_text').val()); return false;	
			}
			var target = $(this);
				target.addClass('btn_loading');
				$.ajax({
				method : 'post',
				url : base_url+'authentication/update_password',
				data : {'user_pass' : user_pass, 'user_key' : user_key}
			}).done(function(resp){
				var resp = JSON.parse(resp);
				if(resp['status'] == 'true'){
					toastr.success(resp['message']); 
                    
                  setTimeout(function(){ window.location.href=base_url+'authentication/'; }, 2000);  					
				}else{
					toastr.error(resp['message']); 		
				}
			});
					
		});
	
	if($('div.dd_access_doctor_data').length){
		accessDataUsingAjax();
	}
    
	$(document).on('click' , 'div.dd_fav_pagination ul li a' , function(){
		var _this = $(this);
		$('#fav_form #formKey').val( _this.parent().attr('data-value'));
	    $('#fav_form').trigger('submit');
	});
	
	$(document).on('click' , 'div.dd_home_pagination ul li a' , function(){
		var _this = $(this);
		$('#search_form #formKey').val( _this.parent().attr('data-value'));
	    $('#search_form').trigger('submit');
	});

	$('#search_form').submit(function(e){
	   e.preventDefault();
	   var _this = $(this);
	   var formdata = new FormData(_this[0]);
	   accessDataUsingAjax(formdata);
   })
   $('a.list_sub_cate').click(function(){
	   $('a.list_sub_cate').removeClass('active');
	   var _this = $(this);
	   _this.addClass('active');
	   $('#search_form #formKey').val('');
       $('#search_form #sub_cat').val( _this.attr('data-subid'));
	   $('#search_form').trigger('submit');
	  
	   $('html, body').animate({scrollTop: $('.dd_doctor_list_wrapper').offset().top}, 1000);
      
   })
   
   $(document).on('click' , 'div.dd_filter_wrapper ul li a' , function(){
		var _this = $(this);
		$('div.dd_filter_wrapper ul li a').removeClass('active');
		_this.addClass('active');
		$('#search_form #order_by').val( _this.attr('data-order'));
	    $('#search_form').trigger('submit');
	});
	
	function accessDataUsingAjax(data=''){ 
		$.ajax({
			method : 'post',
			data : data,
			processData: false,
			contentType: false,
			url : base_url+'home/access_doctor_data',
			success : function(resp){
				var respData = JSON.parse(resp);
				if(respData['status'] == 'true'){
					//$('.countData').html(respData['countData']);
					$('.dd_pagination').html(respData['paginnation']);
					//$('tbody#ajaxRespBody').html(respData['data']);
					$('div.dd_access_doctor_data').html(respData['data']);
					    
					
				}else{
					toastr.error($('#somethingwentwrong').val());
				}
			},
			error : function(){
				
				toastr.error($('#somethingwentwrong').val());
			}
		});
	}	

	
   $('.dd_input_search').keyup(function(){
     var keywords=$(this).val();

     if(keywords.length>1){
          var allData = {};       
          
          allData ['keywords'] = keywords;
          $.post(base_url+"home/autosearch",allData,function(data, status) {
              var respData = JSON.parse(data);
			  $('.dd_search_result ul').html(respData['data']);
				
        });
		$('.dd_search_box_wrapper, .dd_search_box_inner').addClass('search_result_open');
        
       }else{
         $('.lk_autocomp_box').html('');   
       }
  });

  $(document).click(function (e){
    var container = $(".dd_search_result,.dd_input_search");
    if (!container.is(e.target) 
        && container.has(e.target).length === 0) {
			if($('.dd_search_box_inner').length > 0){
            $('.dd_search_box_wrapper, .dd_search_box_inner').removeClass('search_result_open');
        	}
		}
		
     });
	 
 /* $('.user_profile_upload').keyup(function(){
	  
  });*/
  $('.user_profile_upload').on("change",function () {
	var fileExtension = ['jpeg', 'jpg'];
	if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
		toastr.error('Please upload jpeg ,jpg ');
		$(this).val('');
		return false;
	}else{
		$('#update_profilepic_form').submit();
	}	  
 });
  
  $('.dd_remove_image').on("click",function () {
	  var cnf=confirm($('#remove_img').val());
    var basepath = $('#base_url').val();
	if(cnf){
	window.location = basepath+"user/remove_profile_image";
	}
 });
 
 
 $("#start_booking").change(function() {
    var thiss=$(this);
	if(this.checked) {
      var value='yes'
    }else{
		var value='no';
	}
	$.ajax({
		method : 'post',
		url : base_url+'common/start_booking',
		data : {'status' : value }
	}).done(function(resp){
	  if(resp['status']=='true'){ 
		  toastr.success(resp['message']);
	  }else{
		  toastr.error(resp['message']); 
	  }
		
	});
		
 });
 
 $(".canceled_appointment").change(function() {
   var thiss=$(this);
   var apo_id =thiss.attr('data-apoid');
	if(this.checked) {
      var type='rebook';
	   var type_message=$('#rebook_appointment').val();
	  var apo_status=1;
    }else{
		var type='cancel';
	    var type_message=$('#cancel_appointment').val();
		var apo_status=0;
	}
	
  var cnf=confirm(type_message);
  if(cnf){
	$.ajax({
		method : 'post',
		url : base_url+'webservice/canceled_appointment',
		data : {'apo_status' : apo_status , 'apo_id' : apo_id }
	}).done(function(resp){
	  if(resp['status']=='true'){ 
		  toastr.success(resp['message']);
	  }else{
		  toastr.error(resp['message']); 
	  }
		
	});
  }else{
	  if(apo_status==0){thiss.prop('checked', true);}else{thiss.prop('checked', false);
	  }
  }
	
 });
 
 $(".clinic_status").change(function() {
  var cl_status=0;
  if(this.checked) {var cl_status=1;}
   var thiss=$(this);
   var cl_id =thiss.attr('data-clid');
   $.ajax({
		method : 'post',
		url : base_url+'common/clinic_status',
		data : {'cl_status' : cl_status , 'cl_id' : cl_id }
	}).done(function(resp){
	   toastr.success(resp['message']);
	});
  
 });
 
 

	
	
 });// ready function end

	
})(jQuery);
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

function updateprofile($this){
	var email = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
    var mobile = /^[\s()+-]*([0-9][\s()+-]*){6,20}$/;
    var number = /^[\s()+-]*([0-9][\s()+-]*){0,20}$/;
    
    var errCount = 0;
   
	
    
    $('.required').each(function(){
    	var id_val = $.trim($(this).val());
    	if( id_val == '' || id_val == '0' ) {
			 toastr.error($('#emptyerr_text').val());
    		 errCount++;
			 $(this).focus();
			 return false;
    	}
		if( id_val != '' || id_val != '0' ) {
			var valid = $(this).attr('data-valid'); 
			if(typeof valid != 'undefined'){
				if(!eval(valid).test($(this).val().trim())){
					toastr.error($(this).attr('data-error') );
					 errCount++;
					 $(this).focus();
					return false; 
				}
			}
		}
    	
    });
	
    if( errCount != 0 ) {  return false;}
	if( errCount == 0 ) { $('#update_profile_form').submit();}
}

/**************** User to Doctor Process STARTS *******************/
    function become_a_doctor(){
		 var basepath = $('#base_url').val();
        var tnc_chek = $('#tnc:checked').length;
        if(tnc_chek == '1') {
			window.location = basepath+"user/complete_doctor";
        }
        else {
          toastr.error($('#accept_termsmsg').val());
        }
    }
/**************** User to Vendor Process ENDS *******************/

/**************** Book appointment STARTS *******************/
function book_apointment(){
	
	var date=$('#booking_date').val();
	var timing=$('#booking_time_slot').val();
	var cl_id=$('#cl_id').val();
	var timeoffset = new Date().getTimezoneOffset();
	if(date=='' || timing=='' || cl_id==''){
	   toastr.error("You missed out some fields.");
       return false;	
	}
	
	$.ajax({
				method : 'post',
				url : base_url+'webservice/book_appointment',
				data : {'cl_id' : cl_id, 'date' :date ,'timing' :timing , 'timeoffset' :timeoffset }
			}).done(function(resp){
				
			  if(resp['status']=='true'){ 
				  toastr.success(resp['message']);
				  setTimeout(function(){  window.location.href=base_url+'appointments'; }, 1000);
				 
			  }else{
				  toastr.error(resp['message']); 
			  }
				
			});
	
}
/**************** Book appointment Ends *******************/

function remove_favourite(doc_id , thiss=''){
	var thiss=$(thiss);
	$.ajax({
		method : 'post',
		url : base_url+'common/remove_favourite',
		data : {'doctor_id' : doc_id}
	}).done(function(resp){
        toastr.success(resp['message']);
		thiss.removeClass('active');
		thiss.attr('onclick' , 'add_favourite('+doc_id+' , this)');
		
	});
	
}

function add_favourite (doc_id , thiss=''){
	var thiss=$(thiss);
	$.ajax({
		method : 'post',
		url : base_url+'common/add_favourite',
		data : {'doctor_id' : doc_id} 
	}).done(function(resp){
		if(resp['status']=='true'){	
        toastr.success(resp['message']);
		thiss.addClass('active');
		thiss.attr('onclick' , 'remove_favourite('+doc_id+' , this)');
		
		}else{
			window.location=base_url+'authentication';
		}
	});
	
}

function addclinic($this){
	var email = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
    var mobile = /^[\s()+-]*([0-9][\s()+-]*){6,20}$/;
    var number = /^[\s()+-]*([0-9][\s()+-]*){0,20}$/;
    
    var errCount = 0; 
    $('.required').each(function(){
    	var id_val = $.trim($(this).val());
    	if( id_val == '' || id_val == '0' ) {
			 toastr.error($('#emptyerr_text').val());
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
	$('#add_clinic_form').submit();
  }
}

function add_review(){
	var errCount = 0; 
    $('.r_required').each(function(){
    	var id_val = $.trim($(this).val());
    	if( id_val == '' || id_val == '0' ) {
			 toastr.error($('#emptyerr_text').val());
    		 errCount++;
			 $(this).focus();
			 return false;
    	}
    });
	if( errCount == 0 ) {
		$.ajax({
				method : 'post',
				url : base_url+'Common/add_review',
				data : {'doctor_id' : $('#rat_doctor_id ').val(), 'rating' : $('#rat_rating ').val() ,'comment' :$('#rat_comment ').val() }
			}).done(function(resp){
			  if(resp['status']=='true'){ 
				  toastr.success(resp['message']);
				 setTimeout(function(){ location.reload();}, 1000);
			  }else{
				  toastr.error(resp['message']); 
			  }
				
			});
     }
	
}

if($('#map_canvas').length >0){
//<![CDATA[
			/*window.onload=function(){
			var map;
			function initialize() {
			var lat=document.getElementById("latitute").value ;
			var longt= document.getElementById("longtitute").value;
			var myLatlng = new google.maps.LatLng(lat,longt);

			var myOptions = {
			zoom: 16,
			center: myLatlng,
			mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

			var marker = new google.maps.Marker({
			draggable: true,
			position: myLatlng,
			map: map,
			title: "Your location"
			});

			google.maps.event.addListener(marker, 'dragend', function (event) {
			document.getElementById("latitute").value = event.latLng.lat();
			document.getElementById("longtitute").value = event.latLng.lng();
			
			});
			}
			google.maps.event.addDomListener(window, "load", initialize());
			}//]]>*/
			
		var markers = [];
	    var lat=document.getElementById("latitute").value ;
	    var longt= document.getElementById("longtitute").value;
        var myLatlng = new google.maps.LatLng(lat,longt);
        var myOptions = {
		  zoom: 15,
		  center: myLatlng,
		  mapTypeId: google.maps.MapTypeId.ROADMAP
		}

        var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
        addMarker(myLatlng, 'Default Marker', map);
		
		// Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
		if(input){
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
		
		
		searchBox.addListener('places_changed', function() {
		
          var places = searchBox.getPlaces();
		 
		   var bounds = new google.maps.LatLngBounds();
		   places.forEach(function(place) {
		   if (!place.geometry) {
		   return ;
		   }else{
			  var new_lat= place.geometry.location.lat();
			  var new_long=place.geometry.location.lng();
			  var myLatlng = new google.maps.LatLng(new_lat,new_long);
			  document.getElementById("latitute").value = new_lat;
		      document.getElementById("longtitute").value = new_long;
			  addMarker(myLatlng, 'Default Marker', map);
			}
			 if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
		    return false;
		   });
		   map.fitBounds(bounds);
		
		});
		}
		
     
	  function addMarker(latlng,title,map) {
		  var draggable=true;
		   if($('#no_dragend').length){
			   var draggable=false;
		   }
		  
	     DeleteMarkers();
		var marker = new google.maps.Marker({
				position: latlng,
				map: map,
				title: title,
				draggable:draggable
		});
	  
       marker.addListener('dragend', handleEvent);
	   markers.push(marker);
     }
	
	 function DeleteMarkers() {
        for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(null);
        }
        markers = [];
     };
 

	function handleEvent(event) {
		document.getElementById("latitute").value = event.latLng.lat();
		document.getElementById("longtitute").value = event.latLng.lng();
	}

}

 function plan_purchase(plan_id=''){
	 var payment_method = 'paypal';
	 	$.ajax({
				method : 'post',
				url : base_url+'ajax/plan_purchase',
				data : {'plan_id' : plan_id , 'payment_method' : payment_method }
			}).done(function(resp){
				if(resp['status']==false){
					toastr.error(resp['message']); 
					var reason=resp['data'];
					if(reason=='login'){
						window.location.href=base_url+'authentication';
					}
					
				}else{
					$('#pay_form_box').html(resp['data']);
					if(payment_method=='paypal'){
						$('form[name="pay_form_name"]').submit();
					}
					
				}
			  
			});
 }
 
 function chat(login='shahbaj'){
	// localStorage.setItem("user_name", "Virend");
	//localStorage.setItem("user_email", "virendra@gmail.com"); 
	
	 $.ajax({
				method : 'post',
				url :'http://phpstack-104300-399413.cloudwaysapps.com/new_dev/chats/',
				data : {'item' : 'true'  }
		}).done(function(resp){
			chat1(login)
		});
 }
 
 function chat1(login){
	 blockUi();
	$.ajax({
			method : 'post',
			url : base_url+'webservice/getUserID',
			data : {'login' : login  }
		}).done(function(resp){
			unblockUi();
			console.log(resp);
			if(resp!=0){
			 localStorage.setItem("chatID", resp);
			 localStorage.setItem("chatEL", login);
			var myWindow=   window.open(base_url+"chats/#!/dialog/create",'windowOpenTab', 'scrollbars=1,resizable=1,width=500,height=500,left=0, top=0');
			   //window.location.href="http://phpstack-104300-399413.cloudwaysapps.com/new_dev/chats/#!/dialog/create";
			    myWindow.moveTo(1000, 300);                                  // Moves the new window    
               myWindow.focus();           
			}else{
				toastr.error($('#notonchat').val()); 
			}
			
			
		  
		});
 }
 
 function blockUi(){
	//$('.dd_loading_wrapper').addClass('hide');
	$('.dd_loading_wrapper').css("display", ""); 
	 
 }
 function unblockUi(){
	$('.dd_loading_wrapper').css("display", "none"); 
 }
 
 function logout(){
	 localStorage.removeItem("user");
	 window.location.href=base_url+'home/logout';
 }
 

