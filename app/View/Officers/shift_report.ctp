<!DOCTYPE html>
<html ng-app="myApp" ng-app lang="en" dir="rtl">
<head>
    <style type="text/css">
    ul>li, a{cursor: pointer;}

     .addtable  { 
          border-spacing: 5px;
         width:100%;

         }

    .row-cus {
          padding: 10px;
         }

    </style>
    <meta charset="utf-8">
    
    <style type="text/css">
    ul>li, a{cursor: pointer;}
    </style>
    <title>Simple Datagrid with search, sort and paging using AngularJS, PHP, MySQL</title>
    <?php
    ?>
</head>
<body>
<div ng-controller="shiftListCrtl">
<div class="container" dir="rtl">
    <div class="row" style="direction: rtl;">
        <form name="form"  ng-submit="submitForm(form.$valid)" novalidate>
        <table class="addtable">
            <tr>
                <td width="10%">کاربران:</td>
                <td colspan="3" class="row-cus" >
                    <select ui-selects ng-model="user_id" name="user_id">
                      <option></option>
                      <option ng-repeat="user in users" value="{{user.User.id}}">{{user.User.full_name}}</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td width="10%">دپارتمان:</td>
                <td colspan="3" class="row-cus" >
                    <select ui-selects ng-model="department_id" name="department_id">
                      <option></option>
                      <option ng-repeat="department in departments" value="{{department.Departments.id}}">{{department.Departments.name}}</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td >تاریخ شروع :</td>
                <td width="30%" >
                     <div class="row" style="width:100%; height:100%;">
                      <div class="col-md-6 pull-right" style="width:100%; height:100%;">
                          <p class="input-group pull-right">
                            <input type="text" class="form-control"  datepicker-popup-persian="{{format}}" name="start_date" ng-model="start_date" is-open="persianIsOpenStartDate"  datepicker-options="dateOptions" close-text="بسته" required />
                            
                             <span class="input-group-btn">
                              <button type="button" class="btn btn-default" ng-click="openPersianStartDate($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                            </span>                                     
                          </p>
                      </div>                    
                     </div>                     
                </td>
                <td width="10%"> تاریخ پایان :</td>
                <td >
                    <div class="row" style="width:100%; height:100%;">
                      <div class="col-md-4 pull-right" style="width:60%; height:100%;">
                          <p class="input-group pull-right">
                            <input type="text" class="form-control"  datepicker-popup-persian="{{format}}" name="end_date" ng-model="end_date" is-open="persianIsOpenEndDate"  datepicker-options="dateOptions" close-text="بسته" required />
                             <span class="input-group-btn">
                              <button type="button" class="btn btn-default" ng-click="openPersianEndDate($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                            </span>                                     
                          </p>
                      </div>
                      <span  ng-show="submitted && form.date.$error.required" style="display:block; padding-top: 40px;color:red;" valign="middle">لطفا فیلد تاریخ را وارد نمایید</span>
                    </div> 
                </td>
            </tr>
            <tr>                 
                <td colspan="4" align="right">
                    <span class="help-inline" ng-show="submitted && (form.start_date.$error.required || form.end_date.$error.required)" style="color:red;padding-right:10px">لطفا تاریخ را وارد نمایید</span>
                </td>
            </tr>
            <tr>
                <td colspan="4" align="center">
                    <button type="submit" class="btn btn-primary btn-large" ng-click="submitted=true" style="width: 120px; height: 40px;">جستجو</button>
                </td>
            </tr>
        </table>
        </form>
        <hr>
        <div class="col-md-2" ng-show="filteredItems > 0">
            <div style="padding-top:10%"><a ng-click="download_csv()"><img src="img/download-icon-30.gif" /></a></div>            
        </div>
        <div class="col-md-2" style="padding-top:2%" ng-show="filteredItems > 0">           
            <b> تعداد کل رکوردها : {{totalItems}} </b>
        </div>
        <div class="col-md-2" style="padding-top:2%" ng-show="filteredItems > 0">            
            <b> کل اضافه کاری : {{overtime_sum}} </b>
        </div>
        <div class="col-md-2" style="padding-top:2%" ng-show="filteredItems > 0">            
            <b> کل اضافه کاری تایید شده: {{approved_overtime_sum}} </b>
        </div>                
    </div>
    <br/>
    <div class="row">

        <div class="col-md-12" ng-show="filteredItems > 0">
            <table class="table table-striped table-bordered">
            <thead>
            <th style="text-align:center">شناسه&nbsp;</th>
            <th style="text-align:center">تاریخ&nbsp;</th>
            <th style="text-align:center">نام پرسنل شیفت&nbsp;</th>
            
            <th style="text-align:center">نام مشتری&nbsp;</th>
            <th style="text-align:center">رابط فنی (مشتری)&nbsp;</th>
            <th style="text-align:center">شرح مشکل&nbsp;</th>
            <th style="text-align:center">شماره تیکت&nbsp;</th>
            <th style="text-align:center">توضیحات&nbsp;</th>

            <th style="text-align:center">ساعت خروج از شرکت&nbsp;</th>
            <th style="text-align:center">ساعت تحویل&nbsp;</th>
            <th style="text-align:center">تعداد تماس‌ها &nbsp;</th>
            <th style="text-align:center">تماس‌های موفق&nbsp;</th>
            <th style="text-align:center">تماس‌های ناموفق &nbsp;</th> 
            <th style="text-align:center">اضافه کاری &nbsp;</th>  
            <th style="text-align:center">اضافه کاری تایید شده &nbsp;</th>  	    
	    <td>تایید
                    </td>
            <th style="text-align:center">تاخیر تایید شده &nbsp;</th>           
		
                                           
            </thead>
            <tbody>
                <!--<tr ng-repeat="data in filtered = (list | filter:search | orderBy : predicate :reverse) | startFrom:(currentPage-1)*entryLimit | limitTo:entryLimit" style="text-align:center">-->

                <tr ng-repeat="data in filtered = (list)" style="text-align:center">                    
                    <td>{{data.Shifts.id}}</td>
                    <td>{{data.Shifts.jalali_date}}</td>
                    <td nowrap>{{data.User.first_name}} {{data.User.last_name}}</td>

                    <td>{{data.shift_services[0].customer}}</td>
                    <td>{{data.shift_services[0].contact_name}}</td>
                    <td>{{data.shift_services[0].issue_details}}</td>
                    <td>{{data.shift_services[0].ticket_num}}</td>
                    <td>{{data.shift_services[0].description}}</td>

                    <td>{{data.Shifts.jalali_exit_hour}}</td>                    
                    <td>{{data.Shifts.jalali_delivery_hour}}</td>
                    <td>{{data.Shifts.all_calls_num}}</td>
                    <td>{{data.Shifts.successfull_calls_num}}</td>
                    <td>{{data.Shifts.unsuccessfull_calls_num}}</td>   
                    <td>{{data.Shifts.overtime}}</td>
                    <td>{{data.Shifts.approved_overtime}}</td>
		    <td>
                        <input type="checkbox" ng-model="approve"
                 ng-true-value="1" ng-false-value="0" ng-checked="{{data.Shifts.approve}}" >
                        </td>
                    </td>
                    <td>{{data.Shifts.approved_resttime}}</td>                 
                                    
                </tr>
            </tbody>
            </table>
        </div>
        <div class="col-md-12" ng-show="filteredItems == 0">
            <div class="col-md-12">
                <h4>رکوردی وجود ندارد</h4>
            </div>
        </div>
        <div class="col-md-12" ng-show="filteredItems > 0" dir="rtl"> 
            <div pagination="" page="currentPage" on-select-page="setPage(page)" boundary-links="true" total-items="filteredItems" items-per-page="entryLimit" class="pagination-small" previous-text="&laquo;" next-text="&raquo;"></div>           
        </div>
        <div style="position: relative;float:right"></div>
    </div>
</div>
</div>
    </body>
</html>
