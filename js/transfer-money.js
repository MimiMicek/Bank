$('#frmTransfer').submit( function(){

  $.ajax({
    method : "GET",
    url : 'apis/api-transfer',
    data :  {
              "phone": $('#txtTransferToPhone').val(),
              "amount": $('#txtTransferAmount').val(),
              "message": $('#txtTransferMessage').val()
            },
    cache: false,
    dataType:"JSON"
  }).
  done( function(jData){
    if(jData.status == -1){
      console.log('*************')
      console.log(jData)
    }

    //if the phone does not exit in my systemm, but still is valid - get list of banks 
    if(jData.status == 0){
      console.log('*************')
    } // end of 0 case

    if(jData.status == 1){
      console.log('*************')
      console.log(jData)
      // TODO: Continue with a local transfer
      swal({
        title:"TRANSFER", text:"You have sent this amount: "+$('#txtTransferAmount').val()+" to this phone: "+$('#txtTransferToPhone').val(), icon: "success",
      });
    }
  }).
  fail( function(){
    console.log('FATAL ERROR')
  })

  return false
})




