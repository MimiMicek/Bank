$('#frmLogin').submit(function(){

  $.ajax({
    method: "POST",
    url: "apis/api-login",
    data: $('#frmLogin').serialize(),
    cache: false,
    dataType: "JSON"
  }).
  done(function(jData){
    if(jData.status == 0){
      console.log(jData)
    }
    location.href = 'profile'
  }).
  fail(function(){
    console.log('Error, something failed')
  })
  return false
})