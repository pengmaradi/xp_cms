<?php

/**
 * @filename = useradmin_view
 * @deprecated =
 *
 * @author = xiaoling
 * @copyright = pengmaradi
 * @email = pengmaradi@gmail.com
 * @link = http://pengmaradi.szmay.com
 * @license = ...
 * @version = 1.0
 */
echo $menu;
?>
<div id="maincontent" class="useradmin">
    
    <div class="tabs">
        <h3>contact to</h3>
        <div class="tab">
            <div class="tab_inner">
<?php $this->load->controller('admin/admin/contact'); ?>
            </div>
        </div>
    </div>
    
    <div class="tabs">
     <h3>change password</h3>
     <div class="tab">
         <div class="tab_inner">
    <?php 
    $this->load->controller('admin/admin/index'); ?>
         </div>
     </div>
    </div>
    
    <div class="tabs">
        <h3>add user</h3>
        <div class="tab">
            <div class="tab_inner">
                
<?php
$this->load->controller('admin/admin/add'); ?>            
            </div>
        </div>
    </div>
    
    <div class="tabs">
        <h3>administration</h3>
        <div class="tab">
            <div class="tab_inner">
<?php $this->load->controller('admin/admin/administration'); ?>
            </div>
        </div>
    </div>
    

    
    <div class="clear"></div>
</div>
<script>
(function($){
   $('.tab:eq(0)').show();
   $('.tabs:eq(0) h3').addClass('act');
   $('.tabs h3').each(function(){
       $(this).click(function(){
           $(this).addClass('act');
           $(this).closest('.tabs').siblings().find('h3').removeClass('act');
           $(this).closest('.tabs').siblings().find('.tab').hide();
           $(this).next().show();
       });
   });
})(jQuery);    
</script>