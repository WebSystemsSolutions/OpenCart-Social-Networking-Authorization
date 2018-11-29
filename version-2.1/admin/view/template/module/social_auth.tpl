<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-account" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-account" class="form-horizontal">

          <div class="container-fluid">
            <div class="panel-heading">
                <h3 class="panel-title">Facebook settings</h3>
            </div>
            
              <div class="form-group">
                <label class="col-sm-2 control-label">facebook app id</label>
                <div class="col-sm-10">
                  <input type="text" name="social_auth_facebook_app_id" value="<?php echo $social_auth_facebook_app_id; ?>" class="form-control"/>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">facebook secret key</label>
                <div class="col-sm-10">
                  <input type="text" name="social_auth_facebook_secret_key" value="<?php echo $social_auth_facebook_secret_key; ?>" class="form-control"/>
                </div>
              </div>

                <div class="form-group">
                <label class="col-sm-2 control-label">facebook calback href <br/> (enter in facebook aplication) </label>
                <div class="col-sm-10">
                    <span class="form-group"><?php echo $social_auth_facebook_calback_href; ?></span>
                </div>
              </div>
              
          </div>

          <div class="container-fluid">
            <div class="panel-heading">
                <h3 class="panel-title">Google settings</h3>
            </div>
            
              <div class="form-group">
                <label class="col-sm-2 control-label">google app id</label>
                <div class="col-sm-10">
                  <input type="text" name="social_auth_google_app_id" value="<?php echo $social_auth_google_app_id; ?>" class="form-control"/>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">google secret key</label>
                <div class="col-sm-10">
                  <input type="text" name="social_auth_google_secret_key" value="<?php echo $social_auth_google_secret_key; ?>" class="form-control"/>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">google calback href <br/> (enter in google aplication) </label>
                <div class="col-sm-10">
                    <span class="form-group"><?php echo $social_auth_google_calback_href; ?></span>
                </div>
              </div>
              
          </div>

        <div class="container-fluid">
            <div class="panel-heading">
                <h3 class="panel-title">Instagram settings</h3>
            </div>
            
              <div class="form-group">
                <label class="col-sm-2 control-label">instagram client id</label>
                <div class="col-sm-10">
                  <input type="text" name="social_auth_insatagram_client_id" value="<?php echo $social_auth_insatagram_client_id; ?>" class="form-control"/>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">instagram secret key</label>
                <div class="col-sm-10">
                  <input type="text" name="social_auth_insatagram_secret_key" value="<?php echo $social_auth_insatagram_secret_key; ?>" class="form-control"/>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">instagram calback href <br/> (enter in instagram aplication) </label>
                <div class="col-sm-10">
                    <span class="form-group"><?php echo $social_auth_instagram_calback_href; ?></span>
                </div>
              </div>
              
          </div>


          <div class="container-fluid">
            <div class="panel-heading">
                <h3 class="panel-title">Install</h3>
            </div>
            
              <div class="form-group">
                <label class="col-sm-4 control-label">register API</label>
                <div class="col-sm-8">
                  <span class="form-group">
                       Facebook - <a href="https://developers.facebook.com/apps/">https://developers.facebook.com/apps/</a>  <br/>
                       
                        Google - <a href="https://console.cloud.google.com/apis/">https://console.cloud.google.com/apis/</a> <br/>
                        
                        Instagram - <a href="https://www.instagram.com/developer/register/">https://www.instagram.com/developer/register/</a>, 
                         <a href="https://www.instagram.com/developer/clients/register/">https://www.instagram.com/developer/clients/register/</a>  <br/>
                      </span>
                </div>
              </div>
              
              <div class="form-group">
                <label class="col-sm-4 control-label">ADD IN /catalog/view/theme/default/template/common/header.tpl</label>
                <div class="col-sm-8">
                  <span class="form-group">
                      <code>
                        &lt;script src="catalog/view/javascript/social_auth.js" type="text/javascript">&lt;/script>
                      </code>
                  </span>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-4 control-label">BUTTONS add :</label>
                <div class="col-sm-8">
                  <span class="form-group">
                      <code>
                        &lt;button type="button" onclick="social_auth.facebook(this)" data-loading-text="Loading" class="btn btn-primary">FB&lt;/button>
                      </code>
                      <br/>
                      <br/>
                      <code>
                        &lt;button type="button" onclick="social_auth.googleplus(this)" data-loading-text="Loading" class="btn btn-primary">G+&lt;/button>
                      </code>
                      <br/>
                      <br/>
                      <code>
                        &lt;button type="button" onclick="social_auth.instagram(this)" data-loading-text="Loading" class="btn btn-primary">Insta&lt;/button>
                      </code>
                      </span>
                </div>
              </div>

              
              
          </div>
          
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>
