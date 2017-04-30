<!DOCTYPE html>
<html ng-app="myApp" ng-app lang="en" dir="rtl">
<head>
    <meta charset="utf-8">
    <style type="text/css">
    
    ul>li, a{cursor: pointer;}
    </style>
    <title>Simple Datagrid with search, sort and paging using AngularJS, PHP, MySQL</title>

</head>
<body>
<div ng-controller="shiftListCrtl">
<div class="container" dir="rtl">
    <br/>
    <br/>
    <div class="row" style="direction: rtl;">
    	<div>
        <button type="button" class="btn btn-danger fa fa-plus ng-scope" ng-click="add('/staffs/shiftAdd')"; style="font-family:BMorvarid,FontAwesome" ><b>&nbsp;اضافه کردن شیفت</b></button>
    	</div>
        <div class="col-md-2">            
           <b> تعداد کل رکوردها : {{totalItems}} </b>
        </div>
        <div class="col-md-2">            
           <b> تعداد کل اضافه کاری : {{hours_sum}} </b>
        </div>
        <!--<div class="col-md-2">جستجو:
            <input type="text" ng-model="search" ng-change="filter()" placeholder="جستجو" class="form-control" />
        </div>
        <div class="col-md-2" style="padding-top:2%;text-align:left">
            <h5>جستجوی {{ filtered.length }} تا از کل {{ totalItems}} </h5>
        </div>-->
    </div>
    <br/>
    <div class="row">
        <div class="col-md-12" ng-show="filteredItems > 0">
            <table class="table table-striped table-bordered">
            <thead style="text-align:center">
            <th style="text-align:center">شناسه&nbsp;</th>
            <th style="text-align:center">تاریخ&nbsp;</th>
            <th style="text-align:center">ساعت خروج &nbsp;</th>
            <th style="text-align:center">ساعت تحویل&nbsp;</th>
            <th style="text-align:center">تعداد تماس‌ها &nbsp;</th>
            <th style="text-align:center">تماس‌های موفق&nbsp;</th>
            <th style="text-align:center">تماس‌های ناموفق &nbsp;</th> 
            <th style="text-align:center">اضافه کاری &nbsp;</th>  
            <th style="text-align:center">اضافه کاری تایید شده &nbsp;</th>  
            <th style="text-align:center">ساعت استراحت تایید شده &nbsp;</th>           
            <th nowrap width="100px" style="text-align:center">عملیات&nbsp;</th>                                
            </thead>
            <tbody>
                <!--<tr ng-repeat="data in filtered = (list | filter:search | orderBy : predicate :reverse) | startFrom:(currentPage-1)*entryLimit | limitTo:entryLimit" style="text-align:center">-->
                <tr ng-repeat="data in filtered = (list)" style="text-align:center">                    
                    <td>{{data.Shifts.id}}</td>
                    <td>{{data.Shifts.jalali_date}}</td>
                    <td>{{data.Shifts.jalali_exit_hour}}</td>                    
                    <td>{{data.Shifts.jalali_delivery_hour}}</td>
                    <td>{{data.Shifts.all_calls_num}}</td>
                    <td>{{data.Shifts.successfull_calls_num}}</td>
                    <td>{{data.Shifts.unsuccessfull_calls_num}}</td>   
                    <td>{{data.Shifts.overtime}}</td>
                    <td>{{data.Shifts.approved_overtime}}</td>
                    <td>{{data.Shifts.approved_resttime}}</td>                 
                    <td nowrap>
                    	<div class="btn-group">
                          <button type="button" class="btn btn-danger fa fa-trash-o" ng-click="delete(data.Shifts.id);"></button>
			              <button type="button" class="btn btn-default fa fa-edit" ng-click="edit('/staffs/shiftEdit',data.Shifts.id)";></button>

			              
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
