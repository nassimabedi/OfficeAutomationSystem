<div class="users form" dir="" ng-controller="settingEditCrtl">
<form name="form"  ng-submit="submitForm(form.$valid)" novalidate>  
	<fieldset dir="rtl">
		<legend style="padding-bottom:1%">ویرایش تنظیمات سیستم</legend>
        <style type="text/css">
        .addtable  { 
          border-spacing: 5px;
         width:100%;

         }

         .row-cus {
          /*border: 1px solid black;*/
         /* padding: 20px;*/
         }

         
         .form-group > label, .form-group > div {
    display:inline-block;
    vertical-align: middle;
}
        </style>

	  <input type="hidden" name="setting_id"  ng-model="setting_id">
		<table class="addtable">
      <tr>
        <td colspan="2" align="center"><span style="color:blue" name="messeg" ng-model="messeg">{{message}}</span></td>
      <tr>			
      <tr>
          <td class="row-cus" style="width:15%">ساعت شروع اضافه کاری شیفت:*</td>
          <td>
            <div class="row">            
            <div class="col-md-2 pull-right">
            <timepicker ng-model="leave_time" ng-change="changed()" hour-step="hstep" minute-step="mstep" show-meridian="ismeridian" dir="ltr"></timepicker>  
            </div>            
          </div>
          </td>
      </tr>  
      <tr>
        <td colspan="2" class="row-cus" align="center">
          <button type="submit" class="btn btn-primary btn-large" ng-click="submitted=true" style="width: 120px; height: 40px;">ثبت</button >
        </td>
      </tr>    						
		</table>
	</fieldset>
</form>
</div>
