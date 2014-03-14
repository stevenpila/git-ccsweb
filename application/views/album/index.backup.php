<div class="ccs-album">
    <div class="col-md-12 ccs-album-inner">
        <?php
            $album_name = str_replace("_", " ", $album_name);
            $pictures = glob('uploads/albums/'.$album_name.'/*');
            natcasesort($pictures);
            $total = count($pictures);
        ?>
        
        <!-- <form class="ccs-change-profile-picture" method="post" action="<?php echo base_url() ?>album/upload/<?php echo $album_name ?>" enctype="multipart/form-data">
            <input class="" id="ccs-gallery-upload-picture" type="file" multiple="" name="images[]" rel="<?php echo $album_name ?>" />
            <input class="" id="ccs-gallery-upload-picture" type="file" multiple="" name="wtf" rel="<?php echo $album_name ?>" />
            <button class="btn btn-default" type="submit" id="ccs-upload"><i class="icon-upload"></i> Upload</button>
        </form-->
        <!--div id="uploadPreview"></div-->
        <div id="links">
            <div class="ccs-album-name-header">
                <a class="btn btn-sm pull-left" href="<?php echo base_url() ?>gallery?action=albums"><i class="icon-arrow-left"></i></a>
                <span><?php echo $album_name; ?></span>
                <?php if($this->authentication->is_authorized_function_by_name('Album/upload')){ ?>
                    <div>
                        <button class="btn btn-sm" id="add-picture"><i class="icon-upload-alt"></i> Upload</button>
                    </div>
                <?php } ?>
            </div>

        <?php
            
            $index = 0;
            foreach($pictures as $picture) {
               $path_parts = pathinfo($picture); 
               $filename = $path_parts['filename'];
               $extension = $path_parts['extension'];
               if($extension == 'jpg' || $extension == 'gif' || $extension == 'png'){ ?>
                    <div class="gallery-options-container" data-index="<?php echo $index ?>">
                        <?php if($this->authentication->is_authorized_function_by_name('Gallery/delete_picture') || $this->authentication->is_authorized_function_by_name('Gallery/set_album_cover')){ ?>
                        <div class="dropdown pull-right gallery-options-dropdown">
                            <a href="#" data-toggle="dropdown" class="btn btn-default gallery-options"><i class="icon-cog"></i></a>
                            <ul class="dropdown-menu" style="min-width:0;" data-value="<?php echo $filename . '.' . $extension ?>" data-album="<?php echo $album_name ?>">
                                <?php if($this->authentication->is_authorized_function_by_name('Gallery/delete_picture')){ ?>
                                <li><a href="#" class="delete"><i class="icon-remove"></i> Delete</a></li>
                                <?php } if($this->authentication->is_authorized_function_by_name('Gallery/set_album_cover')){ ?>
                                <li><a href="#" class="cover"><i class="icon-leaf"></i> Set as cover</a></li>
                                <?php } ?>
                                <li><a href="<?php echo base_url() . 'album/download/' . $album_name . '/' . $filename . '.' . $extension ?>" class="download"><i class="icon-download-alt"></i> Download</a></li>
                            </ul>
                        </div>
                        <?php } ?>
                        <a href="<?php echo base_url() . 'uploads/albums/' . $album_name . '/' . $filename . '.' . $extension ?>" data-gallery title="<?php echo $filename ?>">
                            <img src="<?php echo base_url() . 'uploads/albums/' . $album_name . '/' . $filename . '.' . $extension ?>" alt="<?php echo $filename . '.' . $extension ?>"/>
                        </a>
                    </div>
            <?php   

            $index++; }}
            if(!$index){
                echo '<div class="gallery-caption" style="padding: 10px 0">No Photos Available</div>';
            }
            ?>
            
        </div>
        
        <!--<a href="#modal-upload" data-toggle="modal">Show my modal shit</a>-->
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
                            <span class="index"><strong id="current-index"></strong> of <?php echo $total ?></span>
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
        toastr.success("Successfully uploaded.");
        <?php }elseif($error === 0){ ?>
        toastr.error("Error in uploading file(s)");
        <?php } ?>
    });
</script>