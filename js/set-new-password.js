$('#frmSetNewPassword').submit(function(){

  $.ajax({
    method: "POST",
    url: "apis/api-set-new-password",
    data: $('#frmSetNewPassword').serialize(),
    cache: false,
    dataType: "JSON"
  }).
  done(function(jData){
    if(jData.status == 0){
      console.log(jData)
      console.log("Password successfully changed!")
    }
    location.href = 'login'
  }).
  fail(function(){
    console.log('Error, something failed')
  })
  return false
})