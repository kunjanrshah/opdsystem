<!-- START Template Container -->
<div class="container-fluid">
    <!-- START row -->
    <?php $this->renderPartial("/layouts/_message"); ?>
    <div class="row">
        <!-- Left / Top Side -->
        <div class="col-lg-3">
            <!-- tab menu -->
            <ul class="list-group list-group-tabs">
                <li class="list-group-item active"><a data-toggle="tab" href="#profile"><i class="ico-user2 mr5"></i> Personal Information</a></li>
                <li class="list-group-item"><a data-toggle="tab" href="#account"><i class="ico-calendar5 mr5"></i> Doctor Visits</a></li>
                <li class="list-group-item"><a data-toggle="tab" href="#security"><i class="ico-medkit mr5"></i> Treatments</a></li>
                <li class="list-group-item"><a data-toggle="tab" href="#password"><i class="ico-key2 mr5"></i> Password</a></li>
            </ul>
            <!-- tab menu -->

            <hr><!-- horizontal line -->

            <!-- figure with progress -->
            <ul class="list-table">
                <li style="width:70px;">
                    <img width="65px" alt="" src="<?php echo Yii::app()->params->ADMIN_BT_URL;?>image/avatar/avatar7.jpg" class="img-circle img-bordered">
                </li>
                <li class="text-left">
                    <h5 class="semibold ellipsis mt0">Erich Reyes</h5>
                    <div style="max-width:200px;">
                        <div class="progress progress-xs mb5">
                            <div style="width:70%" class="progress-bar progress-bar-warning"></div>
                        </div>
                        <p class="text-muted clearfix nm">
                            <span class="pull-left">Profile complete</span>
                            <span class="pull-right">70%</span>
                        </p>
                    </div>
                </li>
            </ul>
            <!--/ figure with progress -->

            <hr><!-- horizontal line -->

            <!-- follower stats -->
            <ul class="nav nav-section nav-justified mt15">
                <li>
                    <div class="section">
                        <h4 class="nm semibold">12.5k</h4>
                        <p class="nm text-muted">Followers</p>
                    </div>
                </li>
                <li>
                    <div class="section">
                        <h4 class="nm semibold">1853</h4>
                        <p class="nm text-muted">Following</p>
                    </div>
                </li>
                <li>
                    <div class="section">
                        <h4 class="nm semibold">3451</h4>
                        <p class="nm text-muted">Tweets</p>
                    </div>
                </li>
            </ul>
            <!--/ follower stats -->
        </div>
        <!--/ Left / Top Side -->

        <!-- Left / Bottom Side -->
        <div class="col-lg-9">
            <!-- START Tab-content -->
            <div class="tab-content">
                <!-- tab-pane: profile -->
                <div id="profile" class="tab-pane active">
                    <!-- form profile -->
                    <form name="form-profile" class="panel form-horizontal form-bordered">
                        <div class="panel-body pt0 pb0">
                            <div class="form-group header bgcolor-default">
                                <div class="col-md-12">
                                    <h4 class="semibold text-primary mt0 mb5">Profile</h4>
                                    <p class="text-default nm">This information appears on your public profile, search results, and beyond.</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Photo</label>
                                <div class="col-sm-9">
                                    <div class="btn-group pr5">
                                        <img width="34px" alt="" src="image/avatar/avatar7.jpg" class="img-circle img-bordered">
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn btn-default" type="button">Change photo</button>
                                        <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button">
                                            <span class="caret"></span>
                                        </button>
                                        <ul role="menu" class="dropdown-menu">
                                            <li><a href="#">Upload photo</a></li>
                                            <li><a href="#">Remove</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Name</label>
                                <div class="col-sm-6">
                                    <input type="text" value="Erich Reyes" name="name" class="form-control">
                                    <p class="help-block">Enter your real name.</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Location</label>
                                <div class="col-sm-5">
                                    <input type="text" name="location" class="form-control">
                                    <p class="help-block">Where in the world are you?</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Website</label>
                                <div class="col-sm-6">
                                    <input type="text" value="http://" name="website" class="form-control">
                                    <p class="help-block">Have a homepage or a blog? Put the address here.</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Bio</label>
                                <div class="col-sm-6">
                                    <textarea placeholder="Describe about yourself" rows="3" class="form-control"></textarea>
                                    <p class="help-block">About yourself in 160 characters or less.</p>
                                </div>
                            </div>
                            <div class="form-group header bgcolor-default">
                                <div class="col-md-12">
                                    <h4 class="semibold text-primary nm">Facebook</h4>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">&nbsp;</label>
                                <div class="col-sm-9">
                                    <div class="btn-group pr5">
                                        <img width="34px" alt="" src="image/avatar/avatar7.jpg" class="img-circle img-bordered">
                                    </div>
                                    <a class="btn btn-facebook" href="javascript:void(0);">Login to facebook</a>
                                    <p class="help-block">to manage your connection with Facebook.</p>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <button class="btn btn-default" type="reset">Reset</button>
                            <button class="btn btn-primary" type="submit">Save change</button>
                        </div>
                    </form>
                    <!--/ form profile -->
                </div>
                <!--/ tab-pane: profile -->

                <!-- tab-pane: account -->
                <div id="account" class="tab-pane">
                    <!-- form account -->
                    <form name="form-account" class="panel form-horizontal form-bordered">
                        <div class="panel-body pt0 pb0">
                            <div class="form-group header bgcolor-default">
                                <div class="col-md-12">
                                    <h4 class="semibold text-primary mt0 mb5">Account</h4>
                                    <p class="text-default nm">Change your basic account and language settings.</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Username</label>
                                <div class="col-sm-4">
                                    <input type="text" value="erich.reyes" name="username" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Email</label>
                                <div class="col-sm-5">
                                    <input type="text" name="email" class="form-control">
                                    <p class="help-block">Email will not be publicly displayed. <a href="javascript:void(0);">Learn more.</a></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">language</label>
                                <div class="col-sm-5">
                                    <select name="language" class="form-control">
                                        <option>Select Language...</option>
                                        <option value="eu">Basque - Euskara (beta)</option>
                                        <option value="ca">Catalan - català (beta)</option>
                                        <option value="cs">Czech - Čeština (beta)</option>
                                        <option value="da">Danish - Dansk</option>
                                        <option value="nl">Dutch - Nederlands</option>
                                        <option selected="" value="en">English</option>
                                        <option value="en-gb">English UK - EnglishUK</option>
                                        <option value="fil">Filipino - Filipino</option>
                                        <option value="fi">Finnish - Suomi</option>
                                        <option value="fr">French - français</option>
                                        <option value="gl">Galician - Galego (beta)</option>
                                        <option value="de">German - Deutsch</option>
                                        <option value="el">Greek - Ελληνικά (beta)</option>
                                        <option value="hu">Hungarian - Magyar</option>
                                        <option value="id">Indonesian - Bahasa Indonesia</option>
                                        <option value="it">Italian - Italiano</option>
                                        <option value="xx-lc">Lolcat - LOLCATZ (beta)</option>
                                        <option value="msa">Malay - Bahasa Melayu</option>
                                        <option value="no">Norwegian - Norsk</option>
                                        <option value="pl">Polish - Polski</option>
                                        <option value="pt">Portuguese - Português</option>
                                        <option value="ro">Romanian - română (beta)</option>
                                        <option value="ru">Russian - Русский</option>
                                        <option value="es">Spanish - Español</option>
                                        <option value="sv">Swedish - Svenska</option>
                                        <option value="tr">Turkish - Türkçe</option>
                                        <option value="uk">Ukrainian - Українська мова (beta)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Timezone</label>
                                <div class="col-sm-5">
                                    <select name="timezone" class="form-control">
                                        <option value="Hawaii" data-offset="-36000">(GMT-10:00) Hawaii</option>
                                        <option value="Alaska" data-offset="-32400">(GMT-09:00) Alaska</option>
                                        <option value="Pacific Time (US &amp; Canada)" data-offset="-28800">(GMT-08:00) Pacific Time (US &amp; Canada)</option>
                                        <option value="Arizona" data-offset="-25200">(GMT-07:00) Arizona</option>
                                        <option value="Mountain Time (US &amp; Canada)" data-offset="-25200">(GMT-07:00) Mountain Time (US &amp; Canada)</option>
                                        <option value="Central Time (US &amp; Canada)" data-offset="-21600">(GMT-06:00) Central Time (US &amp; Canada)</option>
                                        <option value="Eastern Time (US &amp; Canada)" data-offset="-18000">(GMT-05:00) Eastern Time (US &amp; Canada)</option>
                                        <option value="Indiana (East)" data-offset="-18000">(GMT-05:00) Indiana (East)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group header bgcolor-default">
                                <div class="col-md-12">
                                    <h4 class="semibold text-primary mt0 mb5">Content</h4>
                                    <p class="text-default nm">Change your change settings.</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Country</label>
                                <div class="col-sm-5">
                                    <select name="country" class="form-control">
                                        <option selected="" value="xx">Worldwide</option>
                                        <option value="af">Afghanistan</option>
                                        <option value="dz">Algeria</option>
                                        <option value="ar">Argentina</option>
                                        <option value="au">Australia</option>
                                        <option value="bd">Bangladesh</option>
                                        <option value="br">Brazil</option>
                                        <option value="cm">Cameroon</option>
                                        <option value="ca">Canada</option>
                                        <option value="co">Colombia</option>
                                        <option value="dk">Denmark</option>
                                        <option value="eg">Egypt</option>
                                        <option value="et">Ethiopia</option>
                                        <option value="fr">France</option>
                                        <option value="de">Germany</option>
                                        <option value="gh">Ghana</option>
                                        <option value="gr">Greece</option>
                                        <option value="in">India</option>
                                        <option value="id">Indonesia</option>
                                        <option value="iq">Iraq</option>
                                        <option value="ie">Ireland</option>
                                        <option value="il">Israel</option>
                                        <option value="it">Italy</option>
                                        <option value="jp">Japan</option>
                                        <option value="ke">Kenya</option>
                                        <option value="mg">Madagascar</option>
                                        <option value="my">Malaysia</option>
                                        <option value="mx">Mexico</option>
                                        <option value="ma">Morocco</option>
                                        <option value="mz">Mozambique</option>
                                        <option value="np">Nepal</option>
                                        <option value="nl">Netherlands</option>
                                        <option value="nz">New Zealand</option>
                                        <option value="ng">Nigeria</option>
                                        <option value="pk">Pakistan</option>
                                        <option value="pe">Peru</option>
                                        <option value="ph">Philippines</option>
                                        <option value="pl">Poland</option>
                                        <option value="ro">Romania</option>
                                        <option value="ru">Russia</option>
                                        <option value="sa">Saudi Arabia</option>
                                        <option value="sg">Singapore</option>
                                        <option value="za">South Africa</option>
                                        <option value="kr">South Korea</option>
                                        <option value="es">Spain</option>
                                        <option value="lk">Sri Lanka</option>
                                        <option value="se">Sweden</option>
                                        <option value="ch">Switzerland</option>
                                        <option value="tw">Taiwan</option>
                                        <option value="tz">Tanzania</option>
                                        <option value="th">Thailand</option>
                                        <option value="tr">Turkey</option>
                                        <option value="ug">Uganda</option>
                                        <option value="ua">Ukraine</option>
                                        <option value="gb">United Kingdom</option>
                                        <option value="us">United States</option>
                                        <option value="uz">Uzbekistan</option>
                                        <option value="ve">Venezuela</option>
                                        <option value="vn">Vietnam</option>
                                        <option value="ye">Yemen</option>
                                    </select>
                                    <p class="help-block">Select your country. This setting is saved to this browser.</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Media</label>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <span class="checkbox custom-checkbox">
                                                <input type="checkbox" id="customcheckbox1" name="customcheckbox1">
                                                <label for="customcheckbox1">&nbsp;&nbsp;You will see all photos or videos even if they contain sensitive media.</label>
                                            </span>
                                            <p class="help-block">You will see all photos or videos even if they contain sensitive media.</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <span class="checkbox custom-checkbox">
                                                <input type="checkbox" id="customcheckbox2" name="customcheckbox2">
                                                <label for="customcheckbox2">&nbsp;&nbsp;Mark media containing material that may be sensitive</label>
                                            </span>
                                            <p class="help-block">Please check this box so that users can be informed prior to viewing.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <button class="btn btn-default" type="reset">Reset</button>
                            <button class="btn btn-primary" type="submit">Save change</button>
                        </div>
                    </form>
                    <!--/ form account -->
                </div>
                <!--/ tab-pane: account -->

                <!-- tab-pane: security -->
                <div id="security" class="tab-pane">
                    <!-- form security -->
                    <form name="form-security" class="panel form-horizontal form-bordered">
                        <div class="panel-body pt0 pb0">
                            <div class="form-group header bgcolor-default">
                                <div class="col-md-12">
                                    <h4 class="semibold text-primary mt0 mb5">Security</h4>
                                    <p class="text-default nm">Change your security settings.</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Login verification</label>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <span class="radio custom-radio">
                                                <input type="radio" id="loginverification1" name="loginverification">
                                                <label for="loginverification1">&nbsp;&nbsp;Send login verification requests to my phone</label>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <span class="radio custom-radio">
                                                <input type="radio" id="loginverification2" name="loginverification">
                                                <label for="loginverification2">&nbsp;&nbsp;Send login verification requests to my phone</label>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Password reset</label>
                                <div class="col-sm-9">
                                    <span class="checkbox custom-checkbox">
                                        <input type="checkbox" id="passwordreset" name="passwordreset">
                                        <label for="passwordreset">&nbsp;&nbsp;Require personal information to reset my password</label>
                                    </span>
                                    <p class="help-block">By default, you can initiate a password reset by entering only your @username. If you check this box, you will be prompted to enter your email address or phone number if you forget your password.</p>
                                </div>
                            </div>
                            <div class="form-group header bgcolor-default">
                                <div class="col-md-12">
                                    <h4 class="semibold text-primary mt0 mb5">Privacy</h4>
                                    <p class="text-default nm">Change your privacy settings.</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Photo tagging</label>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <span class="radio custom-radio">
                                                <input type="radio" id="phototagging1" name="phototagging">
                                                <label for="phototagging1">&nbsp;&nbsp;Allow anyone to tag me in photos</label>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <span class="radio custom-radio">
                                                <input type="radio" id="phototagging2" name="phototagging">
                                                <label for="phototagging2">&nbsp;&nbsp;Only allow people I follow to tag me in photos</label>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <span class="radio custom-radio">
                                                <input type="radio" id="phototagging3" name="phototagging">
                                                <label for="phototagging3">&nbsp;&nbsp;Do not allow anyone to tag me in photos</label>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Discoverability</label>
                                <div class="col-sm-9">
                                    <span class="checkbox custom-checkbox">
                                        <input type="checkbox" id="discoverability" name="discoverability">
                                        <label for="discoverability">&nbsp;&nbsp;Let others find me by my email address</label>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Personalization</label>
                                <div class="col-sm-9">
                                    <span class="checkbox custom-checkbox">
                                        <input type="checkbox" id="personalization" name="personalization">
                                        <label for="personalization">&nbsp;&nbsp;Tailor content based on my recent website visits</label>
                                    </span>
                                    <p class="help-block"><a href="javascript:void(0);">Learn more</a> about how this works and your additional privacy controls.</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Promoted content</label>
                                <div class="col-sm-9">
                                    <span class="checkbox custom-checkbox">
                                        <input type="checkbox" id="ads" name="ads">
                                        <label for="ads">&nbsp;&nbsp;Tailor ads based on information shared by ad partners.</label>
                                    </span>
                                    <p class="help-block"><a href="javascript:void(0);">Learn more</a> about how this works and your additional privacy controls.</p>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <button class="btn btn-default" type="reset">Reset</button>
                            <button class="btn btn-primary" type="submit">Save change</button>
                        </div>
                    </form>
                </div>
                <!--/ tab-pane: security -->

                <!-- tab-pane: password -->
                <div id="password" class="tab-pane">
                    <!-- form password -->
                    <form name="form-password" class="panel form-horizontal form-bordered">
                        <div class="panel-body pt0 pb0">
                            <div class="form-group header bgcolor-default">
                                <div class="col-md-12">
                                    <h4 class="semibold text-primary mt0 mb5">Password</h4>
                                    <p class="text-default nm">Change your password or recover your current one.</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Current password</label>
                                <div class="col-sm-5">
                                    <input type="text" name="currentpass" class="form-control">
                                    <p class="help-block"><a href="javascript:void(0);">Forgot password?</a></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">New password</label>
                                <div class="col-sm-5">
                                    <input type="text" name="newpass" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Verify password</label>
                                <div class="col-sm-5">
                                    <input type="text" name="verifypass" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <button class="btn btn-default" type="reset">Reset</button>
                            <button class="btn btn-primary" type="submit">Save change</button>
                        </div>
                    </form>
                </div>
                <!--/ tab-pane: password -->
            </div>
            <!--/ END Tab-content -->
        </div>
        <!--/ Left / Bottom Side -->
    </div>
    <!--/ END row -->
</div>
<!--/ END Template Container -->