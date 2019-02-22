<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script>
    $('.page').hide()
    $('#logo').show()

    $('.navLink').click(function(){
      $('.page').hide()
        $('.navLink').removeClass('active')
          $(this).addClass('active')
            let pageToShow = $(this).attr('data-showPage')
            $('#' + pageToShow).show()
          })
  </script>

  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="js/login.js"></script>
  <script src="js/signup.js"></script>
</body>
</html>