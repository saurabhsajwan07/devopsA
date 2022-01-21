<?php 
   /* Copyright 2018 Atos SE and Worldline
    * Licensed under MIT (https://github.com/atosorigin/DevOpsMaturityAssessment/blob/master/LICENSE) */
   
   $isForm = FALSE;
   $activePage = 'About';
   
   require 'header.php';	
   ?>
<section class="bannerText">
   <div class="container">
   <div class="row">
      <div class="col-lg-8">
         <div class="headerText">
            <h1>Enhance Your DevOps Capabilities</h1>
            <p>This free DevOps Maturity Assessment questionnaire will help you identify your existing strengths and shortcomings before recommending resources to assist you take the next steps in your DevOps journey.</p>
            <p>
               <a href="<?='section-' . SectionNameToURLName($survey->sections[0]['SectionName'])?>" class="btnStyle1 mr-3">Start the Questionnaire</a>
               <a href="https://github.com/atosorigin/DevOpsMaturityAssessment" target="_blank" class="btnStyle2">Fork us on GitHub</a>
            </p>
         </div>
      </div>
   </div>
</section>
<section class="sectionPadding">
   <div class="container">
   <div class="row">
      <div class="col-lg-12">
         <h2 class="sectionHeading">About DevOps Maturity Assessment</h2>
      </div>
      <!-- Three columns of text below the jumbotron -->
      <div class="col-lg-4">
         <div class="serviceDetails">
            <span class="iconStyle">
            <i class="far fa-chart-bar"></i>
            </span>
            <h3>Determine Your Current Level</h3>
            <p>Our carefully crafted collection of questions covering seven key areas will assist you in swiftly determining your current level of DevOps maturity.</p>
            <!-- <p>You may examine the findings online or download them in CSV file for more in-depth study.</p> -->
         </div>
      </div>
      <!-- /.col-lg-4 -->
      <div class="col-lg-4">
         <div class="serviceDetails">
            <span class="iconStyle">
            <i class="fas fas fa-shoe-prints"></i>
            </span>
            <h3>Determine Your Next Milestone</h3>
            <p>We've found a variety of free or commercially available books, videos, blog articles, white papers, and websites to assist you take the next milestones in your DevOps journey.</p>
         </div>
      </div>
      <!-- /.col-lg-4 -->
      <div class="col-lg-4">
         <div class="serviceDetails">
            <span class="iconStyle">
            <i class="fas fa-lock-open "></i>
            </span>
            <h3>Open Source Tools</h3>
            <p>You are allowed to use, adapt and redistribute the tools for business and non-commercial purposes. There is no requirement for you to share your changes, but we always value input! Why don't you <a href="https://github.com/atosorigin/DevOpsMaturityAssessment" target="_blank">fork us on GitHub</a>?</p>
         </div>
      </div>
      <!-- /.col-lg-4 -->		  
   </div>
   <!-- /.row -->
</section>
<section class="footerText">
   <div>
      <p>We do not collect your personal information and will not disclose your results to anybody else.</p>
   </div>
</section>
<?php
   require 'footer.php';
   
   ?>