<div class="itemEditor" id="<?= $this->getEditorId() ?>">
	<form>
	<h2><span><?= $this->getEditorTitle() ?>: </span><span class="title">
		<span class="titletext"></span>
		<img alt="" src="<?=BASEURL?>img/edit.png" class="titleEditActivate"></span>
		<img alt="" src="<?=BASEURL?>img/OK.png" class="titleEditDeactivate"></span>
	</h2>
<?= $this->getFormHtml() ?>
	<input type="submit" value="Update" title="Update" class="submitbutton">
	</form>
</div>