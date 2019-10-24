

//jQuery time
var current_fs, next_fs, previous_fs; //fieldsets
var left, opacity, scale; //fieldset properties which we will animate
var animating; //flag to prevent quick multi-click glitches
// var temp=0;
// var cont=document.getElementById("soflow").value;


function form_validate(form){

	$.validator.addMethod("text_name",
		function(value, element) {
      return this.optional(element) || /^[a-zA-Z\s.]*$/i.test(value);
    }, "Name is invalid: Please enter a valid name.");

	$.validator.addMethod('phone',
		function(value, element) {
			return this.optional(element) || /^[0-9]*$/i.test(value);
		}, "Enter a valid phone number");

	$.validator.addMethod('reco_name',
		function(value, element) {
			return this.optional(element) || /^.+\s\/\s\d+$/i.test(value);
		}, "Enter a valid Volunteer Name");

	$.validator.addMethod('collection_type',
		function(value,element) {
			var parent = $('#msform');
			var collection = $(parent).find('select#collection_by').val();
			if(collection=='handover_to_mad' && value.length<6) return false;
			else return true;
		},"");

	$.validator.addMethod('self_colletion',
		function(value,element) {
			var parent = $('#msform');
			var collection = $(parent).find('select#collection_by').val();
			var pledge_type = $(parent).find('input#pledge_type').val();
			if(collection== 'self' && pledge_type!= 'online' && value=='') return false;
			else return true;
		},"");

	form.validate({
		ignore:[],
		rules:{
			user_name: {
				required: true,
				maxlength: 30,
				text_name: true
			},
			user_phone:{
				required: true,
				maxlength: 10,
				minlength: 10,
				phone: true
			},
			user_email:{
				required:true,
				email:true
			},
			donor_address:{
				collection_type:true
			},
			donor_pincode:{
				collection_type:true
			},
			collect_on:{
				self_colletion: true
			},
			pledge_type:{
				required: true,
				minlength: 4,
			},
		},
		messages: {
			donor_address: {
				collection_type: "Address is REQUIRED for collections done by MAD",
			},
			donor_pincode: {
				collection_type: "Pincode is REQUIRED for collections done by MAD",
			},
			collect_on:{
				self_colletion: "Please enter Date of Collection",
			},
			pledge_type:{
				required: "Please select the Type of Pledge",
				minlength: "Please select the Type of Pledge",
			},
		}
	});
}


$(".next").click(function(){

	var form = $("#msform");
	form_validate(form);

  if (form.valid() == true){
		if(animating) return false;
		animating = true;
		current_fs = $(this).parent();
		// next_fs = $(this).parent().next();
		if(1){
			next_fs = $(this).parent().next();
		}
		$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

		//show the next fieldset
		next_fs.show();
		//hide the current fieldset with style
		current_fs.animate({opacity: 0}, {
			step: function(now, mx) {
				//as the opacity of current_fs reduces to 0 - stored in "now"
				//1. scale current_fs down to 80%
				// scale = 1 - (1 - now) * 0.2;
				//2. bring next_fs from the right(50%)
				left = (now * 50)+"%";
				//3. increase opacity of next_fs to 1 as it moves in
				opacity = 1 - now;
				current_fs.css({
	        'transform': 'scale('+scale+')',
	        'position': 'absolute'
	      });
				next_fs.css({'left': left, 'opacity': opacity});
			},
			duration: 800,
			complete: function(){
				current_fs.hide();
				animating = false;
			},
			//this comes from the custom easing plugin
			easing: 'easeInOutBack'
		});
  }

});


$('input[type="file"]').change(function(e){
		var id = this.id;
		var count = id.substring(5,6);
		var fileName = '';
		for(var i=0;i < e.target.files.length; i++){
			if(i>0){
				fileName = fileName + ', ';
			}
	    fileName = fileName + e.target.files[i].name;
		}
    document.getElementById('file_name_label_' + count).innerHTML = fileName;
		$('#file_name_label_' + count).show();
  });



$(".previous").click(function(){
	if(animating) return false;
	animating = true;
	current_fs = $(this).parent();
	// if(cont==0){
	// 	previous_fs = $(this).parent().prevAll().eq(2);
	// 	cont=1;
	// 	temp=0;
	// }else{
	// 	previous_fs = $(this).parent().prev();
	// }

	previous_fs = $(this).parent().prev();
	//de-activate current step on progressbar
	$("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

	//show the previous fieldset
	previous_fs.show();
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale previous_fs from 80% to 100%
			scale = 0.8 + (1 - now) * 0.2;
			//2. take current_fs to the right(50%) - from 0%
			left = ((1-now) * 50)+"%";
			//3. increase opacity of previous_fs to 1 as it moves in
			opacity = 1 - now;
			current_fs.css({'left': left});
			previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
		},
		duration: 800,
		complete: function(){
			current_fs.hide();
			animating = false;
		},
		//this comes from the custom easing plugin
		easing: 'easeInOutBack'
	});
});

var more_details = false;

$(".more_details").click(function(){
	if(more_details == false){
		$('.hidden_div').show();
		more_details = true;
		this.innerHTML = "- Hide Details";
	}
	else {
		$('.hidden_div').hide();
		more_details = false;
		this.innerHTML = "+ Add More Details";
	}
});


$('#pincode_ac,#pledged_amount').keypress(function(e){
	var charCode = (e.which) ? e.which : e.keyCode;
  if (charCode != 46 && charCode > 31
    && (charCode < 48 || charCode > 57))
     return false;
  return true;
});

$('#donor_phone').keypress(function(e){
	var charCode = (e.which) ? e.which : e.keyCode;
  if (charCode != 46 && charCode != 43 && charCode != 45 && charCode != 35 && charCode > 31
    && (charCode < 48 || charCode > 57))
     return false;
  return true;
});

$('.donut-data').click(function(){
	var donor_id = this.id;
	alert(this.id);	
});


$('.pledge').click(function(){
	type = this.id;
	//Remove Active class
	$('button.pledge').removeClass('active');
	$('#pledge_type').val(type);

	$('.pledge#'+type).addClass('active');
	$('.hidden_div').hide();
	$('.hidden_div.'+type).show();

	$('.hidden_div.'+type+' ')
})

function submit_form(){
	var form = $("#msform");
	form_validate(form);
	// console.log(form.valid());
	// return false;
	if (form.valid() == true){
		return true;
	}else{
		return false;
	}
}

function validate_upload(){
	var common_task_url = document.getElementById('common_task_url').value;
	var vertical_task_url_1 = document.getElementById('vertical_task_url_1').value;
	var vertical_task_url_2 = document.getElementById('vertical_task_url_2').value;
	var vertical_task_url_3 = document.getElementById('vertical_task_url_3').value;

	var valid_ct = true;
	if(common_task_url) valid_ct = ValidURL(common_task_url);
	var valid_vt1 = ValidURL(vertical_task_url_1);
	var valid_vt3 = ValidURL(vertical_task_url_2);
	var valid_vt2 = ValidURL(vertical_task_url_3);

	if(valid_ct == false){
		$('#common_task_url').addClass('error');
		document.getElementById('ct_url').innerHTML = "Common Task URL is Invalid";
		return false;
	}
	else if(valid_vt1 == false && vertical_task_url_1!=''){
		console.log('Error');
		return false;
	}
	else if(valid_vt2 == false && vertical_task_url_2!=''){
		console.log('Error');
		return false;
	}
	else if(valid_vt3 == false && vertical_task_url_3!=''){
		console.log('Error');
		return false;
	}
	else{
		$('#common_task_url').removeClass('error');
		document.getElementById('ct_url').innerHTML = "";
		return true;
	}

	// if(!valid){
	// 	alert('Incorrect URL for Common Task').
	// 	return false;
	// }
	// else{
	// 	return true;
	// }

}


function ValidURL(str) {
  var regex = /(http|https):\/\/(\w+:{0,1}\w*)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%!\-\/]))?/;
  if(!regex .test(str)) {
    return false;
  } else {
    return true;
  }
}
