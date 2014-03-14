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
                            $pictures = glob($folder.'/*');
                            foreach($pictures as $picture){
                                $path_parts = pathinfo($picture);
                                $extension = $path_parts['extension'];
                                if($extension != 'txt')
                                    $total++;
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
                            echo count($folders);
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
                            <i style="background: #ff7417;padding:5px;color:#fff;display:inline-block" class="ic-search"></i>
                        </div>
                    <?php
                        $albums = glob('uploads/albums/*');
                        $index = 0;
                        $total = 0;
                        if($albums){
                        foreach($albums as $album){ 
                            $path_parts = pathinfo($album);
                            $album_name = $path_parts['filename'];
                            $pictures = glob('uploads/albums/'.$album_name.'/*');
                                foreach($pictures as $picture) {
                                   $path_parts = pathinfo($picture); 
                                   $filename = $path_parts['filename'];
                                   $extension = $path_parts['extension'];
                                   $total++;
                                    if($extension == "jpg" || $extension == "jpeg" || $extension == "gif" || $extension == "png"){
                    ?>
                                    <div class="gallery-options-container" data-index="<?php echo $index ?>">
                                        <div class="dropdown pull-right gallery-options-dropdown">
                                            <a href="#" data-toggle="dropdown" class="gallery-options"><i class="icon-cog"></i></a>
                                            <ul class="dropdown-menu" style="min-width:0;" data-value="<?php echo $filename ?>.<?php echo $extension ?>" data-album="<?php echo $album_name ?>">
                                                <?php if($this->authentication->is_authorized_function_by_name('Gallery/delete_picture')){ ?>
                                                <li><a href="#" class="delete"><i class="icon-trash"></i> Delete </a></li>
                                                <?php } ?>
                                                <li><a href="<?php echo base_url() ?>album/download/<?php echo $album_name ?>/<?php echo $filename ?>.<?php echo $extension ?>" class="download"><i class="icon-download-alt"></i> Download</a></li>
                                            </ul>
                                        </div>
                                        <a href="<?php echo base_url() ?>uploads/albums/<?php echo $album_name ?>/<?php echo $filename ?>.<?php echo $extension ?>" data-gallery title="<?php echo $filename ?>">
                                            <img src="<?php echo base_url() ?>uploads/albums/<?php echo $album_name ?>/<?php echo $filename ?>.<?php echo $extension ?>" alt="<?php echo $filename ?>'<?php echo $extension ?>"/>
                                        </a>
                                    </div>
                    <?php
                                    $index++;
                                }
                            }
                        }
                        }
                        
                        if(!$index) echo "<div class='col-md-12' style='text-align: center; padding: 10px 0'>No Photos Available.</div>";
                    ?>
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
                                        <span class="index"><strong id="current-index"></strong> of <?php echo $total ?></span>
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
                            <div id="create-album">Create an album
                                <?php if($this->authentication->is_authorized_function_by_name('Gallery/create_album')){ ?>
                                <div class="icon-plus">
                                </div>
                                <?php } ?>
                            </div>
                            <?php if($this->authentication->is_authorized_function_by_name('Gallery/create_album')){ ?>
                            <form name="album" role="form" method="POST" action="<?php echo base_url() ?>gallery/create_album/" id="create-album-form">
                                    <label for="albumname">Album Name</label>
                                    <input type="text" id="albumname" name="albumname" placeholder="Enter album name">
                                <!--                            <div class="form-group">
                                    <label for="albumupload">File input</label>
                                    <input type="file" id="albumupload" name="userfile">
                                    <p class="help-block"><small>Allowed types: jpg|jpeg|png|gif</small></p>
                                </div>-->
                                <button type="submit" class="btn btn-default btn-sm">Create</button>
                                <button type="button" class="btn btn-default btn-sm">Cancel</button>
                            </form>
                            <?php } ?>
                        </div>
                        <?php if(!count($folders)){ ?>
                        <div class="ccs-albums-container center_text col-md-12" style="padding: 10px 0">No Albums Available</div>
                        <?php }else{ ?>
                        <div class="ccs-albums-container row folders">
                            <?php 
                                $folders = glob('uploads/albums/*');
                                foreach($folders as $folder){
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
                                <div class="folder-options-container">
                                  
                                    <a href="<?php echo base_url() ?>album?album_name=<?php echo str_replace(" ", "_", $filename) ?>" data-value="<?php echo $filename ?>">
                                        <div class="ccs-album-title" style="background: url(<?php echo (!empty($data)?base_url().'uploads/albums/'.$filename.'/'.$data:base_url().'assets/img/folder_icon.png') ?>);background-size:cover"><!-- style="background:url('uploads/albums/<?php echo $album_cover ?>')" -->
                                            <div style="background:rgba(0,0,0,0.5);background-size:cover;height:inherit;text-align:right;">
                                               
                                                <a class="ccs-count-album-images" href="<?php echo base_url() ?>album?album_name=<?php echo $filename ?>"><?php echo ($image_count)?$image_count.'<div class="ccs-photo-more-than"> photos </div>':$image_count.' <div class="ccs-photo-more-than"> photo </div>' ?></a>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="folder-caption" style="display: none">
                                         <span class="ccs-album-filename"><?php echo $filename ?></span>
                                         <div class="pull-right folder-options-dropdown">
                                            <ul class="dropdown-menu" data-album="<?php echo $filename ?>" data-content-count="<?php echo $image_count ?>">
                                                <!--<li><a href="<?php echo base_url() ?>album?album=<?php echo $filename ?>" class="open"><i class="icon-folder-open"></i> Open</a></li>-->
                                                <?php if($this->authentication->is_authorized_function_by_name('Gallery/rename_album')){ ?>
                                                <li><a href="#" class="rename"><i class="icon-pencil"></i></a></li>
                                                <?php } if($this->authentication->is_authorized_function_by_name('Gallery/delete_album')){ ?>
                                                <li><a href="#" class="delete"><i class="icon-remove"></i></a></li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                            <?php } ?>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $("abbr.timeago").timeago();
        toastr.options.positionClass = 'toast-bottom-left';

        $(document).on('click','.folder-options-dropdown .dropdown-menu > li a.delete',function(e){
            var album = $(this).parents('ul').attr('data-album');
            var count = $(this).parents('ul').attr('data-content-count');
            var confirmation = 'Do you want to delete this album?',
                container = $(this).parents('.folder-options-container');
            
            Dialog(confirmation, 'confirm', false, function(){
                if(count == 0) delete_album(album,container);
                else{
                    var dialog = "This album contains " + count + " photos, Continue?";

                    Dialog(dialog, 'confirm', false, function(){
                        is_user_still_logged_in(function(){
                            delete_album(album,container);
                        });
                    });
                    // if(dialog)
                    //     delete_album(album,container);
                }
            });
            // if(confirmation){
            //     if(count == 0)
            //         delete_album(album,container);
            //     else{
            //         var dialog = "This album contains " + count + " photos, Continue?";

            //         Dialog(dialog, 'confirm', false, function(){
            //             is_user_still_logged_in(function(){
            //                 delete_album(album,container);
            //             });
            //         });
            //         // if(dialog)
            //         //     delete_album(album,container);
            //     }
            // }

            e.preventDefault();
        });

        $(document).on('click','.folder-options-dropdown .dropdown-menu > li a.rename',function(e){
            var album = $(this).parents('ul').attr('data-album');
            var new_album = prompt('Rename album to:',album);
            var regex = /^[0-9a-zA-Z\s]+$/,
                el = $(this);
            
            if(new_album){
                if(new_album==null || new_album==""){
                    toastr.error("Album name must not be empty","CCS");
                }
                else if(!new_album.match(regex)){
                    toastr.error("Album name must not contain invalid characters","CCS");
                }
                else if(new_album == album){
                    toastr.info("No changes where made","CCS");
                }
                else{
    //                toastr.success("Successful","CCS");
                    rename_album(album,new_album,el);
                }
            }

            e.preventDefault();
        });

        $('form[name="album"]').validate({
            debug: true,
            rules: {
                albumname: "required"
            },
            messages: {
                albumname: "This field is required"
            },
            validClass: 'alert alert-success',
            errorClass: 'alert alert-danger ccs-validation-error',
            onfocusout: false,
            highlight: function(element, errorClass, validClass){
                $(element).addClass(errorClass);
            },
            unhighlight: function(element, errorClass, validClass){
                $(element).removeClass(errorClass);
            },
            errorPlacement: function(error, element){
                error.insertAfter(element);
            },
            submitHandler: function(form){
                var data = $(form).serialize();
                check_if_album_exist(data,form);
//                alert(data);
            }
        });
        var base_url = 'http://localhost/ccsweb/';
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
                        toastr.error('Album already exists.');
                    }
                },
                error: function(xhr){
                    alert(xhr.responseText);
                }
            });
        }
        // var create_album = function(form){
        //     var data = form.serialize();
        //     $.ajax({
        //         type: 'POST',
        //         url: base_url+'gallery/create_album',
        //         data: data,
        //         dataType: 'json',
        //         success: function(output){
        //             if(output.status){
        //                 toastr.success('Album created successfully.','CCS');
        //                 $('#albums .ccs-albums-container').load(base_url + 'gallery #albums .ccs-albums-container .folder-options-container',function(){
        //                     $('#albums .ccs-albums-container > .folder-options-container:last-child').css({
        //                         'box-shadow': '2px 2px 2px 2px #111'
        //                     });
        //                     setTimeout(function(){
        //                         $('#albums .ccs-albums-container > .folder-options-container:last-child').css({
        //                             'box-shadow': 'none'
        //                         });
        //                     },3000);
        //                     $(this).removeClass('center_text');
        //                     $('.folder-caption').hide();
        //                     var num = parseInt($('.ccs-gallery-album > span').html()) + 1;

        //                     $('.ccs-gallery-album > span').html(num);
        //                     $('#albums input').val('');
        //                 });
        //                 // setTimeout(function(){
        //                 //     location.href = base_url + 'gallery?action=create';
        //                 // }, 1500);
        //             }
        //             else{
        //                 toastr.error('Failed to create.','CCS');
        //             }
        //         },
        //         error: function(xhr){
        //             alert(xhr.responseText);
        //         }
        //     });
        // }
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
                        var list = $('.album-container > .folders > .folder-options-container').length;

                        if(list > 1){
                            container.fadeOut(1000, function(){
                                $(this).remove();
                            });
                        }else{
                            container.fadeOut(1000, function(){
                                $(this).remove();
                                $('.album-container > .folders').append("<div class='col-md-12' style='text-align: center; padding: 10px 0'>No Albums Available.</div>").hide().fadeIn();
                            });
                        }

                        var num = parseInt($('.ccs-gallery-album > span').html()) - 1;

                        $('.ccs-gallery-album > span').html(num);
                        // setTimeout(function(){
                        //     location.href = base_url + 'gallery?action=delete';
                        // },1500);
                        toastr.success('Album deleted successfully.', album);
                        // $('#albums').load(base_url+'gallery #albums');
                    }
                    else{
                        toastr.error('Error in deleting album.', 'CCS');
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
                    albumname:album, 
                    newalbumname:new_album
                },
                dataType: 'json',
                success: function(result){
                    if(result.status){
                        el.parents('.folder-caption').children('span').html(new_album);
                        el.parents('ul').attr('data-album', new_album);
                        el.parents('.folder-caption').show();
                        // setTimeout(function(){
                        //     location.href = base_url + 'gallery?action=rename';
                        // },1500);
                        toastr.success('Album renamed successfully.','CCS');
                    }
                    else{
                        toastr.error('Error in renaming album.', 'CCS');
                    }
                },
                error: function(xhr){
                    alert(xhr.responseText);
                }
            });
        }
    
    });
</script>