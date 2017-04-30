<!DOCTYPE html>
<html ng-app="myApp" ng-app lang="en" dir="rtl">
<head>
    <meta charset="utf-8">
    <style type="text/css">
    thead {
        background-color: #C1C1BA;
    }
    ul>li, a{cursor: pointer;}


     .addtable  {
          border-spacing: 5px;
         width:100%;
         }

    .row-cus {
          padding: 10px;
         }



    </style>
    <title>Simple Datagrid with search, sort and paging using AngularJS, PHP, MySQL</title>
</head>
<body>
<div ng-controller="missionListCrtl">
 <form name="form"  ng-submit="submitForm(form.$valid)" novalidate>
        <table class="addtable">           
	    <tr>
                <td width="10%">نوع ماموریت:</td>
                <td class="row-cus">
                      <select ui-selects ng-model="mission_type" name="mission_type" >
                        <option value="درون شهری">درون شهری</option>
                        <option value="برون شهری">برون شهری</option>
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
                            <input type="text" class="form-control"  datepicker-popup-persian="{{format}}" name="end_date" ng-model="end_date" is-open="persianIsOpenEndDate"  datepicker-options="dateOptions" close-text="یسته" required />
                             <span class="input-group-btn">
                              <button type="button" class="btn btn-default" ng-click="openPersianEndDate($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                            </span>
                          </p>
                      </div>
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
<div class="container" dir="rtl">
    <br>
    <br>
    <div class="row" style="direction: rtl;">
    	<div lass="col-md-2">    	
        <button type="button" class="btn btn-danger fa fa-plus ng-scope" ng-click="add('/staffs/missionAdd')"; style="font-family:BMorvarid,FontAwesome"><b>&nbsp;اضافه کردن ماموریت </b></button>
    	</div>
        <div class="col-md-2">
            <b> تعداد کل رکوردها : {{totalItems}} </b>
        </div>    
        <div class="col-md-3">
            <b> تعداد کل ساعات ماموریت : {{hours_sum}} </b>
        </div>
        <div class="col-md-2">
            <b> تعداد کل روزهای ماموریت : {{days_sum}} </b>
        </div>      
    </div>
    <br/>
    <div class="row">
        <div class="col-md-12" ng-show="filteredItems > 0">
            <table class="table table-striped table-bordered">
            <thead style="text-align:center">
            <th style="text-align:center">شناسه&nbsp;</th>
            <th style="text-align:center">تاریخ&nbsp;</th>
            <th style="text-align:center">محل ماموریت &nbsp;</th>
            <th style="text-align:center">نوع ماموریت &nbsp;</th>
            <th style="text-align:center">موضوع ماموریت &nbsp;</th>
            <th style="text-align:center;">تاریخ شروع &nbsp;</th>
            <th style="text-align:center">تاریخ پایان &nbsp;</th>
            <th style="text-align:center">تعداد ساعات ماموریت &nbsp;</th>            
            <th style="text-align:center">تعداد روز ماموریت &nbsp;</th>            
            <th style="text-align:center">عملیات&nbsp;</th>                                
            </thead>
            <tbody>
                <tr ng-repeat="data in filtered = (list)" style="text-align:center">
                    <td>{{data.Missions.id}}</td>
                    <td>{{data.Missions.jalali_date}}</td>
                    <td>{{data.Missions.customer_name}}</td>                    
                    <td>{{data.Missions.type}}</td>                    
                    <td>{{data.Missions.purpose}}</td>
                    <td>{{data.Missions.jalali_start_date}}</td>
                    <td>{{data.Missions.jalali_end_date}}</td>
                    <td>{{data.Missions.hours_format}}</td>                
                    <td>{{data.Missions.days}}</td>
                    <td>
                    	<div class="btn-group">
                        <button type="button" class="btn btn-danger fa fa-trash-o" ng-click="delete(data.Missions.id);"></button>
			              <button type="button" class="btn btn-default fa fa-edit" ng-click="edit('/staffs/missionEdit',data.Missions.id)";></button>			             
			            </div>
                    </td>                 
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
    </div>
</div>
</div>
    </body>
</html>
