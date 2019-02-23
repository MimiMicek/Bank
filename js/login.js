$('#frmLogin').submit(function(){

  $.ajax({
    method: "POST",
    url: "apis/api-login",
    data: $('#frmLogin').serialize(),
    cache: false,
    dataType: "JSON"
  }).
  done(function(jData){
    if(jData.status == 1){
      swal({
        title:"CONGRATS", text:"You are now logged in", icon: "success",
      });
      setTimeout(function(){location.href = 'profile'}, 3000);  
    }else{
      swal({
        title:"SYSTEM UPDATE", text:"System is under maintenance" + " " + jData.code, icon: "warning",
      });
    }
     
    
  }).
  fail(function(){
    console.log('Error, something failed')
  })
  return false
})