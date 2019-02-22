$('#frmChangePassword').submit(function(){

  $.ajax({
    method: "POST",
    url: "apis/api-change-password",
    data: $('#frmChangePassword').serialize(),
    cache: false,
    dataType: "JSON"
  }).
  done(function(jData){
    if(jData.status == 0){
      console.log(jData)
      console.log("Password successfully changed!")
    }
    location.href = 'profile'
  }).
  fail(function(){
    console.log('Error, something failed')
  })
  return false
})