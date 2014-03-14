<div class="ccs-album">
    <div class="col-md-12 ccs-album-inner">
        <?php
            $pictures = glob('uploads/albums/'.$album_name.'/*');
            $slides = glob('uploads/albums/slides/*');
            natcasesort($slides);
            natcasesort($pictures);

            $i = 0;
            foreach($pictures as $pic){
                $path_parts = pathinfo($pic);
                $extension = $path_parts['extension'];

                if($extension != 'txt') $i++;
            }
        ?>
        <div id="links">
            <div class="ccs-album-name-header">
                <span><?php echo $album_name; ?></span>
                <?php if($this->authentication->is_authorized_function_by_name('Album/upload') || $this->authentication->is_authorized_function_by_name('Gallery/add_to_slides')){ ?>
                    <div>
                        <?php if($this->authentication->is_authorized_function_by_name('Album/upload')){ ?>
                        <button class="btn btn-sm" id="add-picture" style="border-radius: 0; margin-bottom: 5px"><i class="icon-upload-alt"></i> Upload</button>
                        <?php } if($this->authentication->is_authorized_function_by_name('Gallery/add_to_slides') && $album_name != 'slides' && $i > 0){ ?>
                        <button class="btn btn-sm" id="select-picture" style="border-radius: 0; margin-bottom: 5px"><i class="icon-check"></i> Add to slides</button>
                        <?php } if($this->authentication->is_authorized_function_by_name('Gallery/delete_picture') && $i > 0){ ?>
                        <button class="btn btn-sm" id="delete-picture" style="border-radius: 0; margin-bottom: 5px"><i class="icon-trash"></i> Delete Photos</button>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
            <form method="POST" name="slide">
        <?php
            
            $index = 0;
            foreach($pictures as $picture) {
               $path_parts = pathinfo($picture); 
               $filename = $path_parts['filename'];
               $extension = $path_parts['extension'];
               if($extension == 'jpg' || $extension == 'gif' || $extension == 'png'){ ?>
                <div class="gallery-options-container-wrapper" style="display: inline-block">
                    <div class="gallery-options-container" data-index="<?php echo $index ?>">
                        <?php if($this->authentication->is_authorized_function_by_name('Gallery/delete_picture') || $this->authentication->is_authorized_function_by_name('Gallery/set_album_cover')){ ?>
                        <div class="dropdown pull-right gallery-options-dropdown">
                            <a href="#" data-toggle="dropdown" class="btn btn-default gallery-options"><i class="icon-cog"></i></a>
                            <ul class="dropdown-menu" style="min-width:0;" data-value="<?php echo $filename . '.' . $extension ?>" data-album="<?php echo $album_name ?>">
                                <?php if($this->authentication->is_authorized_function_by_name('Gallery/delete_picture')){ ?>
                                <li><a href="#" class="delete"><i class="icon-trash"></i> Delete</a></li>
                                <?php } if($this->authentication->is_authorized_function_by_name('Gallery/set_album_cover')){ ?>
                                <li><a href="#" class="cover"><i class="icon-picture"></i> Set as cover</a></li>
                                <?php } //if($this->authentication->is_authorized_function_by_name('Gallery/add_to_slides') && $album_name != 'slides'){ ?>
                                <!--<li><a href="#" class="slides"><i class="icon-leaf"></i> Add to slides</a></li>-->
                                <?php //} ?>
                                <li><a href="<?php echo base_url() . 'album/download/' . $album_name . '/' . $filename . '.' . $extension ?>" class="download"><i class="icon-download-alt"></i> Download</a></li>
                            </ul>
                        </div>
                        <?php } ?>
                        <a href="<?php echo base_url() . 'uploads/albums/' . $album_name . '/' . $filename . '.' . $extension ?>" data-gallery title="<?php echo $filename ?>">
                            <img src="<?php echo base_url() . 'uploads/albums/' . $album_name . '/' . $filename . '.' . $extension ?>" alt="<?php echo $filename . '.' . $extension ?>"/>
                        </a>
                    </div><br/>
                    <?php if($this->authentication->is_authorized_function_by_name('Gallery/add_to_slides') && $album_name != 'slides'){ ?>
                    <?php $flag = FALSE; 
                        foreach($slides as $slide){ 
                            $slide_parts = pathinfo($slide); 
                            $slide_filename = $slide_parts['filename']; 

                            $extension = $slide_parts['extension'];

                            $clean_filename = preg_replace('/[0-9a-zA-Z]+_/i','', $filename, 1);
                            $clean_name = preg_replace('/[0-9a-zA-Z]+_/i','', $slide_filename, 1);

                            if($clean_filename == $clean_name && $extension != 'txt') $flag = TRUE;
                        }
                    ?>
                    <div class="ccs-add-remove-image-to-slides-container hide" style="margin: 0 0 7px 7px; text-align: center" <?php echo ($flag)?'title="Photo already added."':'' ?>>
                        <button <?php echo ($flag)?'disabled':'' ?> title="Add to slides." type="button" style="border-radius: 0" class="ccs-add-remove-image-to-slides btn btn-default btn-block">
                            <i class="<?php echo ($flag)?'icon-ok':'icon-plus' ?>"></i>
                        </button>
                        <input disabled class="hide" type="checkbox" value="<?php echo $album_name.'/'.$filename.'.'.$extension ?>" name="slides[]"/>
                    </div>
                    <?php } ?>
                    <div class="ccs-delete-photos-in-album-container hide" style="margin: 0 0 7px 7px; text-align: center">
                        <button title="Delete this photo." type="button" style="border-radius: 0" class="ccs-delete-photos-in-album btn btn-default btn-block">
                            <i class="icon-check-empty"></i>
                        </button>
                        <input disabled class="hide" type="checkbox" value="<?php echo $album_name.'/'.$filename.'.'.$extension ?>" name="delete[]"/>
                    </div>
                </div>
            <?php   

            $index++; }}
            ?>
            <?php
            if(!$index){
                echo '<div class="gallery-caption" style="padding: 10px 0">No Photos Available</div>';
            }
            ?>
            <div class="ccs-submit-cancel-btn hide" style="border-top: 1px solid #aaa; text-align: right; margin: 0 8px; padding: 10px 0">
                <button class="btn btn-sm" type="submit" style="margin-right: 5px"><i class="icon-ok"></i> Submit</button>
                <button class="btn btn-sm" type="reset"><i class="icon-remove"></i> Cancel</button>
            </div>
            </form>
        </div>
        
        <div class="modal fade" id="modal-upload">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><?php echo $album_name ?></h4>
                    </div>
                    <div class="modal-body">
                        <table id="uploadPreview" class="table" style="min-width: 1px">
                            <tr>
                                <th>Preview</th>
                                <th>Image Name</th>
                                <th>Size</th>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <!--<button class="pull-left btn btn-sm" id="add-more-pictures"><i class="icon-plus"></i> Add photo (s)</button>-->
                        <form class="ccs-change-profile-picture" method="POST" action="<?php echo base_url() ?>album/upload/<?php echo str_replace(" ","_",$album_name) ?>" enctype="multipart/form-data">
                            <input class="hide" id="ccs-gallery-upload-picture" type="file" multiple name="images[]" />
                            <!-- <input class="btn btn-primary" type="submit" id="ccs-upload" value="Upload"> -->
                            <button class="btn btn-primary" type="submit" id="ccs-upload"><i class="icon-upload"></i> Upload</button>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <div id="blueimp-gallery" class="gallery blueimp-gallery">
            <!-- The container for the modal slides -->
            <div class="slides"></div>
            <!-- Controls for the borderless lightbox -->
            <h3 class="title"></h3>
            <a class="prev">&lsaquo;</a>
            <a class="next">&rsaquo;</a>
            <a class="close">&times;</a>
            <a class="play-pause"></a>
            <ol class="indicator"></ol>
            <!-- The modal dialog, which will be used to wrap the lightbox content -->
            <div class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-close">
                            <a href="#">&times;</a>
                        </div>
                        <div class="modal-body next"></div>
                        <a href="#" class="left carousel-control prev">
                            <i class="glyphicon glyphicon-chevron-left"></i>
                        </a>
                        <a href="#" class="right carousel-control next">
                            <i class="glyphicon glyphicon-chevron-right"></i>
                        </a>
                        <div class="modal-options">
                            <span class="title">
                                <a href="<?php echo base_url() ?>album?album=<?php echo $album_name ?>"><?php echo $album_name ?></a>
                            </span>
                            <span class="index"><strong id="current-index"></strong> of <?php echo $index ?></span>
                            <span class="dropdown pull-right modal-options-dropdown">
                                <a href="#" data-toggle="dropdown">Options</a>
                                <ul class="dropdown-menu">
<!--                                    <li><a href="#" class="delete"><i class="icon-remove"></i> Delete this photo</a></li>
                                    <li><a href="<?php echo base_url() ?>album/download/<?php echo $album_name ?>/<?php echo $filename ?>.<?php echo $extension ?>" class="download"><i class="icon-download-alt"></i> Download</a></li>
                                    <li class="divider"></li>-->
                                    <li><a href="#" class="fullscreen"><i class="icon-fullscreen"></i> Full Screen</a></li>
                                </ul>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        toastr.options.positionClass = 'toast-bottom-left';
        <?php if($error === 1){ ?>
            Dialog('Successfully uploaded new photos.', 'alert', true, false, function(){});
        <?php }elseif($error === 0){ ?>
            Dialog('There was an error uploading photos.', 'alert', true, false, function(){});
        <?php } ?>
    });
</script>