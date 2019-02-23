$('#frmSignup').submit(function(){
  
  $.ajax({
    method: "POST",
    url: "apis/api-signup",
    data: $('#frmSignup').serialize(),
    cache: false,
    dataType: "JSON"
  }).
  done(function(jData){
    if(jData.status == 1){
      swal({
        title:"CONGRATS", text:"You have signed up", icon: "success",
      });
      setTimeout(function(){location.href = 'login'}, 3000); 
    }else{
      swal({
        title:"SYSTEM UPDATE", text:"System is under maintenance" + " " + jData.code, icon: "warning",
      });
    }
  }).
  fail(function(){
    console.log('error')
  })
  return false
})