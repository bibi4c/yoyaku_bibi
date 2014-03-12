$(function(){
  $('.activeBgUser').live('click',function(){
    var scheduleId = this.id.split('_')[1];
    var strUpdTotal = $('#updTotal_'+scheduleId).text();
    var elmUpdTotal = strUpdTotal.split('/');
    $('#updTotal_'+scheduleId).text((parseInt(elmUpdTotal[0]) - 1) + '/' + elmUpdTotal[1]);
    this.className = 'inactiveBgUser';
    $('tr[id=appoint_id_'+this.id+'] td:eq(1)').text('');
    $('tr[id=appoint_id_'+this.id+'] td:eq(2)').text('');
    $('tr[id=appoint_id_'+this.id+']').attr('id','unappoint_id_'+this.id.split('_')[0]+'_');
  });
  
  $('.inactiveBgUser').live('click',function(){
    var courseId = this.id.split('_')[0];
    var scheduleId = this.id.split('_')[1];
    
    // call ajax check full course
    $.ajax({
		cache: false,
		type: 'POST',
		url: 'user/checkFullCourse',
		data: {ajax : 1,scheduleId : scheduleId, courseId : courseId},
		dataType: 'JSON',
		success: function(data) {
			var courseId = data.courseId;
			var scheduleId = data.scheduleId;
			if (parseInt(data.isOK)) {
				$('#updTotal_'+scheduleId).text(data.maxMembers + '/' + data.maxMembers);
				//$('td[id='+courseId+'_'+scheduleId+']').removeClass('inactiveBgUser').removeClass('activeBgUser').addClass('disabledBg');
				alert(data.msgError);
				return false;
			}else{
				var strUpdTotal = $('#updTotal_'+scheduleId).text();
				var elmUpdTotal = strUpdTotal.split('/');
				var tmpActiveScheduleId = 0; var tmpElmUpdTotal = 0;
				$('td[id^='+courseId+'_]').each(function(){
				  if(this.className == 'activeBgUser'){
					tmpActiveScheduleId = this.id.split('_')[1];
					strUpdTotal = $('#updTotal_'+tmpActiveScheduleId).text();
					tmpElmUpdTotal = strUpdTotal.split('/');
					$('#updTotal_'+tmpActiveScheduleId).text((parseInt(tmpElmUpdTotal[0]) - 1) + '/' + tmpElmUpdTotal[1]);
				  }
				});
				$('td[id^='+courseId+'_]').each(function(){
					if(this.className == 'activeBgUser'){
						$('#'+this.id).removeClass('activeBgUser').addClass('inactiveBgUser');	
					}
				});
				$('#updTotal_'+scheduleId).text((parseInt(elmUpdTotal[0]) + 1) + '/' + elmUpdTotal[1]);
				$('td[id='+courseId+'_'+scheduleId+']').removeClass('inactiveBgUser').addClass('activeBgUser');
				$('tr[id^=unappoint_id_'+courseId+'_]').attr('id','appoint_id_'+courseId+'_'+scheduleId);
				$('tr[id^=appoint_id_'+courseId+'_]').attr('id','appoint_id_'+courseId+'_'+scheduleId);
				$('tr[id=appoint_id_'+courseId+'_'+scheduleId+'] td:eq(1)').text($('#ScheduleDate'+scheduleId).val());
				$('tr[id=appoint_id_'+courseId+'_'+scheduleId+'] td:eq(2)').text($('#ScheduleTime'+scheduleId).val());	
			}
		}
	});
  });
});  

function listByWeek(numberWeek,year){
  $.ajax({
    cache: false,
    type: 'POST',
    url: 'user/index',
    data: {ajax : 1,numberWeek : numberWeek, year : year},
    dataType: 'JSON',
    success: function(data) {
      if (parseInt(data.isOK)) {
        $('#areaContent').html(data.tplIndex);
        var aryAppointmentSelect = new Array();
        var aryAppointmentCurrSelect = new Array();
        // set active background
        $('tr[id^=appoint_id_]').each(function(i){
          aryAppointmentSelect[i] = this.id.split('appoint_id_')[1];
        });
        
        $('.activeBgUser').each(function(i){
          aryAppointmentCurrSelect[i] = this.id;
        });
        var numSelect = aryAppointmentSelect.length;
        var numCurrSelect = aryAppointmentCurrSelect.length;
        if(numSelect > 0){
            for(var j=0; j < numCurrSelect; j++){
              if($.inArray(aryAppointmentCurrSelect[j],aryAppointmentSelect) == -1){
                $('td[id='+aryAppointmentCurrSelect[j]+']').removeClass('activeBgUser').addClass('inactiveBgUser');
                var tmpScheduleId = aryAppointmentCurrSelect[j].split('_')[1];
                var strUpdTotal = $('#updTotal_'+tmpScheduleId).text();
                var elmUpdTotal = strUpdTotal.split('/');
                $('#updTotal_'+tmpScheduleId).text((parseInt(elmUpdTotal[0]) - 1) + '/' + elmUpdTotal[1]);
              }
            }
            for(var j=0; j < numSelect; j++){
              if($('td[id='+aryAppointmentSelect[j]+']').hasClass('inactiveBgUser')){
                $('td[id='+aryAppointmentSelect[j]+']').removeClass('inactiveBgUser').addClass('activeBgUser');
                var tmpScheduleId = aryAppointmentSelect[j].split('_')[1];
                var strUpdTotal = $('#updTotal_'+tmpScheduleId).text();
                var elmUpdTotal = strUpdTotal.split('/');
                $('#updTotal_'+tmpScheduleId).text((parseInt(elmUpdTotal[0]) + 1) + '/' + elmUpdTotal[1]);
              }
            }
        }else{
          for(var j=0; j < numCurrSelect; j++){
            if($.inArray(aryAppointmentCurrSelect[j],aryAppointmentSelect) == -1){
              $('td[id='+aryAppointmentCurrSelect[j]+']').removeClass('activeBgUser').addClass('inactiveBgUser');
              var tmpScheduleId = aryAppointmentCurrSelect[j].split('_')[1];
              var strUpdTotal = $('#updTotal_'+tmpScheduleId).text();
              var elmUpdTotal = strUpdTotal.split('/');
              $('#updTotal_'+tmpScheduleId).text((parseInt(elmUpdTotal[0]) - 1) + '/' + elmUpdTotal[1]);
            }
          }
        }
      } else {
        $('#areaContent').html(data.msgError);
      }
    }
  });
}

function saveAppointSchedule(){
  var aryCourseSchedule = new Array();
  var strCourseSchedule = '';
  jQuery('table[id=areaAppointment] tr[id^=appoint_id_]').each(function(i){
     aryCourseSchedule[i] = this.id.split('appoint_id_')[1];
  });
  if(aryCourseSchedule.length > 0){
    strCourseSchedule = aryCourseSchedule.join(',');
  }
  var cfm = window.confirm("コースを保存してもよろしいですか?");
  if (!cfm) {
    return false;
  }
  $.ajax({
    cache: false,
    type: 'POST',
    url: 'user/saveAppointSchedule',
    data: {ajax : 1,strCourseSchedule : strCourseSchedule},
    dataType: 'JSON',
    success: function(data) {
        alert(data.msgError);
        if (parseInt(data.isOK) == 2) {
			window.location.reload();
		} 
    }
  });
}
