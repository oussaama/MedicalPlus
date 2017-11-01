$(document).ready(function () {

        var x='<h4 style="text-align:center">Login <strong>account</strong> now</h4>'
+'<form name="login_form" method="post" class="th-register-form register_form_static form-horizontal " action="http://hogash-demo.com/demo/kwp/wp-login.php?action=register">'+
    '<div class="form-group">'+
       ' <label class="col-sm-4 control-label" for="user_email">Email</label>'+
        '<div class="col-sm-8">'+
           '<input type="email" name="user_email" id="user_email" class="form-control inputbox required" placeholder="Your email"></div>'+
    '</div>'+
    '<div class="form-group">'+
        '<label class="col-sm-4 control-label" for="user_password">Your password</label>'+
        '<div class="col-sm-8">'+
            '<input type="password" name="user_password" id="user_password" class="form-control inputbox" required="" placeholder="Your password"></div>'+
    '</div>'+
    '<div class="form-group">'+
        '<div class="col-sm-8 col-sm-offset-4" style="margin-bottom:0;">'+
            '<input type="button" name="submit" class="zn_sub_button btn btn-fullcolor th-button-register regp" value="REGISTER">&nbsp;';
           p='<a href="index.html"><input type="button" name="submit" class="zn_sub_button btn btn-fullcolor th-button-register" value="LOGIN"></a>';
           s='<a href="kuma-homepage.html"><input type="button" name="submit" class="zn_sub_button btn btn-fullcolor th-button-register" value="LOGIN"></a>';
           d='<a href="homepages-homepage-5-classic.html"><input type="button" name="submit" class="zn_sub_button btn btn-fullcolor th-button-register" value="LOGIN"></a>';
           ph='<a href="homepages-homepage-4-classic.html"><input type="button" name="submit" class="zn_sub_button btn btn-fullcolor th-button-register" value="LOGIN"></a>';
           b='<a href="ara-homepage.html"><input type="button" name="submit" class="zn_sub_button btn btn-fullcolor th-button-register" value="LOGIN"></a>';
           l='<a href="homepages-homepage-1-classic.html"><input type="button" name="submit" class="zn_sub_button btn btn-fullcolor th-button-register" value="LOGIN"></a>';
        z='</div>'+
    '</div>'+
    '<div class="th-response" style="display: none;"></div>'+
    '<input type="hidden" value="register" name="zn_form_action">'+
    '<input type="hidden" value="zn_do_login" name="action">'+
    '<input type="hidden" value="/demo/kwp/static-content-text-with-register/" class="zn_login_redirect" name="submit">'+
    '<div class="links"></div>'+
'</form> ';
    $(".loginp").click(function () {
        $(".logp").slideUp(200);
        $(".logp").html(x+p+z).slideDown(500);
    });
    $(".regp").click(function () {
        $(".logp").slideUp(200);
        $(".logp").html('<h4 style="text-align:center">Create <strong>your account</strong> now</h4><form name="login_form" method="post" class="th-register-form register_form_static form-horizontal " action="http://hogash-demo.com/demo/kwp/wp-login.php?action=register"><div class="form-group"><label class="col-sm-4 control-label" for="user_login">Username</label><div class="col-sm-8"><input type="text" name="user_login" id="user_login" class="form-control inputbox" required="" placeholder="Username"></div></div><div class="form-group"><label class="col-sm-4 control-label" for="user_email">Email</label><div class="col-sm-8"><input type="email" name="user_email" id="user_email" class="form-control inputbox required" placeholder="Your email"></div></div><div class="form-group"><label class="col-sm-4 control-label" for="user_password">Your password</label><div class="col-sm-8"><input type="password" name="user_password" id="user_password" class="form-control inputbox" required="" placeholder="Your password"></div></div><div class="form-group"><label class="col-sm-4 control-label" for="user_password2">Verify password</label><div class="col-sm-8"><input type="password" name="user_password2" id="user_password2" class="form-control inputbox" required="" placeholder="Verify password"></div></div><div class="form-group"><div class="col-sm-8 col-sm-offset-4" style="margin-bottom:0;"><input type="button" name="submit" class="zn_sub_button btn btn-fullcolor th-button-register regp" value="REGISTER">&nbsp;&nbsp;<input type="submit" name="submit" class="zn_sub_button btn btn-fullcolor th-button-register loginp" value="LOGIN"></div></div><div class="th-response" style="display: none;"></div><input type="hidden" value="register" name="zn_form_action"><input type="hidden" value="zn_do_login" name="action"><input type="hidden" value="/demo/kwp/static-content-text-with-register/" class="zn_login_redirect" name="submit"><div class="links"></div></form>').slideDown(500);
    });

    $(".logins").click(function () {
        $(".logs").slideUp(200);
        $(".logs").html(x+s+z).slideDown(500);
    });

    $(".logind").click(function () {
        $(".logd").slideUp(200);
        $(".logd").html(x+d+z).slideDown(500);
    });

    $(".loginph").click(function () {
        $(".logph").slideUp(200);
        $(".logph").html(x+ph+z).slideDown(500);
    });

    $(".loginb").click(function () {
        $(".logb").slideUp(200);
        $(".logb").html(x+b+z).slideDown(500);
    });

    $(".loginl").click(function () {
        $(".logl").slideUp(200);
        $(".logl").html(x+l+z).slideDown(500);
    });
   /* $("#bb-nav-next").click()(function{
        $(".menu-item-has-children active").removeClass(".active");
        $(".menu-item-has-children active").next().addClass(".active");
    });*/
});