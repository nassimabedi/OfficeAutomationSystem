<div class="users form" dir="" ng-controller="shiftEditCrtl">
<form name="form"  ng-submit="submitForm(form.$valid)" novalidate>  
    <fieldset dir="rtl">
        <legend style="padding-bottom:1%;">ویرایش شیفت</legend>
        <style type="text/css">
        .addtable  { 
          border-spacing: 3px;
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

    <input type="hidden" name="shift_id" ng-model="shift_id">
    <table class="addtable">
      <tr>
        <td colspan="4" align="center"><span style="color:blue" name="messeg" ng-model="messeg">{{message}}</span></td>
      <tr>
      <tr>  
          <td class="row-cus" style="width:12%">نام پرسنل شیفت:*</td>    
          <td>
            <select ui-selects ng-model="user_id" name="user_id" required>
              <option></option>
              <option ng-repeat="user in users" value="{{user.User.id}}">{{user.User.full_name}}</option>
            </select> <span class="help-inline" ng-show="submitted && form.user_id.$error.required" style="color:red;padding-right:10px">لطفا نام کاربر را وارد نمایید</span>
          </td>               
          <td class="row-cus" style="width:12%">تاریخ:*</td>
          <td align="right">        
          <div class="row">
            <div class="col-md-5 pull-right" style="padding: 30px 10px 10px 10px;">
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
          <td class="row-cus">ساخت خروج از شرکت:</td>
          <td style="with:40%;">
             <div class="row">
            <div class="col-md-5 pull-right" style="padding: 30px 20px 10px 10px;">
                <p class="input-group pull-right">
                  <input type="text" class="form-control"  datepicker-popup-persian="{{format}}" name="exit_hour_date" ng-model="exit_hour_date" is-open="persianIsOpenExitDate"  datepicker-options="dateOptions" ng-required="true" close-text="بسته" required disabled="{{scope.isDisabled}}" />
                   <span class="input-group-btn">
                    <button type="button" class="btn btn-default" ng-click="openPersianExitDate($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                  </span>    
                </p>
            </div>
            <div class="col-md-2 pull-right">
            <timepicker ng-model="exit_hour_time" ng-change="changed()" hour-step="hstep" minute-step="mstep" show-meridian="ismeridian" dir="ltr"></timepicker>              
            </div>
            <span  ng-show="submitted && form.exit_hour_date.$error.required" style="display:block; padding-top: 40px;color:red;" valign="middle" >فیلد اجباری است</span>
          </div> 
          </td>
           <td class="row-cus">ساعت تحویل شیفت:*</td>
          <td>
            <div class="row">
            <div class="col-md-5 pull-right" style="padding: 30px 10px 10px 10px;">
                <p class="input-group pull-right">
                  <input type="text" class="form-control"  datepicker-popup-persian="{{format}}" name="delivery_hour_date" ng-model="delivery_hour_date" is-open="persianIsOpenDeliveryDate"  datepicker-options="dateOptions" ng-required="true" close-text="بسته" required disabled="{{scope.isDisabled}}" />
                   <span class="input-group-btn">
                    <button type="button" class="btn btn-default" ng-click="openPersianDeliveryDate($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                  </span>    
                </p>
            </div>
            <div class="col-md-2 pull-right">
            <timepicker ng-model="delivery_hour_time" ng-change="changed()" hour-step="hstep" minute-step="mstep" show-meridian="ismeridian" dir="ltr"></timepicker>              
            </div>
            <span  ng-show="submitted && form.delivery_hour_date.$error.required" style="display:block; padding-top: 40px;color:red;" valign="middle" >فیلد اجباری است</span>
          </div> 
          </td>
      </tr>
      <tr >
        <td class="row-cus">تعداد کل تماس‌ها:</td>
        <td colspan="3">                   
            <input type="number" name="all_calls_num" ng-model="all_calls_num" min="0" disabled="{{scope.isDisabled}}">
        </td>        
      </tr>                                   
      <tr>
          <td class="row-cus">تعداد تماس‌های موفق:</td>
          <td ><input type="number" name="successfull_calls_num" min="0" ng-model="successfull_calls_num" disabled="{{scope.isDisabled}}"><span class="help-inline" ng-show="submitted && form.successfull_calls_num.$error.required" style="color:red;padding-right:10px">فیلد اجباری است</span></td>
          <td>تعداد تماس‌های ناموفق:</td>
          <td><input type="number" name="unsuccessfull_calls_num" min="0" ng-model="unsuccessfull_calls_num" ><span class="help-inline" ng-show="submitted && form.unsuccessfull_calls_num.$error.required" style="color:red;padding-right:10px">فیلد اجباری است</span></td>
      </tr>
       <tr>
          <td class="row-cus">ساعت کاری روز بعد از شیفت:</td>
          <td style="with:40%;">
            ورود:
             <div class="row">
            <div class="col-md-5 pull-right" style="padding: 30px 20px 10px 10px;">
                <p class="input-group pull-right">
                  <input type="text" class="form-control"  datepicker-popup-persian="{{format}}" name="after_shift_start_date" ng-model="after_shift_start_date" is-open="persianIsOpenAfterShiftStart"  datepicker-options="dateOptions" ng-required="true" close-text="بسته" required disabled="{{scope.isDisabled}}" />
                   <span class="input-group-btn">
                    <button type="button" class="btn btn-default" ng-click="openPersianAfterShiftStart($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                  </span>    
                </p>
            </div>
            <div class="col-md-2 pull-right">
            <timepicker ng-model="after_shift_start_time" ng-change="changed()" hour-step="hstep" minute-step="mstep" show-meridian="ismeridian" dir="ltr"></timepicker>              
            </div>
            <span  ng-show="submitted && form.after_shift_start_date.$error.required" style="display:block; padding-top: 40px;color:red;" valign="middle" >فیلد اجباری است</span>
          </div> 
          </td>
           <td class="row-cus">خروج:*</td>
          <td>
            <div class="row">
            <div class="col-md-5 pull-right" style="padding: 30px 10px 10px 10px;">
                <p class="input-group pull-right">
                  <input type="text" class="form-control"  datepicker-popup-persian="{{format}}" name="after_shift_end_date" ng-model="after_shift_end_date" is-open="persianIsOpenAfterShiftEnd"  datepicker-options="dateOptions" ng-required="true" close-text="بسته" required disabled="{{scope.isDisabled}}" />
                   <span class="input-group-btn">
                    <button type="button" class="btn btn-default" ng-click="openPersianAfterShiftEnd($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                  </span>    
                </p>
            </div>
            <div class="col-md-2 pull-right">
            <timepicker ng-model="after_shift_end_time" ng-change="changed()" hour-step="hstep" minute-step="mstep" show-meridian="ismeridian" dir="ltr"></timepicker>              
            </div>
            <span  ng-show="submitted && form.delivery_hour_date.$error.required" style="display:block; padding-top: 40px;color:red;" valign="middle" >فیلد اجباری است</span>
          </div> 
          </td>
      </tr>
      <tr>
          <td class="row-cus">میزان اضافه کاری:</td>
          <td ><input type="text" name="overtime" ng-model="overtime"  disabled="{{scope.isDisabled}}"></td>
          <td>ارسال گزارش شیفت شب:</td>
          <td><input type="checkbox" name="send_shift_report" ng-model="send_shift_report" ng-true-value="1" ng-false-value="0" ng-checked="{{send_shift_report}}"></td>
      </tr>
      <tr>
          <td class="row-cus">توضیحات:</td>
          <td colspan="3"><textarea ng-model="desc" cols="30" disabled="{{scope.isDisabled}}"></textarea></td>
      </tr>
      <tr>       
        <td colspan="4" class="row-cus">
          <div> 
          <div class="btn btn-primary "> <i class="glyphicon glyphicon-folder-open"></i>           
            <input type="file" file-model="shift_file" class="btn" data-show-caption="true"/>
          </div>
          <button ng-click="uploadFile()" class="btn btn-default"> <i class="glyphicon glyphicon-upload"></i>upload File</button> <a ng-click="download_file()"><span ng-show="shift_file_dl">{{shift_file_dl}}</span></a>           
        </div>
        </td>
      </tr>
      <tr>
        <td colspan="4"><hr/></td>
      </tr>
      <tr>
        <td>اضافه کاری تایید شده:</td>
        <td>          
          <timepicker ng-model="approved_overtime" ng-change="changed()" hour-step="hstep" minute-step="mstep" show-meridian="ismeridian" dir="ltr"></timepicker>
        </td>
        <td>تاخیر تایید شده:</td>
        <td>
          <timepicker ng-model="approved_resttime" ng-change="changed()" hour-step="hstep" minute-step="mstep" show-meridian="ismeridian" dir="ltr"></timepicker>
        </td>
      </tr>
      <tr class="row-cus" stype="padding: 20px">
        <td colspan="4" align="left" ><button type="submit" class="btn btn-primary btn-large" ng-click="submitted=true" style="width: 120px; height: 40px;">ثبت</button></td>
      </tr>
        </table>
    </fieldset>
</form>

<div >
    <br>
   <table class="table table-bordered table-hover table-condensed" style="width:80%">
    <tr style="font-weight: bold;text-align:center">
      <td style="width:20%">نام مشتری</td>
      <td style="width:20%">شماره تیکت</td>
      <td style="width:35%">توضیحات</td>
      <td style="width:20%">عملیات</td>
    </tr>
    <tr ng-repeat="service in services">
      <td>
        <!-- editable username (text with validation) -->
        <span editable-text="service.customer" e-name="customer" e-form="rowform" e-required>
          {{ service.customer || 'empty' }}
        </span>
      </td>
      <td>
           <span editable-text="service.ticket_num" e-name="ticket_num" e-form="rowform" e-required>
          {{ service.ticket_num || 'empty' }}
        </span>
      </td>
      <td>       
        <span editable-text="service.description" e-name="group" e-form="rowform" e-required>
          {{ service.description || 'empty' }}
      </td>
      <td style="white-space: nowrap">
        <!-- form -->
        <form editable-form name="rowform" onbeforesave="saveService($data, service.id)" ng-show="rowform.$visible" class="form-buttons form-inline" shown="inserted == service">
          <button type="submit" ng-disabled="rowform.$waiting" class="btn btn-primary">
            ذخیره
          </button>
          <button type="button" ng-disabled="rowform.$waiting" ng-click="rowform.$cancel()" class="btn btn-default">
            لغو کردن
          </button>
        </form>
        <div class="buttons" ng-show="!rowform.$visible">
          <button class="btn btn-primary" ng-click="rowform.$show()">ویرایش</button>
          <button class="btn btn-danger" ng-click="removeService($index)">حذف</button>
        </div>  
      </td>
    </tr>
  </table>

  <button class="btn btn-default" ng-click="addService()">افزودن سرویس</button>
</div>
</div>


