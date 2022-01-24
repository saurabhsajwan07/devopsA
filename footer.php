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
      
    $(".showResultOnclick").click(function(){
        $('form').attr('action', 'results');
        //$('.afterresultshow').addClass('blockEle');
        $('.afterresultshow').css("display", "block");
    });   
    

    // $('#submitFormBtn').submit(function() {
    //     e.preventDefault();
    //     $('form').attr('action', 'results');
    //     $('.afterresultshow').css("display", "block");
    // });

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