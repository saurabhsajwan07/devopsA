<?php 
	/* Copyright 2018 Atos SE and Worldline
	 * Licensed under MIT (https://github.com/atosorigin/DevOpsMaturityAssessment/blob/master/LICENSE) */
?>

		<!-- Popper.js first, then Bootstrap JS -->
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
		
    
  </body>
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