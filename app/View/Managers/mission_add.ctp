<div class="users form" dir="" ng-controller="missionAddCrtl">
<form name="form"  ng-submit="submitForm(form.$valid)" novalidate>
	<fieldset dir="rtl">
		<legend style="padding-bottom:1%">افزودن ماموریت</legend>
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
          <td class="row-cus" width="12%">نام مامور*:</td>
          <td class="row-cus">
              <select ui-selects ng-model="user_id" name="user_id" required>
                <option></option>
                <option ng-repeat="user in users" value="{{user.User.id}}">{{user.User.full_name}}</option>
              </select> <span class="help-inline" ng-show="submitted && form.user_id.$error.required" style="color:red;padding-right:10px">لطفا نام مامور را وارد نمایید</span>
          </td>
      </tr>
			<tr>				
				<td class="row-cus" style="width:12%">تاریخ:*</td>
				<td align="right">        
        		<div class="row">
              <div class="col-md-3 pull-right" style="padding: 30px 10px 10px 10px;">
                  <p class="input-group pull-right">
                    <input type="text" class="form-control"  datepicker-popup-persian="{{format}}" name="date" ng-model="date" is-open="persianIsOpen"  datepicker-options="dateOptions" close-text="بسته" required />
                     <span class="input-group-btn">
                      <button type="button" class="btn btn-default" ng-click="openPersian($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                    </span>                                     
                  </p>
              </div>              
              <span  ng-show="submitted && form.date.$error.required" style="display:block; padding-top: 40px;color:red;" valign="middle">لطفا فیلد تاریخ را وارد نمایید</span>
            </div>   
				</td>
			</tr>
      <tr>
          <td class="row-cus">محل ماموریت:*</td>
          <td>
             <!--<select ui-selects ng-model="customer_name" name="customer_name" required>
                <option></option>
                <option ng-repeat="account in accounts" value="{{account.accounts.name}}">{{account.accounts.name}}</option>
              </select> <span class="help-inline" ng-show="submitted && form.customer_name.$error.required" style="color:red;padding-right:10px">لطفا محل ماموریت را وارد نمایید</span>-->
               <input type="text" name="customer_name" ng-model="customer_name" required>
               <span class="help-inline" ng-show="submitted && form.customer_name.$error.required" style="color:red;padding-right:10px">لطفا محل ماموریت را وارد نمایید</span>
          </td>
      </tr>
      <tr>
          <td class="row-cus">نوع ماموریت:*</td>
          <td>                                
              <select ui-selects ng-model="mission_type" name="mission_type" required>                
                <option value="درون شهری">درون شهری</option>
                <option value="برون شهری">برون شهری</option>
              </select> <span class="help-inline" ng-show="submitted && form.mission_type.$error.required" style="color:red;padding-right:10px">لطفا نوع ماموریت را وارد نمایید</span>
          </td>
      </tr>
      <tr >
          <td class="row-cus">موضوع ماموریت:*</td>
          <td><input type="text" name="purpose" ng-model="purpose" required><span class="help-inline" ng-show="submitted && form.purpose.$error.required" style="color:red;padding-right:10px">لطفا فیلد موضوع ماموریت را وارد نمایید</span></td>
      </tr>
			<tr >
				<td class="row-cus">ساعت شروع:*</td>
				<td >					
          <div class="row">
            <div class="col-md-3 pull-right" style="padding: 30px 10px 10px 10px;">
                <p class="input-group pull-right">
                  <input type="text" class="form-control"  datepicker-popup-persian="{{format}}" name="start_date" ng-model="start_date" is-open="persianIsOpenStartDate"  datepicker-options="dateOptions" ng-required="true" close-text="بسته" required />
                   <span class="input-group-btn">
                    <button type="button" class="btn btn-default" ng-click="openPersianStartDate($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                  </span>    
                </p>
            </div>
            <div class="col-md-2 pull-right">
            <timepicker ng-model="start_time" ng-change="changed()" hour-step="hstep" minute-step="mstep" show-meridian="ismeridian" dir="ltr"></timepicker>  
            <!--<input type="hidden" ng-model="nassim" value="{{start_time | date:'HH:mm:ss' }}" name="nassim">                                           -->
            </div>
            <span  ng-show="submitted && form.start_date.$error.required" style="display:block; padding-top: 40px;color:red;" valign="middle" >لطفا تاریخ شروع را وارد نمایید</span>
          </div> 
				</td>
			</tr>			
			<tr>
				<td class="row-cus">ساعت پایان:*</td>
        <td >
          <div class="row">
            <div class="col-md-3 pull-right" style="padding: 30px 10px 10px 10px;">
                <p class="input-group pull-right">
                  <input type="text" class="form-control"  datepicker-popup-persian="{{format}}" name="end_date" ng-model="end_date" is-open="persianIsOpenEndDate"  datepicker-options="dateOptions" ng-required="true" close-text="بسته" required />
                   <span class="input-group-btn">
                    <button type="button" class="btn btn-default" ng-click="openPersianEndDate($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                  </span> 
                </p>
            </div>
            <div class="col-md-2 pull-right">
            <timepicker ng-model="end_time" ng-change="changed()" hour-step="hstep" minute-step="mstep" show-meridian="ismeridian" dir="ltr"></timepicker>                        
              <input type="hidden" ng-model="end_time" value="{{end_time | date:'HH:mm:ss' }}" name="start_time">                 
            </div>
            <span  ng-show="submitted && form.end_date.$error.required" style="display:block; padding-top: 40px;color:red;" valign="middle">لطفا تاریخ پایان را وارد نمایید</span>
          </div>
        </td>
			</tr>	
      <tr>
          <td class="row-cus">توضیحات:</td>
          <td><textarea name="description" ng-model="description" cols="30"></textarea></td>
      </tr>
      <tr>       
        <td colspan="2" class="row-cus">
          <div> 
          <div class="btn btn-primary "> <i class="glyphicon glyphicon-folder-open"></i>           
            <input type="file" file-model="mission_file" class="btn" data-show-caption="true"/>
          </div>
          <button ng-click="uploadFile()" class="btn btn-default"> <i class="glyphicon glyphicon-upload"></i>upload File</button>          
        </div>
        </td>
      </tr>
      <tr>
        <td colspan="2" align="center"><button type="submit" class="btn btn-primary btn-large" ng-click="submitted=true" style="width: 120px; height: 40px;">ثبت</button></td>
      </tr>
		</table>
	</fieldset>
</form>
</div>
