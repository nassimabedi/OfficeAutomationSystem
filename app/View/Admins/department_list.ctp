<!DOCTYPE html>
<html ng-app="myApp" ng-app lang="en" dir="rtl">
<head>
    <meta charset="utf-8">
    <!--<link href="css/bootstrap.min.css" rel="stylesheet">-->
    <style type="text/css">
    ul>li, a{cursor: pointer;}
    </style>
    <title>Simple Datagrid with search, sort and paging using AngularJS, PHP, MySQL</title>

</head>
<body>
<div ng-controller="departmentCrtl">
<div class="container" dir="rtl">
    <br>
    <br>
    <div class="row" style="direction: rtl;">
        <div lass="col-md-2">        
            <button type="button" class="btn btn-danger fa fa-plus ng-scope" ng-click="add('/admins/departmentAdd')"; style="font-family:BMorvarid,FontAwesome"><b>&nbsp;افزودن دپارتمان</b></button>
        </div>
        <div class="col-md-1">صفحه بندی:
            <select ng-model="entryLimit" class="form-control">
                <option>5</option>
                <option>10</option>
                <option>20</option>
                <option>50</option>
                <option>100</option>
            </select>
        </div>
        <div class="col-md-2">جستجو:
            <input type="text" ng-model="search" ng-change="filter()" placeholder="جستجو" class="form-control" />
        </div>
        <div class="col-md-2" style="padding-top:2%;text-align:left">
            <h5>جستجوی {{ filtered.length }} تا از کل {{ totalItems}} </h5>
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-md-12" ng-show="filteredItems > 0">
            <table class="table table-striped table-bordered">
            <thead>
            <th style="text-align:center">شناسه&nbsp;<a ng-click="sort_by('Departments.id');"><i class="glyphicon glyphicon-sort"></i></a></th>
            <th style="text-align:center">نام &nbsp;<a ng-click="sort_by('Departments.name');"><i class="glyphicon glyphicon-sort"></i></a></th>
            <th style="text-align:center">وضعیت&nbsp;<a ng-click="sort_by('Departments.disabled');"><i class="glyphicon glyphicon-sort"></i></a></th>                                
            </thead>
            <tbody>
                <tr ng-repeat="data in filtered = (list | filter:search | orderBy : predicate :reverse) | startFrom:(currentPage-1)*entryLimit | limitTo:entryLimit">
                    <td style="text-align:center">{{data.Departments.id}}</td>
                    <td style="text-align:center">{{data.Departments.name}}</td>                                      
                    <td nowrap align="center">
                        <div class="btn-group">                         
                          <button type="button" class="btn btn-danger fa fa-trash-o" ng-click="delete(data.Departments.id);"></button>
                           <button type="button" class="btn btn-default fa fa-edit" ng-click="edit('/admins/departmentEdit',data.Departments.id)";></button>
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
