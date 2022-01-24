<?php 
   /* Copyright 2018 Atos SE and Worldline
    * Licensed under MIT (https://github.com/atosorigin/DevOpsMaturityAssessment/blob/master/LICENSE) */
   
   $isForm = FALSE;
   $activePage = 'Recommdation';
   
   require 'header.php';
   require 'renderAdvice.php';
   
?>

<section class="bannerHeader">
   <div class="container">
      <h2>Recommdation</h3>
   </div>
</section> 

<section class="sectionPadding">
   <div class="container">
      <div class="row">
         <?php
            foreach ($advice as $adviceIndex=>$adviceSection)
            {	
            	if ( $adviceIndex != '//' ) {
            ?>
         <div class="col-lg-6 col-md-12 mt-4">
            <div class="card">
               <h5 class="card-header text-center text-white bg-questionHolder">
                  <?=$adviceIndex?>
               </h5>
               <div class="card-body p-1">
                  <?php RenderAdvice($adviceIndex, false) ?>
               </div>
            </div>
         </div>
         <?php 
            }
            } ?>
      </div>
   </div>
   </div>
   </div>
</section>

<?php
   require 'footer.php';
?>