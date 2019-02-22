$('#frmForgotPassword').submit( function(){

  $.ajax({
    method : "GET",
    url : 'apis/api-forgot-password',
    data :  {
              "phone": $('#txtForgotPasswordPhone').val()
            },
    cache: false,
    dataType:"JSON"
  }).
  done( function(jData){
    if(jData.status == -1){
      console.log('*************')
      console.log(jData)
    }

    if(jData.status == 0){
      console.log('*************')
    } // end of 0 case

    if(jData.status == 1){
      console.log('*************')
      console.log(jData)
     }
  }).
  fail( function(){
    console.log('FATAL ERROR')
  })

  return false
})



