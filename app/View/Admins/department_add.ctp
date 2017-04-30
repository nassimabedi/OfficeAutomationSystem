<div class="users form" dir="" ng-controller="departmentAddCrtl">
<form name="form"  ng-submit="submitForm(form.$valid)" novalidate>  
	<fieldset dir="rtl">
		<legend style="padding-bottom:1%">افزودن دپارتمان</legend>
        <style type="text/css">
        .addtable  { 
          border-spacing: 5px;
         width:100%;

         }

         .row-cus {
         padding: 20px;
         }

         
         .form-group > label, .form-group > div {
    display:inline-block;
    vertical-align: middle;
}
        </style>

	
		<table class="addtable">
      <tr>
        <td colspan="2" align="center"><span style="color:blue" name="messeg" ng-model="messeg">{{message}}</span></td>
      <tr>			
      <tr>
          <td class="row-cus" style="width:10%">دپارتمان:*</td>
          <td><input type="text" name="department" ng-model="department" required> <span class="help-inline" ng-show="submitted && form.department.$error.required" style="color:red;padding-right:10px">لطفا نام دپارتمان را وارد نمایید</span></td>
      </tr> 
      <tr>
        <td colspan="2" class="row-cus" align="center"><button type="submit" class="btn btn-primary btn-large" ng-click="submitted=true" style="width: 120px; height: 40px;">ثبت</button></td>
      </tr>     						
		</table>
	</fieldset>
</form>
</div>
