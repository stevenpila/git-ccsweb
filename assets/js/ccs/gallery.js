$(document).ready(function(){
    var base_url = 'http://localhost/ccsweb/';
    
    toastr.options.positionClass = 'toast-bottom-left';
     
    // $('#create-album-form').hide();
    $('#create-album > div, #create-album-form button[type="button"]').click(function(){
        var form = $('#create-album');

        if($('#create-album-form').css("display") == 'none'){
            $('#create-album-form').show();
            $('#create-album-form').promise().done(function(){
                $('input', this).focus();
            });
            form.hide();
        }
        else{
            $('#create-album-form').hide();
            form.show();
        }
    });

    $('#add-picture,#add-more-pictures').click(function(){
        $('.ccs-change-profile-picture input[type="file"]').click();
    });

    function readImage(file) {

        var reader = new FileReader();
        var image  = new Image();

        reader.readAsDataURL(file);  
        reader.onload = function(_file) {
            image.src    = _file.target.result;              // url.createObjectURL(file);
            image.onload = function() {
                var width = this.width,
                    height = this.height,
                    type = file.type,                           // ext only: // file.type.split('/')[1],
                    name = file.name,
                    size = ~~(file.size/1024) +'KB';

                $('#uploadPreview').append('<tr>\n\
                                                <td>\n\
                                                    <img src="'+ this.src +'" style="width:25px;height:25px" />\n\
                                                </td>\n\
                                                <td>\n\
                                                    '+name+'\
                                                </td>\n\
                                                <td>\n\
                                                '+size+'\
                                                </td>\n\
                                            </tr>');
//                $('#uploadPreview').append('<div class="col-xs-6 col-md-3"><a href="#" class="thumbnail"><img src="'+ this.src +'" style="width:100px;height:100px" /><span class="caption">'+w+'x'+h+' '+s+' '+t+' '+n+'</span></a></div>');
            };
            image.onerror = function() {
                // alert('Invalid file type: '+ file.type);
                Dialog('Removed invalid file types.', 'alert', true, function(){});
            };      
        };
    }
    $('.ccs-change-profile-picture input[type="file"]').change(function(){
        $('#modal-upload').modal('show');
            
        $('#uploadPreview').html('');
        if(this.disabled) return Dialog('File upload not supported!', 'alert', true, false, function(){}); //alert('File upload not supported!');
        var F = this.files;
        if(F && F[0]) for(var i=0; i<F.length; i++) readImage( F[i] );

        $('#modal-upload').on('shown.bs.modal', function(){
            $('#modal-upload > .modal-dialog > .modal-content > .modal-footer > form > button').focus();
        });
    });

    $('.gallery-options-dropdown .dropdown-menu > li a.delete').click(function(){
        var image = $(this).parents('ul').attr('data-value');
        var album = $(this).parents('ul').attr('data-album'),
            picture = $(this).parents('.gallery-options-container');

        Dialog('Do you want to delete this photo?', 'confirm', false, false, function(){
            delete_picture(album,image,picture);
        });
        // if(confirmation){
        //     delete_picture(album,image,picture);
        // }
    });

    $('.gallery-options-dropdown .dropdown-menu > li a.cover').click(function(){
        var image = $(this).parents('ul').attr('data-value');
        var album = $(this).parents('ul').attr('data-album');
        var confirmation = "Do you want to set this as the album cover?";

        Dialog(confirmation, 'confirm', false, false, function(){
            set_album_cover(album,image);
        });
        // if(confirmation){
        //     set_album_cover(album,image);
        // }
    });

    $(document).on('click','.modal-options-dropdown .dropdown-menu > li a.fullscreen',function(){
        $('#blueimp-gallery').toggleFullScreen();
    });

    $('.gallery-options-dropdown .dropdown-menu > li a.slides').click(function(){
        var image = $(this).parents('ul').attr('data-value');
        var album = $(this).parents('ul').attr('data-album');
        var confirmation = "Do you want to add this to the slides?";
        
        Dialog(confirmation, 'confirm', false, false, function(){
            add_to_slides(album,image);
        });
        // if(confirmation){
        //     add_to_slides(album,image);
        // }
    });

    $('form[name="slide"] button[type="submit"]').click(function(e){
        var value = $(this).val();
        var form = $('form[name="slide"]');
        var data = form.serialize();

        if(value == "add_to_slides"){
            if((/slides%5B%5D/g).test(data)){
                add_many_to_slides(data);
            }
            else Dialog('Please select photo(s) to add.', 'alert', true, false, function(){});
        }else if(value == "delete_photos"){
            if((/delete%5B%5D/g).test(data)){
                //add_many_to_slides(data);
                Dialog('Delete selected photo(s)?', 'confirm', false, false, function(){
                    delete_many_photos(data);
                });
            }
            else Dialog('Please select photo(s) to delete.', 'alert', true, false, function(){});
        }
        
        e.preventDefault();
    });

    $('form[name="slide"] button[type="reset"]').click(function(){
        $('form[name="slide"] .ccs-submit-cancel-btn').addClass('hide');

        $('.ccs-add-remove-image-to-slides-container, .ccs-delete-photos-in-album-container').addClass('hide');
        $('.ccs-delete-photos-in-album-container i').removeClass('icon-ok').addClass('icon-check-empty');
        $('.ccs-add-remove-image-to-slides-container i').each(function(){
            if(!$(this).parent('button').attr('disabled')) $(this).removeClass('icon-ok').addClass('icon-plus');
        });
        $('.ccs-add-remove-image-to-slides-container > input, .ccs-delete-photos-in-album-container > input').prop('disabled', true);

        $('form[name="slide"] button[type="submit"]').val('');
    });

    // $('#select-album').click(function(){
        
    // });
    
    $('#select-picture').click(function(){
        reset_add_slide_and_delete_photo($('.ccs-delete-photos-in-album-container'));

        $('form[name="slide"] .ccs-submit-cancel-btn').removeClass('hide');
        $('.ccs-add-remove-image-to-slides-container').removeClass('hide');
        $('.ccs-add-remove-image-to-slides-container > input').removeAttr('disabled');

        $('form[name="slide"] button[type="submit"]').val('add_to_slides');
    });
    $('.ccs-add-remove-image-to-slides').click(function(e){
        $('input', $(this).parent()).click();

        if($('input', $(this).parent()).is(':checked')){
            $(this).attr('title','Cancel adding this photo.');
            $('i', this).removeClass('icon-plus').addClass('icon-ok');
        }
        else{
            $(this).attr('title','Add this photo to slides.');
            $('i', this).removeClass('icon-ok').addClass('icon-plus');
        }

        e.preventDefault();
    });
    $('#delete-picture').click(function(){
        reset_add_slide_and_delete_photo($('.ccs-add-remove-image-to-slides-container'));

        $('form[name="slide"] .ccs-submit-cancel-btn').removeClass('hide');
        $('.ccs-delete-photos-in-album-container').removeClass('hide');
        $('.ccs-delete-photos-in-album-container > input').removeAttr('disabled');

        $('form[name="slide"] button[type="submit"]').val('delete_photos');
    });

    $('.ccs-delete-photos-in-album').click(function(e){
        $('input', $(this).parent()).click();

        if($('input', $(this).parent()).is(':checked')){
            $(this).attr('title','Cancel deleting this photo.');
            $('i', this).removeClass('icon-check-empty').addClass('icon-ok');
        }
        else{
            $(this).attr('title','Delete this photo.');
            $('i', this).removeClass('icon-ok').addClass('icon-check-empty');
        }

        e.preventDefault();
    });

    $('form[name="albums"] button[type="submit"]').click(function(e){
        var form = $('form[name="albums"]'),
            data = form.serialize();
        
        if((/delete%5B%5D/g).test(data)){
            Dialog('Delete selected album(s)?', 'confirm', false, false, function(){
                delete_albums(data);
            });
        }
        else Dialog('Please select album(s) to delete.', 'alert', true, false, function(){});

        e.preventDefault();
    });

    $('form[name="albums"] button[type="reset"]').click(function(e){
        $('form[name="albums"] .ccs-submit-cancel-btn').addClass('hide');

        $('.ccs-delete-albums-container').addClass('hide');
        $('.ccs-delete-albums-container i').removeClass('icon-ok').addClass('icon-check-empty');
        $('.ccs-delete-albums-container > input').prop('disabled', true);
    });

    $('#select-album').click(function(){
        $('form[name="albums"] .ccs-submit-cancel-btn').removeClass('hide');
        $('.ccs-delete-albums-container').removeClass('hide');
        $('.ccs-delete-albums-container > input').removeAttr('disabled');
    });

    $('.ccs-delete-albums').click(function(e){
        $('input', $(this).parent()).click();

        if($('input', $(this).parent()).is(':checked')){
            $(this).attr('title','Cancel deleting this album.');
            $('i', this).removeClass('icon-check-empty').addClass('icon-ok');
        }
        else{
            $(this).attr('title','Delete this album.');
            $('i', this).removeClass('icon-ok').addClass('icon-check-empty');
        }

        e.preventDefault();
    });
    
    function reset_add_slide_and_delete_photo(el){
        el.addClass('hide');
        el.children('input').prop('disabled', true);
    }

    var delete_picture = function(album,image,picture){
        $.ajax({
            type: 'POST',
            url: base_url + 'gallery/delete_picture',
            data: {
                albumname:album,
                imagename: image
            },
            dataType: 'json',
            success: function(result){
                if(result.status){
                    // setTimeout(function(){
                        // var list = $('#links > form > .gallery-options-container-wrapper').length;

                        // if(list > 1){
                        //     picture.fadeOut(1000,function(){
                        //         $(this).parent().remove();

                        //         Dialog('Photo deleted successfully.', 'alert', true, false, function(){});
                        //         var no = parseInt($('.ccs-view-all-photos > span').html()) - 1;

                        //         //increment view all photos
                        //         $('.ccs-view-all-photos > span').html(no);
                        //     });
                        // }else{
                        //     picture.fadeOut(1000,function(){
                        //         $(this).parent().remove();
                        //         $('#links').append("<div class='col-md-12' style='text-align: center; padding: 10px 0'>No Photos Available.</div>").hide().fadeIn();
                            
                        //         Dialog('Photo deleted successfully.', 'alert', true, false, function(){});
                        //         var no = parseInt($('.ccs-view-all-photos > span').html()) - 1;

                        //         //increment view all photos
                        //         $('.ccs-view-all-photos > span').html(no);
                        //     });
                        // }
                    // },1500);
//                    $('#links').load('http://localhost/ccsweb/album?album='+album+' #links');
//                    $('#blueimp-gallery').load('http://localhost/ccsweb/album?album='+album+' #blueimp-gallery');
                    // toastr.success('Photo deleted successfully.','CCS');
                    Dialog('Photo deleted successfully.', 'alert', true, false, function(){});

                    setTimeout(function(){
                        location.reload();s
                    }, 100);
                }
                else{
                    Dialog('There was an error in deleting the photo.', 'alert', true, false, function(){});
                    // toastr.error('Error in deleting photo.','CCS');
                }
            },
            error: function(xhr){
                alert(xhr.responseText);
            }
        });
    }

    var set_album_cover = function(album,image){
        $.ajax({
            type: 'POST',
            url: base_url + 'gallery/set_album_cover',
            data: {
                albumname: album,
                imagename: image
            },
            dataType: 'json',
            success: function(result){
                if(result.status){
                    Dialog('Successfully changed album cover.', 'alert', true, false, function(){});

                    setTimeout(function(){
                        location.reload();
                    },500);
//                    $('#links').load('http://localhost/ccsweb/album?album='+album+' #links');
//                    $('#blueimp-gallery').load('http://localhost/ccsweb/album?album='+album+' #blueimp-gallery');
                    // toastr.success('Successfully updated album cover.','CCS');
                }
                else{
                    Dialog('There was an error in changing album cover.', 'alert', true, false, function(){});
                    // toastr.error('Error in updating album cover.','CCS');
                }
            },
            error: function(xhr){
                alert(xhr.responseText);
            }
        });
    }

    var add_to_slides = function(album,image){
        $.ajax({
            type: 'POST',
            url: base_url + 'gallery/add_to_slides',
            data: {
                albumname: album,
                imagename: image
            },
            dataType: 'json',
            success: function(result){
                if(result.status){
                    setTimeout(function(){
                        location.reload();
                    },1500);
                    Dialog('Photo successfully added to slides.', 'alert', true, false, function(){});
                    // toastr.success('Successfully added to slides.','CCS');
                }
                else{
                    Dialog('There was an error in adding photo to slides.', 'alert', true, false, function(){});
                    // toastr.error('Error in adding to slides.','CCS');
                }
            },
            error: function(xhr){
                alert(xhr.responseText);
            }
        });
    }
    var add_many_to_slides = function(images){
        $.ajax({
            type: 'POST',
            url: base_url + 'gallery/add_many_to_slides',
            data: images,
            dataType: 'json',
            success: function(result){
                if(result.status){
                    setTimeout(function(){
                        location.reload();
                    },100);
                    Dialog('Photos successfully added to slides.', 'alert', true, false, function(){});
                    // toastr.success('Successfully added to slides.','CCS');
                }
                else{
                    Dialog('There was an error in adding photos to slides.', 'alert', true, false, function(){});
                    // toastr.error('Error in adding to slides.','CCS');
                }
            },
            error: function(xhr){
                alert(xhr.responseText);
            }
        });
    }

    var delete_many_photos = function(data){
        $.ajax({
            type: 'POST',
            url: base_url + 'gallery/delete_many_photos',
            data: data,
            dataType: 'json',
            success: function(result){
                if(result.status){
                    setTimeout(function(){
                        location.reload();
                    },100);
                    Dialog('Photos successfully deleted.', 'alert', true, false, function(){});
                    // toastr.success('Successfully added to slides.','CCS');
                }
                else{
                    Dialog('There was an error in deleting photos.', 'alert', true, false, function(){});
                    // toastr.error('Error in adding to slides.','CCS');
                }
            },
            error: function(xhr){
                alert(xhr.responseText);
            }
        });
    }

    var delete_albums = function(albums){
        $.ajax({
            type: 'POST',
            url: base_url + 'gallery/delete_albums',
            data: albums,
            dataType: 'json',
            success: function(result){
                if(result.status){
                    setTimeout(function(){
                        location.href = base_url + 'gallery?action=delete';
                    },100);

                    Dialog('Album(s) successfully deleted.','alert', true, false, function(){});
                }
                else{
                    Dialog('There was an error in deleting album(s).','alert', true, false, function(){});
                }
            },
            error: function(xhr){
                alert(xhr.responseText);
            }
        });
    }
});