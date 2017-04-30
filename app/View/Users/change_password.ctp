<style type="text/css">
        .addtable  { 
          border-spacing: 2px;
         width:100%;

         }

         .row-cus {
          padding: 10px;
         }

         
         .form-group > label, .form-group > div {
    display:inline-block;
    vertical-align: middle;
}
        </style>
<div class="users form" dir="rtl" ng-controller="changePasswordCrtl">    
<form name="form"  ng-submit="submitForm(form.$valid)" novalidate>  
	<fieldset>
		<legend style="padding-bottom:1%">تغییر رمز</legend>
        <table class="addtable">  
            <tr>
                <td colspan="2" align="center"><span style="color:blue" name="messeg" ng-model="messeg">{{message}}</span></td>
            </tr>               
            <tr>
                <td class="row-cus" style="width:12%">کلمع عبور:</td>
                <td class="row-cus"><input data-ng-model='user.password' type="password" name='password' placeholder='کلمه عبور' required>
                &nbsp;<span ng-show="form.password.$error.required" style="color:red">
                فیلد اجباری است!</span></td>
            </tr>
            <tr>
                <td class="row-cus">تکرار کلمه عبور:</td>
                <td class="row-cus">
                    <input ng-model='user.password_verify' type="password" name='confirm_password' placeholder='تکرار کلمه عبور' required data-password-verify="user.password">
                    &nbsp;<span ng-show="form.confirm_password.$error.required" style="color:red">
                        فیلد اجباری است! </span>
                      <span ng-show="form.confirm_password.$error.passwordVerify" style="color:red" >
                        پسوردها با هم برابر نسیت!</span> 
                </td>
            </tr>   
            <tr>
                <td colspan="2" align="center"><button type="submit" class="btn btn-primary btn-large" ng-click="submitted=true" style="width: 120px; height: 40px;">ثبت</button ></td>
            </tr>       
        </table>
	</fieldset>
</form>
</div>

