<div class="col-md-3 rsidebar">
    <div class="rsidebar-top">
       <?php foreach ($this->group as $g): ?>
        <div class="slider-left">
            <h4><?= $g['title'] ?></h4>            
            <div class="row row1 scroll-pane">
                <?php  foreach ($this->values[$g['id']] as $key => $value): ?>
                <?php 
                    if(!empty($filter) && in_array($key, $filter)){
                        $checked = 'checked';
                    }else{
                        $checked = '';
                    }
                ?>

                <label class="checkbox">
                    <input type="checkbox" name="checkbox" <?= $checked ?> value="<?= $key ?>"><i></i>
                    <?= $value ?>
                    </label>
                
                <?php endforeach; ?>
            </div> 
        </div>
        <?php endforeach; ?>
                    
    </div>
</div>