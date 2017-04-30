<!DOCTYPE html>
<html ng-app="myApp">
<body ng-cloak="">
  <title>Product Manager Web Application</title>
  <meta name="Description" content="Product Manager Web Application created with AngularJS and PHP">
<?php
 echo $this->Html->css(array(
                            'new/bootstrap.min.css',
                            'custom.css',
                            'font-awesome.min.css',    
                            //===========
                            'bootstrap-datetimepicker.min.css',                                   
                            'assets/bootstrap-responsive.css'
         ));
 		//Libraries
 echo $this->Html->script(array(

                                 'jalali/angular.min.js',                                        
                                  'angular-route.min.js',
                                  'angular-animate.min.js',
                                  'jquery.min.js',
                                  'new/bootstrap.min.js',   
                                  'new/ui-bootstrap-tpls-0.12.0.min.js',
                                  'angular-bootstrap-datepicker.js', 
                                  'angular-route.min.js',
                                  'angular-animate.min.js',
                                  'underscore.min.js',
                                  'ie10-viewport-bug-workaround.js',

                                  'jalali/dateparser.js',
                                  'jalali/position.js',
                                  'jalali/datepicker-tpls.js',
                                  'jalali/persiandate.js',
                                  'jalali/persian-datepicker-tpls.js', 

                                  'ui-bootstrap-tpls-0.10.0.min.js',
                                  'app/config/adminConfig.js',
                                  'app/controllers/adminController.js',
                                  'app/filters/staffFilter.js',
                                  'app/directives/staffdirective.js',
                                  'app/services/general.js',

                                   //New for upload
                                  'app/services/service.js',
                                  'app/directives/directive.js',
                                                                
                                ));
?>


  <div class="blog-masthead" ng-controller="headerCrtl">
      <div class="container">
        <nav class="blog-nav">
          <a class="blog-nav-item pull-left" href="#">پنل ادمین</a>
          <a class="blog-nav-item pull-left" href="#"><?=$name ?> جان خوش آمدید</a>
          <?php if (!empty($profile_pic)) { ?>          
          <a ng-click="showImg()" ng-show="data.show" title="مخفی کردن عکس"><img src="<?=$profile_pic?>" height="400px"></a>
          <a ng-click="hideImg()" ng-hide="!(data.hide)" class="blog-nav-item pull-left"> نمایش عکس</a>
          <?} ?>
          <a class="blog-nav-item pull-right" href="#usersManager">مدیریت کاربر</a>
          <a class="blog-nav-item pull-right" href="#departmentsManager">مدیریت دپارتمان</a>
          <a class="blog-nav-item pull-right" href="#systemSettings">تنظیمات سیستم</a>
          <!--<a class="blog-nav-item pull-right" href="#missionsManager">مدیریت ماموریت</a>
          <a class="blog-nav-item pull-right" href="#shiftsManager">مدیریت شیفت</a>-->
          <a class="blog-nav-item pull-right" href="#changePassword">تغییر رمز</a>
          <a class="blog-nav-item pull-right" href="users/logout">خروج</a>
        </nav>
      </div>
    </div>
  
<div class="container" dir="rtl">
    <div class="page-content">
      <div ng-view="" id="ng-view"></div>
    </div>
</div>

</body>
</html>
