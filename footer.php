<?php 
	/* Copyright 2018 Atos SE and Worldline
	 * Licensed under MIT (https://github.com/atosorigin/DevOpsMaturityAssessment/blob/master/LICENSE) */
     //print_r($_SESSION);die;
     //echo $_SESSION['showMenuStatus'];die;
?>

		<!-- Popper.js first, then Bootstrap JS -->
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
		
  </body>
  <?php 	
      if(isset($_SESSION['showMenuStatus']) && $_SESSION['showMenuStatus']){ ?>
      <script type="text/javascript">$('.afterresultshow').css("display", "block");</script>
     <?php }
	
?>
</html>

<script>
    $(window).scroll(function() {    
            var scroll = $(window).scrollTop();
         
            if (scroll >= 3) {
                $(".navMenuStyle").addClass("navFixedMenu");
            }
            else{
                $(".navMenuStyle").removeClass("navFixedMenu");
            }
        });
</script>