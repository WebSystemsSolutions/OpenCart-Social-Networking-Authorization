
<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="social" data-toggle="tooltip" title="Save" class="btn btn-primary">Save</button></div>
      <h1><?php echo 'Oauth v1.1'; ?></h1>
      </ul>
    </div>
  </div>
  <!--my hmtml -->
<div class="container-fluid">
  	<ul class="nav nav-tabs">
  		<li role="presentation" class="active"><a href="#facebook" data-toggle="tab">Facebook</a></li>
  		<li role="presentation"><a href="#google" data-toggle="tab">Google</a></li>
  		<li role="presentation"><a href="#install" data-toggle="tab">Install</a></li>
	</ul>

<div class="well">
<form action="<?=$action?>" id="social" class="form-horizontal" method="post" enctype="multipart/form-data">
<div class="tab-content">
    <div id="facebook" class="tab-pane fade in active">
      <h3>Facebook</h3>
       	<div class="form-group">
    		<label class="col-sm-2 control-label">Ид приложение</label>
    		<div class="col-sm-10">
    			<input type="text" name="oauth_id_app_facebook" value="<?php echo $id_app_facebook; ?>" class="form-control" id="name" placeholder="Ид приложение">
    		</div>
    </div>
    <div class="form-group">
    		<label class="col-sm-2 control-label">Извлекти максимум</label>
    		<div class="col-sm-10">
    			<input type="radio" name="oauth_f_opt" id="inlineRadio1" value="1" checked="checked"> НЕТ
    			<input type="radio" name="oauth_f_opt" id="inlineRadio1" value="2"> ДА
    		</div>
    </div>
</div>
    <div id="google" class="tab-pane fade">
      <h3>Google</h3>
      	<div class="form-group">
    		<label class="col-sm-2 control-label">Ид приложение</label>
    		<div class="col-sm-10">
    			<input type="text" name="oauth_id_app" value="<?php echo $id_app; ?>"  class="form-control" id="name" placeholder="Ид приложение">
    		</div>
    	</div>
    	<div class="form-group">
    		<label class="col-sm-2 control-label">Секретний ключ</label>
    		<div class="col-sm-10">
    			<input type="text" name="oauth_secret_key" value="<?php echo $secret_key; ?>" class="form-control" id="secret" placeholder="Секретний ключ">
    		</div>
    	</div>
    	<div class="form-group">
    		<label class="col-sm-2 control-label">Келбек</label>
    		<div class="col-sm-10">
    			<input type="text" name="oauth_calback" value="<?php echo $calback; ?>" class="form-control" id="secret" placeholder="Келбек">
    		</div>
    	</div>
    </div>
    <div id="install" class="tab-pane fade">
      <h3>Install</h3>
      <p><?=$txt ?></p>
    </div>
  </div>
   </form>
 </div> 
 </div>




 
</div>
<?php echo $footer; ?>