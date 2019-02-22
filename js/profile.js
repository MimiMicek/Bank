function fnvGetBalance(){
  var money = new Audio('money.mp3')
  setInterval(function(){
    $.ajax({
      method: "GET",
      url: 'apis/api-get-balance',
      cache: false
    })//get a string, not json
    .done(function( sBalance ){
      // console.log(sBalance)
      // console.log($('#lblBalance').text() )
      //play sound if the balance changes
      if( sBalance != $('#lblBalance').text() ){
          $('#lblBalance').text(sBalance)
          money.play()
          //try to change the balance in clients.json
      }
    }).fail(function(){})


    $.ajax({
      method : "GET",
      url : 'apis/api-get-transactions-not-read',
      cache : false,
      dataType : "JSON"
    }).done(function( jTransactions ){

      for( let jTransactionKey in jTransactions ){
        console.log(jTransactionKey)
        let jTransaction = jTransactions[jTransactionKey] // get object from key
        let date = jTransaction.date
        let amount = jTransaction.amount
        let name = jTransaction.name
        let lastName = jTransaction.lastName
        let fromPhone = jTransaction.fromPhone
        let message = jTransaction.message
        
        // string literals
        let sTransactionTr = 
               
        `<tr>
        <td>${jTransactionKey}</td>
        <td>${date}</td>
        <td>${amount}</td>
        <td>${name}</td>
        <td>${lastName}</td>
        <td>${fromPhone}</td>
        <td>${message}</td>
      </tr>  `
        
        $('#lblTransactions').prepend(sTransactionTr)
        // Maybe display them slower
        swal({
          title:"TRANSFER", text:"You have received "+amount+ ' from: ' +name+' '+lastName+ ' ' +' with phone number: ' +fromPhone+ ' and message: ' +message, icon: "success",
        });
      
      }

    }).fail(function(){})

  }, 10000 )
}

fnvGetBalance()




