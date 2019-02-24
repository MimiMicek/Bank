$('#frmCreateCard').submit(function(){
  
  $.ajax({
    method: "POST",
    url: "apis/api-create-credit-card",
    data: $('#frmCreateCard').serialize(),
    cache: false,
    dataType: "JSON"
  }).
  done(function(jData){
    if(jData.status == 1){
      swal({
        title:"CONGRATS", text:"You have created a new credit card!", icon: "success",
      });
     /*  setTimeout(function(){location.href = 'login'}, 3000);  */
    }
    if(jData.status == 0){
      console.log("empty")
    }
    /* else{
      swal({
        title:"SYSTEM UPDATE", text:"System is under maintenance " + jData.code, icon: "warning",
      });
    } */
  }).
  fail(function(){
    console.log('error')
  })
  return false
})