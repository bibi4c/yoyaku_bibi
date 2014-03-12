function listUserSchedule(event, obj, time, date, courseName) {
  if(event.preventDefault){
	event.preventDefault();
  }else{
	event.returnValue = false; 
  };
  $.ajax({
    cache: false,
    type: 'POST',
    url: 'appointment_manager/getUserSchedule',
    data: {schedule_id : obj.id,time : time, date : date, courseName : courseName},
    dataType: 'JSON',
    success: function(data) {
      if (parseInt(data.isOK)) {
        var html = '';
        var aryUserRes1 = new Array();
        var aryUserRes2 = new Array();
        var j = 0;
        var tmpUserName = '';
        html += '<div style="width: 500px"> <span style="font-size: 20px;"><b>コース予約者一覧</b></span><br>';
        html += '<table style="background-color: #fff; border: 0">';
        html += '<tbody>';
        html += '<tr>';
        html += '<td style="width: 33%; text-align: left !important; border: 0">'+data.date+'</td>';
        html += '<td style="width: 33%; text-align: left !important; border: 0">'+data.time+'</td>';
        html += '<td style="text-align: left !important; border: 0">'+data.courseName+'</td>';
        html += '</tr>';  
        html += '</tbody>';
        html += '</table>';
        html += '<dl class="dl-horizontal" style="margin-top: 0;">';
        html += '<table style="background-color: #fff;">';
        html += '<tbody>';
        for(var i in data.aryUserRes1){
          aryUserRes1[j] = data.aryUserRes1[i].name;
          j++;
        }
        var j = 0;
        for(var i in data.aryUserRes2){
          aryUserRes2[j] = data.aryUserRes2[i].name;
          j++;
        }
        for(var i= 0; i < 15; i++){
          html += '<tr>';
          html += '<td style="width: 10%">'+(parseInt(i)+1)+'</td>';
          html += '<td style="width: 40%;text-align:left; height: 25px;">';
          tmpUserName = '';
          if(typeof (aryUserRes1[i]) != 'undefined'){
            tmpUserName = aryUserRes1[i];
          }
          html += tmpUserName + '</td>';
          html += '<td style="width: 10%">'+(parseInt(i)+16)+'</td>';
          html += '<td style="width: 40%;text-align:left; height: 25px;">';
          tmpUserName = '';
          if(typeof (aryUserRes2[i]) != 'undefined'){
            tmpUserName = aryUserRes2[i];
          }
          html += tmpUserName + '</td>';
          html += '</tr>';
        }
        html += '</tbody>';
        html += '</table>';
        html += '</dl>';
        html += '</div>';
        jQuery('#showUserSchedule').html(html);
      } else {
        jQuery('#showUserSchedule').html('');
      }
    }
  });
}

function listByWeek(numberWeek,year){
  $.ajax({
    cache: false,
    type: 'POST',
    url: 'manager/index',
    data: {ajax : 1,numberWeek : numberWeek, year : year},
    dataType: 'JSON',
    success: function(data) {
      if (parseInt(data.isOK)) {
        $('#areaContent').html(data.tplIndex);
      } else {
        $('#areaContent').html(data.msgError);
      }
    }
  });
}
