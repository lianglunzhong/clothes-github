<section id="main">
	<!-- crumbs -->
	<div class="container">
		<div class="crumbs">
			<div>
				<a href="<?php echo LANGPATH; ?>/">home</a>
				<a href="<?php echo LANGPATH; ?>/customer/summary" class="visible-xs-inline hidden-sm hidden-md hidden-lg"> > my account</a> > change password
			</div>
		</div>
		<?php echo Message::get(); ?>
	</div>
	<!-- main-middle begin -->
	<div class="container">
		<div class="row">
<?php echo View::factory('customer/left'); ?>
<?php echo View::factory('customer/left_1'); ?>
			<article class="user col-sm-9 col-xs-12">
				<div class="tit">
					<h2>Change Password</h2>
				</div>
				<div class="row">
					<div class="col-sm-2 hidden-xs"></div>
					<form class="user-form user-share-form col-sm-8 col-xs-12" method="post" action="">
						<p class="col-sm-12 col-xs-12 change-password">For the security of your account, we recommend that you choose a Password other than names, birthdays or street addresses that are associated with you.</p>
						<ul>
							<li>
								<label class="col-sm-3 col-xs-12"><span>*</span>Former Password:</label>
								<div class="col-sm-9 col-xs-12">
									<input type="password" class="text text-long col-sm-12 col-xs-12" value="" name="oldpassword">
								</div>
							</li>
							<li>
								<label class="col-sm-3 col-xs-12"><span>*</span>New Password:</label>
								<div class="col-sm-9 col-xs-12">
									<input type="password" class="text text-long col-sm-12 col-xs-12" value="" id="password" name="password">
								</div>
							</li>
							<li>
								<label class="col-sm-3 col-xs-12"><span>*</span>Confirm Password:</label>
								<div class="col-sm-9 col-xs-12">
									<input type="password" class="text text-long col-sm-12 col-xs-12" value="" name="confirmpassword">
								</div>
							</li>
							<li>
								<label class="col-sm-3 hidden-xs">&nbsp;</label>
								<div class="btn-grid12 col-sm-9 col-xs-12">
									<input type="submit" class="btn btn-primary btn-sm" value="Change Password" name="">
								</div>
							</li>
						</ul>
					</form>
					<div class="col-sm-2 hidden-xs"></div>
				</div>
			</article>
		</div>
	</div>
</section>
<script type="text/javascript">

    $(".user-share-form").validate({
        rules: {
            oldpassword: {    
                required: true,
                minlength: 5,
                maxlength:20
            },
            password: {
                required: true,
                minlength: 5,
                maxlength:20
            },
            confirmpassword: {
                required: true,
                minlength: 5,
                maxlength:20,
                equalTo: "#password"
            }
        },
        messages: {
            oldpassword: {
                required: "Please provide a password.",
                minlength: "Your password must be at least 5 characters long.",
                maxlength:"The password exceeds maximum length of 20 characters."
            },
            password: {
                required: "Please provide a password.",
                minlength: "Your password must be at least 5 characters long.",
                maxlength:"The password exceeds maximum length of 20 characters."
            },
            confirmpassword: {
                required: "Please provide a password.",
                minlength: "Your password must be at least 5 characters long.",
                maxlength:"The password exceeds maximum length of 20 characters.",
                equalTo: "Please enter the same password as above."
            }
        }
    });
</script>
