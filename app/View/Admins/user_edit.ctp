<div class="users form" dir="" ng-controller="userEditCrtl">
<form name="form"  ng-submit="submitForm(form.$valid)" novalidate>  
	<fieldset dir="rtl">
		<legend style="padding-bottom:1%">ویرایش کاربر</legend>
        <style type="text/css">
        .addtable  { 
          border-spacing: 5px;
         width:100%;

         }

         .row-cus {
          padding-top: 20px;
         }

         
         .form-group > label, .form-group > div {
    display:inline-block;
    vertical-align: middle;
}
        </style>

	  <input type="hidden" name="user_id"  ng-model="user_id">
		<table class="addtable">
      <tr>
        <td colspan="2" align="center"><span style="color:blue" name="messeg" ng-model="messeg">{{message}}</span></td>
      <tr>			
      <tr>
          <td class="row-cus" style="width:10%">نام:*</td>
          <td class="row-cus"><input type="text" name="first_name" ng-model="first_name" required> <span class="help-inline" ng-show="submitted && form.first_name.$error.required" style="color:red;padding-right:10px">لطفا نام را وارد نمایید</span></td>
      </tr>   
      <tr>
          <td class="row-cus" style="width:10%">نام خانوادگی:*</td>
          <td class="row-cus"><input type="text" name="last_name" ng-model="last_name" required> <span class="help-inline" ng-show="submitted && form.last_name.$error.required" style="color:red;padding-right:10px">لطفا نام خانوادگی را وارد نمایید</span></td>
      </tr>
      <tr>
          <td class="row-cus" style="width:10%">نام کاربری:*</td>
          <td class="row-cus"><input type="text" name="username" ng-model="username" required> <span class="help-inline" ng-show="submitted && form.username.$error.required" style="color:red;padding-right:10px">لطفا نام کاربری را وارد نمایید</span></td>
      </tr> 
      <tr>
          <td class="row-cus" style="width:10%">کلمه عبور:*</td>
          <td class="row-cus"><input type="password" name="password" ng-model="password" required> <span class="help-inline" ng-show="submitted && form.password.$error.required" style="color:red;padding-right:10px">لطفا کلمه عبور را وارد نمایید</span></td>
      </tr>                               
      <tr>
          <td class="row-cus" style="width:10%">دپارتمان:*</td>
          <td class="row-cus">
            <select ui-selects ng-model="department_id" name="department_id" required>
              <option></option>
              <option ng-repeat="department in departments" value="{{department.Departments.id}}">{{department.Departments.name}}</option>
          </select> <span class="help-inline" ng-show="submitted && form.department_id.$error.required" style="color:red;padding-right:10px">لطفا دپارتمان را انتخاب نمایید</span></td>
      </tr>                                             						
      <tr>
          <td class="row-cus" style="width:10%">سمت:*</td>
          <td class="row-cus">
            <select ui-selects ng-model="role_id" name="role_id" required>
              <option></option>
              <option value="admin">admin</option>
              <option value="manager">manager</option>
              <option value="staff">staff</option>
              <option value="officer">officer</option>
            </select>
              <span class="help-inline" ng-show="submitted && form.role_id.$error.required" style="color:red;padding-right:10px">لطفا سمت را وارد نمایید</span></td>
      </tr>
      <tr>
        <td align="center" colspan="2" class="row-cus">
          <button type="submit" class="btn btn-primary btn-large" ng-click="submitted=true" style="width: 120px; height: 40px;">ثبت</button >
        </td>
      </tr>                                                         
		</table>
	</fieldset>
  <br/>
</form>
</div>
