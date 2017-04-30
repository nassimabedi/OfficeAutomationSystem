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
<div ng-controller="settingsCrtl">
<div class="container" dir="rtl">
    <br><br>
    <br/>
    <div class="row">
        <div class="col-md-12" ng-show="filteredItems > 0">
            <table class="table table-striped table-bordered">
            <thead>
            <th style="text-align:center">شناسه&nbsp;<a ng-click="sort_by('Settings.id');"><i class="glyphicon glyphicon-sort"></i></a></th>
            <th style="text-align:center">ساعت شروع اضافه کاری شیفت &nbsp;<a ng-click="sort_by('Settings.leave_time');"><i class="glyphicon glyphicon-sort"></i></a></th>
            <th ></th>
                                          
            </thead>
            <tbody>
                <tr ng-repeat="data in filtered = (list | filter:search | orderBy : predicate :reverse) | startFrom:(currentPage-1)*entryLimit | limitTo:entryLimit">
                    <td style="text-align:center">{{data.Settings.id}}</td>
                    <td style="text-align:center">{{data.Settings.leave_time}}</td>                                      
                    <td nowrap align="center">
                        <div class="btn-group">                                                  
                           <button type="button" class="btn btn-default fa fa-edit" ng-click="edit('/admins/settingEdit',data.Settings.id)";></button>
                        </div>
                    </td>  
                </tr>
            </tbody>
            </table>
        </div>
        <div class="col-md-12" ng-show="filteredItems == 0">
            <div class="col-md-12">
                <h4>No Records found</h4>
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
