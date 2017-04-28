<div class="site-content">
    <!-- crumbs -->
    <div class="container">
        <div class="crumbs row">
            <div class="col-xs-12">
                <a href="/">home</a> > forgot password
            </div>
        </div>
        <?php echo Message::get(); ?>
    </div>
    <!-- main-middle begin -->
    <div class="container">
        <div class="row">
            <aside id="aside" class="col-sm-1 hidden-xs"></aside>
            <article class="user col-sm-10 col-xs-12">
                <div class="tit">
                    <h2>Forgot Password</h2>
                </div>
                <form class="forgot-psd-form col-xs-12" method="post" action="/customer/forgot_password">
                    <p>Please enter your email address below. We will send your original password to your email box. The process may take a little time because of the potential system delay. Thanks for your patience.</p>
                    <ul>
                        <li>
                            <label class="col-sm-2 col-xs-12">
                                <span>*</span> Your Email:
                            </label>
                            <div>
                                <input class="text col-xs-12" type="text" value="" name="email">
                            </div>
                        </li>
                        <li>
                            <label class="hidden-xs col-sm-2"> </label>
                            <div>
                                <input class="btn btn-primary btn-lg" type="submit" value="Submit" name="">
                            </div>
                        </li>
                    </ul>
                </form>
            </article>
        </div>
    </div>
</div>
<script type="text/javascript">

/* forgot-psd-form */
$(".forgot-psd-form").validate({
    rules: {
        email: {    
            required: true,
            email: true
        }
    },
    messages: {
        email: {
            required:"&nbsp;&nbsp;Please provide an email.",
            email:"&nbsp;&nbsp;Please enter a valid email address."
        }
    }
});
</script>
