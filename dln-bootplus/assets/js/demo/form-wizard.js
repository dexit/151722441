$(function(){$("#with-progress1").click(function(){$("#with-progress1:checked").is(":checked")?$("#wizard1").find(".progress").fadeIn():$("#wizard1").find(".progress").fadeOut()}),$("#wizard1").wizard({animations:{show:{options:{duration:500},properties:{opacity:"show"}}},stepsWrapper:"#wrapped1",submit:".submit",beforeSelect:function(e,t){var n=$(this).wizard("state").step.find(":input");return!n.length||!!n.valid()},afterSelect:function(e,t){if(t.percentComplete==Infinity||isNaN(t.percentComplete)==1){var n=t.branchStepCount-1,r=t.stepsActivated.length-1;t.percentComplete=r/n*100}$(this).find(".progress .bar").css("width",t.percentComplete+"%");if(t.isLastStep==1){var i=$("#wrapped1").serializeArray();$("#fname").text(i[0].value),$("#lname").text(i[1].value),$("#sgender").text(i[2].value)}}}).wizard("form").submit(function(e){e.preventDefault(),alert("Form submitted!")}).validate({errorPlacement:function(e,t){t.is(":radio")||t.is(":checkbox")?e.insertAfter(t.parent().next()):e.insertAfter(t)}}),$("#with-progress2").click(function(){$("#with-progress2:checked").is(":checked")?$("#wizard2").find(".progress").fadeIn():$("#wizard2").find(".progress").fadeOut()}),$("#wizard2").wizard({animations:{show:{options:{duration:500},properties:{opacity:"show"}}},stepsWrapper:"#wrapped2",submit:".submit",beforeSelect:function(e,t){var n=$(this).wizard("state").step.find(":input");return!n.length||!!n.valid()},afterSelect:function(e,t){if(t.percentComplete==Infinity||isNaN(t.percentComplete)==1){var n=t.branchStepCount-1,r=t.stepsActivated.length-1;t.percentComplete=r/n*100}$(this).find(".progress .bar").css("width",t.percentComplete+"%");if(t.isLastStep==1){var i=$("#wrapped2").serializeArray();$("#fname2").text(i[0].value),$("#lname2").text(i[1].value),$("#sgender2").text(i[2].value)}}}).wizard("form").submit(function(e){e.preventDefault(),alert("Form submitted!")}).validate({errorPlacement:function(e,t){t.is(":radio")||t.is(":checkbox")?e.insertAfter(t.parent().next()):e.insertAfter(t)}}),$("#wizard3").wizard({animations:{show:{options:{duration:500},properties:{opacity:"show"}}},forward:".next",backward:".prev",stepsWrapper:"#wrapped3",submit:".submit",beforeSelect:function(e,t){var n=$(this).wizard("state").step.find(":input");return!n.length||!!n.valid()},afterSelect:function(e,t){var n=t.stepsActivated.length-1,r=$(this).find(".wizard-steps li");t.isLastStep==1?(r.removeClass("active complete").find(".badge").removeClass("badge-info"),r.eq(n).addClass("complete").find(".badge").addClass("badge-info")):(r.removeClass("active complete").find(".badge").removeClass("badge-info"),r.eq(n).addClass("active").find(".badge").addClass("badge-info"))}}).wizard("form").submit(function(e){e.preventDefault(),alert("Form submitted!")}).validate({errorElement:"small",errorPlacement:function(e,t){var n=t.parent();n.is(".controls")?e.appendTo(n):e.appendTo(n.parent()),e.addClass("help-inline")},rules:{firstname:"required",lastname:"required",username:{required:!0,minlength:2},password:{required:!0,minlength:5},confirm_password:{required:!0,minlength:5,equalTo:"#password"},email:{required:!0,email:!0}},messages:{firstname:"Please enter your firstname",lastname:"Please enter your lastname",username:{required:"Please enter a username",minlength:"Your username must consist of at least 2 characters"},password:{required:"Please provide a password",minlength:"Your password must be at least 5 characters long"},confirm_password:{required:"Please provide a password",minlength:"Your password must be at least 5 characters long",equalTo:"Please enter the same password as above"},email:"Please enter a valid email address"}}),$("#wizard4").wizard({animations:{show:{options:{duration:500},properties:{opacity:"show"}}},forward:".next",backward:".prev",stepsWrapper:"#wrapped4",submit:".submit",beforeSelect:function(e,t){var n=$(this).wizard("state").step.find(":input");return!n.length||!!n.valid()},afterSelect:function(e,t){var n=t.stepsActivated.length-1,r=$(this).find(".wizard-steps li");t.isLastStep==1?(r.removeClass("active complete").find(".badge").removeClass("badge-info"),r.eq(n).addClass("complete").find(".badge").addClass("badge-info")):(r.removeClass("active complete").find(".badge").removeClass("badge-info"),r.eq(n).addClass("active").find(".badge").addClass("badge-info"))}}).wizard("form").submit(function(e){e.preventDefault(),alert("Form submitted!")}).validate({errorElement:"small",errorPlacement:function(e,t){var n=t.parent();n.is(".controls")?e.appendTo(n):e.appendTo(n.parent()),e.addClass("help-inline")},rules:{firstname2:"required",lastname2:"required",username2:{required:!0,minlength:2},password2:{required:!0,minlength:5},confirm_password2:{required:!0,minlength:5,equalTo:"#password2"},email2:{required:!0,email:!0}},messages2:{firstname:"Please enter your firstname",lastname:"Please enter your lastname",username:{required:"Please enter a username",minlength:"Your username must consist of at least 2 characters"},password:{required:"Please provide a password",minlength:"Your password must be at least 5 characters long"},confirm_password:{required:"Please provide a password",minlength:"Your password must be at least 5 characters long",equalTo:"Please enter the same password as above"},email:"Please enter a valid email address"}}),$("#nav-wizard1 li a").click(function(e){e.preventDefault()}),$("#wizard5").wizard({animations:{show:{options:{duration:500},properties:{opacity:"show"}}},afterSelect:function(e,t){var n=t.stepsActivated.length-1,r=$("#nav-wizard1 li");r.removeClass("active"),r.eq(n).addClass("active")}}).wizard("form").submit(function(e){e.preventDefault(),alert("Form submitted!")}),$("#nav-wizard2 li a").click(function(e){e.preventDefault()}),$("#wizard6").wizard({animations:{show:{options:{duration:500},properties:{opacity:"show"}}},afterSelect:function(e,t){var n=t.stepsActivated.length-1,r=$("#nav-wizard2 li");r.removeClass("active"),r.eq(n).addClass("active")}}).wizard("form").submit(function(e){e.preventDefault(),alert("Form submitted!")}),$(".syncronize .themes-choice > a, .unsyncronize .themes-navbar > a").on("click",function(e){e.preventDefault();var t=$(this).attr("data-theme");$.each($(".widget"),function(){var e=$(this),n=e.find(".widget-header"),r=e.find(".widget-action");e.is('[class*="border-"]')&&e.attr("class","widget border-"+t),e.is('[class*="bg-"]')&&e.attr("class","widget bg-"+t),n.is('[class*="bg-"]')&&n.attr("class","widget-header bg-"+t),r.is('[class*="color-"]')&&r.attr("class","widget-action color-"+t)})})});