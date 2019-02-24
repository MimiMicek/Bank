$('#frmTransferBetweenAccounts').submit( function(){

  $.ajax({
    method : "GET",
    url : 'apis/api-transfer-between-accounts',
    data :  {
              "fromAccount": $('#txtTransferFromAccount').val(),
              "toAccount": $('#txtTransferToAccount').val(),
              "amount": $('#txtTransferAmount').val()
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
        title:"TRANSFER", text:"You have sent this amount: "+$('#txtTransferAmount').val()+
        " from your " + $('#txtTransferFromAccount').val() +" to this account: "+$('#txtTransferToAccount').val(), icon: "success",
      });
     
    }
    setTimeout(function(){location.href = 'accounts'}, 2000); 
  }).
  fail( function(){
    console.log('FATAL ERROR')
  })

  return false
})




