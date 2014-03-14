<?php 
    $slides = glob('uploads/albums/slides/*');
    natcasesort($slides);
?>
<div class="row ccs-forum-gallery">
    <div class="col-md-12 ccs-forum-gallery-inner">
            <ul class="nav nav-tabs">
                <li class="<?php echo ($this->session->flashdata('action') == 'ok')?'':'active' ?>">
                    <a href="#photos" class="ccs-view-all-photos" data-toggle="tab"><i class="icon-camera"></i> Photos
                    <br>
                    <span style="font-size:30px;line-height:25px;"><?php
                        $total = 0;
                        $folders = glob('uploads/albums/*');
                        foreach($folders as $folder){
                            $pos = strrpos($folder,'/') + 1;
                            $folder_name = substr($folder, $pos);

                            if($folder_name == 'slides' && !$this->authentication->is_authorized_function_by_name('Gallery/add_to_slides')) continue;

                            if($folder_name != 'slides'){
                                $pictures = glob($folder.'/*');

                                foreach($pictures as $picture){
                                    $path_parts = pathinfo($picture);
                                    $extension = $path_parts['extension'];
                                    if($extension != 'txt')
                                        $total++;
                                }
                            }
                        }
                        echo $total;
                    ?>
                    </span>
                    </a>
                </li>
                <li class="<?php echo ($this->session->flashdata('action') == 'ok')?'active':'' ?>">
                    <a href="#albums" class="ccs-gallery-album" data-toggle="tab">
                        <i class="icon-folder-open"></i>
                        Albums
                    <br>
                        <span style="font-size:30px;line-height:25px;">
                            <?php 
                            $folders = glob('uploads/albums/*');
                            $i = 0;
                            foreach($folders as $folder){
                                $pos = strrpos($folder,'/') + 1;
                                $folder_name = substr($folder, $pos);

                                if($folder_name == 'slides' && !$this->authentication->is_authorized_function_by_name('Gallery/add_to_slides')) continue;
                                $i++;
                            }

                            echo $i;
                        ?>
                    </span>
                    </a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane fade <?php echo ($this->session->flashdata('action') == 'ok')?'':'in active' ?>" id="photos">
                    <div id="links">
                        <div class="ccs-links-header">View All Photos
                            <br>
                            <i style="background: #ff7417; padding: 5px; color: #fff; display: inline-block" class="ic-search"></i>
                            <?php if($this->authentication->is_authorized_function_by_name('Gallery/add_to_slides') && $total > 0){ ?>
                            <button class="btn btn-sm" id="select-picture" style="border-radius: 0; margin-bottom: 6px; padding: 6px 5px;"><i class="icon-check"></i> Add to slides</button>
                            <?php } if($this->authentication->is_authorized_function_by_name('Gallery/delete_picture') && $total > 0){ ?>
                            <button class="btn btn-sm" id="delete-picture" style="border-radius: 0; margin-bottom: 6px; padding: 6px 10px"><i class="icon-trash"></i> Delete Photos</button>
                            <?php } ?>
                        </div>

                    <form method="POST" name="slide">
                    <?php
                        $albums = glob('uploads/albums/*');
                        $index = 0;
                        $total = 0;
                        if($albums){
                        foreach($albums as $album){
                            $pos = strrpos($album,'/') + 1;
                            $folder_name = substr($album, $pos);

                            if($folder_name == 'slides' && !$this->authentication->is_authorized_function_by_name('Gallery/add_to_slides')) continue;

                            $path_parts = pathinfo($album);
                            $album_name = $path_parts['filename'];
                            if($folder_name != 'slides'){
                                $pictures = glob('uploads/albums/'.$album_name.'/*');
                                foreach($pictures as $picture) {
                                   $path_parts = pathinfo($picture); 
                                   $filename = $path_parts['filename'];
                                   $extension = $path_parts['extension'];
                                   $total++;
                                   if($extension == "jpg" || $extension == "jpeg" || $extension == "gif" || $extension == "png"){
                    ?>
                                <div class="gallery-options-container-wrapper" style="display: inline-block">
                                    <div class="gallery-options-container" data-index="<?php echo $index ?>">
                                        <div class="dropdown pull-right gallery-options-dropdown">
                                            <a href="#" data-toggle="dropdown" class="gallery-options"><i class="icon-cog"></i></a>
                                            <ul class="dropdown-menu" style="min-width:0;" data-value="<?php echo $filename ?>.<?php echo $extension ?>" data-album="<?php echo $album_name ?>">
                                                <?php if($this->authentication->is_authorized_function_by_name('Gallery/delete_picture')){ ?>
                                                <li><a href="#" class="delete"><i class="icon-trash"></i> Delete </a></li>
                                                <?php } ?>
                                                <?php //if($this->authentication->is_authorized_function_by_name('Gallery/add_to_slides')){ ?>
                                                <!-- <li><a href="#" class="slides"><i class="icon-leaf"></i> Add to slides </a></li> -->
                                                <?php //} ?>
                                                <li><a href="<?php echo base_url() ?>album/download/<?php echo $album_name ?>/<?php echo $filename ?>.<?php echo $extension ?>" class="download"><i class="icon-download-alt"></i> Download</a></li>
                                            </ul>
                                        </div>
                                        <a href="<?php echo base_url() ?>uploads/albums/<?php echo $album_name ?>/<?php echo $filename ?>.<?php echo $extension ?>" data-gallery title="<?php echo $filename ?>">
                                            <img src="<?php echo base_url() ?>uploads/albums/<?php echo $album_name ?>/<?php echo $filename ?>.<?php echo $extension ?>" alt="<?php echo $filename ?>'<?php echo $extension ?>"/>
                                        </a>
                                    </div><br/>
                                    <?php if($this->authentication->is_authorized_function_by_name('Gallery/add_to_slides') && $total > 0){ ?>
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
                                        <input class="hide" type="checkbox" value="<?php echo $album_name.'/'.$filename.'.'.$extension ?>" name="slides[]"/>
                                    </div>
                                    <?php } if($this->authentication->is_authorized_function_by_name('Gallery/delete_picture') && $i > 0){ ?>
                                    <div class="ccs-delete-photos-in-album-container hide" style="margin: 0 0 7px 7px; text-align: center">
                                        <button title="Delete this photo." type="button" style="border-radius: 0" class="ccs-delete-photos-in-album btn btn-default btn-block">
                                            <i class="icon-check-empty"></i>
                                        </button>
                                        <input disabled class="hide" type="checkbox" value="<?php echo $album_name.'/'.$filename.'.'.$extension ?>" name="delete[]"/>
                                    </div>
                                    <?php } ?>
                                </div>
                        <?php
                                        $index++;
                                    }
                                }
                            }
                        }
                        }
                        
                        if(!$index) echo "<div class='col-md-12' style='text-align: center; padding: 10px 0'>No Photos Available.</div>";
                    ?>
                    <div class="ccs-submit-cancel-btn hide" style="border-top: 1px solid #aaa; text-align: right; margin: 0 8px; padding: 10px 0">
                        <button class="btn btn-sm" type="submit" style="margin-right: 5px"><i class="icon-ok"></i> Submit</button>
                        <button class="btn btn-sm" type="reset"><i class="icon-remove"></i> Cancel</button>
                    </div>
                    </form>
                    </div>
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
                                        <a href="#" data-dismiss="modal">&times;</a>
                                    </div>
                                    <div class="modal-body next"></div>
                                    <a href="#" class="left carousel-control prev">
                                        <i class="glyphicon glyphicon-chevron-left"></i>
                                    </a>
                                    <a href="#" class="right carousel-control next">
                                        <i class="glyphicon glyphicon-chevron-right"></i>
                                    </a>
                                    <div class="modal-options">
                                        <span class="title">All Photos</span>
                                        <span class="index"><strong id="current-index"></strong> of <?php echo $index ?></span>
                                        <span class="dropdown pull-right modal-options-dropdown">
                                            <a href="#" data-toggle="dropdown">Options</a>
                                            <ul class="dropdown-menu">
                                                <li><a href="#" class="fullscreen"><i class="icon-fullscreen"></i> Full Screen</a></li>
                                            </ul>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade <?php echo ($this->session->flashdata('action') == 'ok')?'in active':'' ?>" id="albums">
                    <div class="album-container">
                        
                        <div class="create-album-container">
                            <?php if($this->authentication->is_authorized_function_by_name('Gallery/delete_album') && $i > 1){ ?>
                            <button class="btn btn-sm pull-right" id="select-album" style="border-radius: 0px; margin: 7px 7px 7px -130px; padding: 6px 10px"><i class="icon-trash"></i> Delete Album(s)</button>
                            <?php } ?>
                            <div id="create-album">Create an album
                                <?php if($this->authentication->is_authorized_function_by_name('Gallery/create_album')){ ?>
                                <div class="icon-plus"></div>
                                <?php } ?>
                            </div>
                            <?php if($this->authentication->is_authorized_function_by_name('Gallery/create_album')){ ?>
                            <form style="display: none" name="album" role="form" method="POST" action="<?php echo base_url() ?>gallery/create_album/" id="create-album-form">
                                    <!-- <label for="albumname">Album Name</label> -->
                                    <input type="text" id="albumname" name="albumname" placeholder="Enter album name">
                                <button type="submit" class="btn btn-default btn-sm">Create</button>
                                <button type="button" class="btn btn-default btn-sm">Cancel</button>
                            </form>
                            <?php } ?>
                        </div>
                        <?php if(!count($folders)){ ?>
                        <div class="ccs-albums-container center_text col-md-12" style="padding: 10px 0">No Albums Available</div>
                        <?php }else{ ?>
                        <div class="ccs-albums-container row folders">
                            <form method="POST" name="albums">
                            <?php 
                                $folders = glob('uploads/albums/*');
                                foreach($folders as $folder){
                                    $pos = strrpos($folder,'/') + 1;
                                    $folder_name = substr($folder, $pos);

                                    if($folder_name == 'slides' && !$this->authentication->is_authorized_function_by_name('Gallery/add_to_slides')) continue;
                                    
                                    $path_parts = pathinfo($folder); 
                                    $filename = $path_parts['filename'];
                                    $images_jpg = glob($folder.'/*.jpg');
                                    $images_jpeg = glob($folder.'/*.jpeg');
                                    $images_gif = glob($folder.'/*.gif');
                                    $images_png = glob($folder.'/*.png');
                                    $data = file_get_contents($folder.'/album_cover.txt');
                                    $image_count = count($images_jpg) + count($images_jpeg) + count($images_gif) + count($images_png);
    //                                $extension = $path_parts['extension'];
                            ?>
                                <div class="folder-options-container-wrapper" style="display:inline-block">
                                    <?php if($folder_name != 'slides'){ ?>
                                    <div class="ccs-delete-albums-container hide" style="margin: 7px 0 0 7px; text-align: center">
                                        <button title="Delete this album." type="button" style="border-radius: 0" class="ccs-delete-albums btn btn-default btn-block">
                                            <i class="icon-check-empty"></i>
                                        </button>
                                        <input disabled class="hide" type="checkbox" value="<?php echo $folder_name ?>" name="delete[]"/>
                                    </div>
                                    <?php } ?>
                                    <div class="folder-options-container">
                                        <a href="<?php echo base_url() ?>gallery/<?php echo str_replace(" ", "_", $filename) ?>" data-value="<?php echo $filename ?>">
                                            <div class="ccs-album-title" style="background: url('<?php echo (!empty($data)?base_url().'uploads/albums/'.$filename.'/'.$data:base_url().'assets/img/folder_icon.png') ?>');background-size:cover"><!-- style="background:url('uploads/albums/<?php echo $album_cover ?>')" -->
                                                <div style="background:rgba(0,0,0,0.5);background-size:cover;height:inherit;text-align:right;">
                                                    <span class="ccs-count-album-images"><?php echo ($image_count)?$image_count.'<div class="ccs-photo-more-than"> photos </div>':$image_count.' <div class="ccs-photo-more-than"> photo </div>' ?></span>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="folder-caption" style="display: none">
                                             <span class="ccs-album-filename"><?php echo str_replace('_',' ',$filename) ?></span>
                                             <div class="pull-right folder-options-dropdown">
                                                <ul class="dropdown-menu" data-album="<?php echo str_replace('_',' ',$filename) ?>" data-content-count="<?php echo $image_count ?>">
                                                    <!--<li><a href="<?php echo base_url() ?>album?album=<?php echo $filename ?>" class="open"><i class="icon-folder-open"></i> Open</a></li>-->
                                                    <?php if($this->authentication->is_authorized_function_by_name('Gallery/rename_album') && $filename != 'slides'){ ?>
                                                    <li><a href="#" class="rename"><i class="icon-pencil"></i></a></li>
                                                    <?php } if($this->authentication->is_authorized_function_by_name('Gallery/delete_album') && $filename != 'slides'){ ?>
                                                    <li><a href="#" class="delete"><i class="icon-remove"></i></a></li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="ccs-submit-cancel-btn hide" style="border-top: 1px solid #aaa; text-align: right; margin: 0 8px; padding: 10px 0">
                                <button class="btn btn-sm" type="submit" style="margin-right: 5px"><i class="icon-ok"></i> Submit</button>
                                <button class="btn btn-sm" type="reset"><i class="icon-remove"></i> Cancel</button>
                            </div>
                            </form>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        var base_url = 'http://localhost/ccsweb/';
        
        $("abbr.timeago").timeago();
        toastr.options.positionClass = 'toast-bottom-left';
        $(document).on('click','.folder-options-dropdown .dropdown-menu > li a.delete',function(e){
            var album = $(this).parents('ul').attr('data-album');
            var count = $(this).parents('ul').attr('data-content-count');
            var confirmation = 'Do you want to delete this album?',
                container = $(this).parents('.folder-options-container');
            
            Dialog(confirmation, 'confirm', false, false, function(){
                if(count == 0)
                    delete_album(album,container);
                else{
                    var dialog = "This album contains " + count + " photos, Continue?";

                    Dialog(dialog, 'confirm', false, false, function(){
                        delete_album(album, container);
                    }); 
                }
            });

            e.preventDefault();
        });

        $(document).on('click','.folder-options-dropdown .dropdown-menu > li a.rename',function(e){
            var album = $(this).parents('ul').attr('data-album');
            var regex = /^[0-9a-zA-Z\s]+$/,
                el = $(this);
            
            Dialog('Rename album to: ', 'prompt', false, album, function(e){
                if(e == null || e == ""){
                    Dialog('Album name must not be empty','alert', true, false, function(){});
                }
                else if(!e.match(regex)){
                    Dialog('Album name must not contain special characters','alert', true, false, function(){});
                }
                else if(e == album){
                    Dialog('There was no changes made.','alert', true, false, function(){});
                }
                else if(e == 'slides'){
                    Dialog('Album name has been used for other purposes. Try again.','alert', true, false, function(){});
                }
                else{
                    rename_album(album,e,el);
                }
            });

            e.preventDefault();
        });

        $('form[name="album"]').validate({
            debug: true,
            rules: {
                albumname: "required"
            },
            messages: {
                albumname: ""
            },
            validClass: 'alert alert-success',
            errorClass: 'alert alert-danger ccs-validation-error',
            onfocusout: false,
            highlight: function(element, errorClass, validClass){
                //$(element).addClass(errorClass);
            },
            unhighlight: function(element, errorClass, validClass){
                //$(element).removeClass(errorClass);
            },
            errorPlacement: function(error, element){
                Dialog('Album name must not be empty','alert', true, false, function(){});
            },
            submitHandler: function(form){
                var data = $(form).serialize(),
                    name = $('input', $(form)).val(),
                    regex = /^[0-9a-zA-Z\s]+$/;

                if(!name.match(regex)){
                    Dialog('Album name must not contain special characters','alert', true, false, function(){});
                }
                else if(name == 'slides')
                    Dialog('Album name has been used for other purposes. Try again.','alert', true, false, function(){});
                else
                    check_if_album_exist(data,form);
            }
        });
        var check_if_album_exist = function(data,form){
            $.ajax({
                type: 'POST',
                url: base_url+'gallery/check_if_album_exist',
                data: data,
                dataType: 'json',
                success: function(output){
                    if(output.status == 0){
                        form.submit();
                    }
                    else{
                        Dialog('Album name already existed.','alert', true, false, function(){});
                    }
                },
                error: function(xhr){
                    alert(xhr.responseText);
                }
            });
        }
        var delete_album = function(album,container){
            $.ajax({
                type: 'POST',
                url: base_url+'gallery/delete_album',
                data: {
                    albumname:album
                },
                dataType: 'json',
                success: function(result){
                    if(result.status){
                        Dialog('Album successfully deleted.','alert', true, false, function(){});

                        setTimeout(function(){
                            document.location = base_url + 'gallery?action=delete';
                        }, 100);
                    }
                    else{
                        Dialog('There was an error in deleting album.','alert', true, false, function(){});
                    }
                },
                error: function(xhr){
                    alert(xhr.responseText);
                }
            });
        }

        var rename_album = function(album,new_album,el){
            $.ajax({
                type: 'POST',
                url: base_url+'gallery/rename_album',
                data: {
                    albumname: album, 
                    newalbumname: new_album
                },
                dataType: 'json',
                success: function(result){
                    if(result.status){
                        var link = el.parents('.folder-options-container').children('a').attr('href');
                        Dialog('Album successfully renamed','alert', true, false, function(){});

                        el.parents('.folder-caption').children('span').html(new_album);

                        el.parents('ul').attr('data-album', new_album);
                        el.parents('.folder-caption').show();
                        el.parents('.folder-options-container').children('a').attr('href', link.replace(album.replace(/\s/g,'_'), new_album.replace(/\s/g,'_')));

                        el.parents('.folder-options-container').children('.ccs-album-title').find('a').attr('href', link.replace(album.replace(/\s/g,'_'), new_album.replace(/\s/g,'_')));
                    }
                    else{
                        Dialog('There was an error in renaming album.','alert', true, false, function(){});
                    }
                },
                error: function(xhr){
                    alert(xhr.responseText);
                }
            });
        }
    });
</script>