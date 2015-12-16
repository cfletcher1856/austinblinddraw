<?php if(isset($this->page_header)): ?>
<div class="page-header">
  <h1><?php echo $this->page_header; ?>
    <?php if(isset($this->sub_header)): ?>
    <small><?php echo $this->sub_header; ?></small>
    <?php endif; ?>
  </h1>
</div>
<?php endif; ?>
