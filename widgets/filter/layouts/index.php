<div class="col-md-3 rsidebar">
    <div class="rsidebar-top">
       <?php foreach ($this->group as $g): ?>
        <div class="slider-left">
            <h4><?= $g['title'] ?></h4>            
            <div class="row row1 scroll-pane">
                <?php foreach ($this->values[$g['id']] as $key => $value): ?>
                
                <label class="checkbox">
                    <input type="checkbox" name="checkbox"><i></i>
                    <?= $value ?>
                    </label>
                
                <?php endforeach; ?>
            </div> 
        </div>
        <?php endforeach; ?>
                    
    </div>
</div>