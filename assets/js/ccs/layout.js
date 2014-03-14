$(document).ready(function(){
    var base_url = 'http://localhost/ccsweb/';    

    set_vertical_menu_link_active();
    
    $('#accordion').on('show.bs.collapse', function (e) {
        $('.ccs-profile-services-vertical-menu').animate({
            width: '250px'
        },function(){
            $('.ccs-profile-services-vertical-menu span.ccs-vertical-menu-span').show();
//            resize_height();
        });
        $('.ccs-layout-content').animate({
            'padding-left': '250px'
        });
        $('.ccs-hide-or-show-vertical-menu').animate({
            left: '200px'
        });
        $('.ccs-hide-or-show-vertical-menu > span').removeClass('ic-uniE611').addClass('ic-arrow-left');
        $('#accordion > div > ul > li').each(function(){
            $('> a > div', this).show();
        });
    });
    $('#accordion').on('shown.bs.collapse', function () {
//        resize_height();
        $('.ccs-profile-services-vertical-menu').mCustomScrollbar('update');
        $('#ccs-users-name').show();
    });
    $('#accordion').on('hidden.bs.collapse', function () {
//        resize_height();
        $('.ccs-profile-services-vertical-menu').mCustomScrollbar('update');
    });

    $('.ccs-hide-or-show-vertical-menu').click(function(){
        vertical_left_nav_bar(this);
    });

    function vertical_left_nav_bar(el){
        var element = $(el);

        element.unbind('click');
        if($('span', el).hasClass('ic-arrow-left')){
            $('#ccs-users-name').hide();
            $('.ccs-profile-services-vertical-menu span.ccs-vertical-menu-span').hide();
            $('.ccs-profile-services-vertical-menu').animate({
                width: '52px'
            });
            $('.ccs-layout-content').animate({
                'padding-left': '52px'
            }, function(){
//                resize_height();
                $('.ccs-hide-or-show-vertical-menu').bind('click', function(){
                    vertical_left_nav_bar(this);
                });
            });
            element.animate({
                left: 0
            });
            $('span', el).removeClass('ic-arrow-left').addClass('ic-uniE611');
            $('#accordion > div#collapseOne').removeClass('in').addClass('collapse');
            $('#accordion > div > ul > li').each(function(){
                $('> a > div', el).hide();
            });
        }
        else{
            $('.ccs-profile-services-vertical-menu').animate({
                width: '250px'
            },function(){
                $('#ccs-users-name').show();
                $('.ccs-profile-services-vertical-menu span.ccs-vertical-menu-span').show();
                $('.ccs-hide-or-show-vertical-menu').bind('click', function(){
                    vertical_left_nav_bar(this);
                });
//                resize_height();
            });
            $('.ccs-layout-content').animate({
                'padding-left': '250px'
            });
            element.animate({
                left: '200px'
            });
            $('span', el).removeClass('ic-uniE611').addClass('ic-arrow-left');
            $('#accordion > div > ul > li').each(function(){
                $('> a > div', el).show();
            });
        }

        $('.ccs-profile-services-vertical-menu').mCustomScrollbar('update');
    }

    var length_sel;

    $('.datatable').each(function(i, item){
        $(this).show();
        datatable_configuration_for_bootstrap_three($(this),i);
    });

    // datatable configuration for bootstrap 3
    function datatable_configuration_for_bootstrap_three(datatable,index){
        var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
        search_input.attr('placeholder', 'Search');
        search_input.addClass('form-control input-sm');
        search_input.width('150px');
        length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
        length_sel.addClass('form-control input-sm').css({ padding: '5px 10px 5px 5px', cursor: 'pointer' });
        $('option', length_sel).css({ padding: '5px 8px' });
        var pagination = datatable.closest('.dataTables_wrapper').find('ul.pagination');
        pagination.addClass('pagination-sm');

        var par = datatable.parent();
        $('<div id="datatable-container' + index + '" style="overflow-x: auto"></div>').insertBefore(datatable);
        datatable.appendTo('#datatable-container' + index);
    }

    $('#ccs-profile-search-textbox').typeahead({
        source: function (query, process) {
            return $.ajax({
                url: base_url + 'profile/get_all_users',
                type: 'POST',
                data: {
                    search: query
                },
                dataType: 'json',
                success: function (result) {
                    var resultList = result.map(function (item) {
                        var aItem = { id: item.username, name: item.full_name, pic: item.profilepicture };
                        return JSON.stringify(aItem);
                    });

                    return process(resultList);
                }
            });
        },
        matcher: function (obj) {
            var item = JSON.parse(obj);
            var query = this.query.toLowerCase();

            return ~item.name.toLowerCase().indexOf(query)
        },
        sorter: function (items) {          
           var beginswith = [], caseSensitive = [], caseInsensitive = [], item;

            while (aItem = items.shift()) {
                var item = JSON.parse(aItem);

                if (!item.name.toLowerCase().indexOf(this.query.toLowerCase())) beginswith.push(JSON.stringify(item));
                else if (~item.name.indexOf(this.query)) caseSensitive.push(JSON.stringify(item));
                else caseInsensitive.push(JSON.stringify(item));
            }

            return beginswith.concat(caseSensitive, caseInsensitive)

        },
        highlighter: function (obj) {
            var item = JSON.parse(obj);
            var query = this.query.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, '\\$&')
            return item.name.replace(new RegExp('(' + query + ')', 'ig'), function ($1, match) {
                return '<strong>' + match + '</strong>'
            })
        },
        updater: function (obj) {
            var item = JSON.parse(obj);

            document.location = base_url + 'profile/' + item.id;
            // $('#IdControl').attr('value', item.id);
            return item.name;
        },
        items: 10
    });


    $(document).on({
        mouseenter: function(){
            $('i.ic-arrow-down', this).show();
        },
        mouseleave: function(){
            $('i.ic-arrow-down', this).hide();
            $('.ccs-services-submenu-controls',this).removeClass('show'); 
        },
    },'.ccs-profile-submenu > ul > li');                        


    $(document).on('click','i.ic-arrow-down',function(){
        var parent = $(this).parent();
        $('.ccs-services-submenu-controls',parent).toggleClass('show');
    });


    $(document).on('click','.ccs-add-new-service',function(e) {
        var text = 'Add Service Name';

        Dialog(text, 'prompt', false, '', function(e){
            var service_name = e.trim();

            if(service_name != "") {
                $.ajax({
                    type: 'POST',
                    url: base_url + 'account/add_service',
                    data: {
                        service_name: service_name
                    },
                    dataType: 'json',
                    success: function(result) {
                        if(result.status) {
                            $('<li id="' + service_name + '"><i class="ic-arrow-down"></i><ul class="ccs-services-submenu-controls"><li class="my-edit" rel="' + service_name + '"><i class="glyphicon glyphicon-globe"></i> Edit Url</li><li class="my-rename" rel="' + service_name + '"><i class="glyphicon glyphicon-pencil"></i> Rename Service</li><li class="my-delete" rel="' + service_name + '"><i class="glyphicon glyphicon-trash"></i> Delete Service</li></ul><a title="' + service_name + '" href="" target="_blank" rel="' + service_name + '"><div class="transition" rel="' + service_name + '">' + service_name + '</div></a></li>').insertBefore('#ccs-add-service-button');
                        }
                        else {
                            Dialog('Service name already exist. Please try again.', 'alert', true, false, function(){});
                        }
                    },
                    error: function(xhr,status,error) {
                        toastr.options = {
                            "closeButton": true,
                            "debug": false,
                            "positionClass": "toast-bottom-right",
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        }
                        toastr.error(error, "Oops!")
                    }
                });
            }
        });
    });            
    

    $(document).on('click','ul.ccs-services-submenu-controls li.my-delete',function(e){
        var service_name = $(this).attr('rel').trim();
        var do_delete = 'Delete "' + service_name + '"?';
        var service_name = $(this).attr('rel');
        var mythis = this;

        Dialog(do_delete,'confirm',false,false,function(){
            $.ajax({
                type: 'POST',
                url: base_url + 'account/delete_service',
                data: {
                    service_name: service_name
                },
                dataType: 'json',
                success: function(result) {
                    if(result.status) {
                        $('li[id="' + service_name + '"]').hide();
                    }
                    else {
                        Dialog('An error occured. Please try again.', 'alert', true, false, function(){});
                    }
                },
                error: function(xhr,status,error) {
                    toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "positionClass": "toast-bottom-right",
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    }
                    toastr.error(error, "Oops!")
                }
            }); 
        });
    });
    

    $(document).on('click','ul.ccs-services-submenu-controls li.my-rename',function(e){
        var service_name = $(this).attr('rel').trim();
        var text = 'Enter new name for "' + service_name + '"';
        var mythis = this;

        Dialog(text, 'prompt', false, service_name, function(e){
            var new_service_name = e.trim();
            var valid_patt = /^[a-zA-Z0-9- ]*$/;
            var is_valid = valid_patt.test(new_service_name);

            if(service_name == new_service_name) {
                return;
            }
            else if(!is_valid) {
                Dialog('Invalid service name. It must only contain alphanumeric characters, dash, and space.<br>Please try again.', 'alert', true, false, function(){});
            }
            else if(new_service_name != "") {
                $.ajax({
                    type: 'POST',
                    url: base_url + 'account/reset_service_name',
                    data: {service_name:service_name,new_service_name:new_service_name},
                    dataType: 'json',
                    success: function(result) {
                        if(result.status) {
                            $('div[rel="' + service_name + '"]').html(new_service_name).attr('rel',new_service_name);
                            $('li[rel="' + service_name + '"]').attr('rel',new_service_name);
                            $('a[rel="' + service_name + '"]').attr('title',new_service_name).attr('rel',new_service_name);
                            $('li[id="' + service_name + '"]').attr('id',new_service_name);
                            Dialog('Service name successfully changed!', 'alert', true, false, function(){});
                        }
                        else {
                            Dialog('Service name already exist. Please try again.', 'alert', true, false, function(){});                         
                        }
                    },
                    error: function(xhr,status,error) {
                        toastr.options = {
                            "closeButton": true,
                            "debug": false,
                            "positionClass": "toast-bottom-right",
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        }

                        toastr.error(error, "Oops!")
                    }
                });  
            }
            else {
                Dialog('Please provide a service name and try again.', 'alert', true, false, function(){});
            }
        });
    });


    $(document).on('click','ul.ccs-services-submenu-controls li.my-edit',function(e){
        var service_name = $(this).attr('rel').trim();
        var href = $('li[id="' + service_name + '"] a').attr('href').trim();

        if(href === "") {
            href = 'http://' + href;
        }

        var text = 'Enter URL for "' + service_name + '"';
        Dialog(text, 'prompt', false, href, function(e){
            service_url = e.trim();
            var http = service_url.substring(0,7);

            if(service_url !== "" && service_url !== "http://" && http === "http://") {
                var first_char_service_address = service_url.substring(7,8);
                var last_char_service_address = service_url.substring(service_url.length - 1,service_url.length);
                var service_address = service_url.substring(8,service_url.length);
                var first_patt = /^[a-zA-Z]+$/;
                var last_patt = /^[a-zA-Z0-9]+$/;
                var valid_patt = /^[a-zA-Z0-9-.\/_]+$/;                
                var is_first_char_valid = first_patt.test(first_char_service_address);
                var is_last_char_valid = last_patt.test(last_char_service_address);
                var is_valid = valid_patt.test(service_address);

                if(!is_first_char_valid) {
                    Dialog('Service address first character must Not contain numeric and special characters.<br>Please try again.', 'alert', true, false, function(){});
                }
                else if(!is_last_char_valid) {
                    Dialog('Service address last character must Not contain special characters.<br>Please try again.', 'alert', true, false, function(){});                    
                }
                else if(!is_valid) {
                    Dialog('URL must only contain alphanumeric characters, dash, period, slash, and underscore.<br>Please try again.', 'alert', true, false, function(){});
                }
                else {
                    $.ajax({
                        type: 'POST',
                        url: base_url + 'account/set_url',
                        data: {
                            service_name: service_name, 
                            service_url: service_url
                        },
                        dataType: 'json',
                        success: function(result) {
                            if(result.status) {
                                $('a[rel="' + service_name + '"]').attr('href',service_url);
                                Dialog('URL successfully changed!', 'alert', true, false, function(){});
                            }
                        },
                        error: function(xhr,status,error) {
                            toastr.options = {
                                "closeButton": true,
                                "debug": false,
                                "positionClass": "toast-bottom-right",
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                            toastr.error(error, "Oops!")
                        }
                    }); 
                }
            }
            else {
                Dialog('Invalid URL. Please provide \"http://\" at the beginning of your URL<br> then write the service address.', 'alert', true, false, function(){});
            }
        });
    });
});

//var resize_height = function(){
//    var pageHeight = $(document).height();
//    var heightNav = $('.ccs-navbar-header').height();
//    var contentHeight = pageHeight - heightNav;
//    var container = $('.ccs-layout-content > .ccs-content-container > .row');
//
//    if(container.height() < pageHeight){
//        $('.ccs-layout-content').css({
//            height: contentHeight + 2 + 'px'
//        });
//    }
//}

var is_href_link_match_vertical_menu_link = function(){
    var href = location.href;
    var href_split = href.split('/');
    var href_name = href_split[4];
    var flag = false;

    $('#accordion > div > ul > li > a').each(function(){
        var text = $(this).text().toLowerCase();
        var text_replace = text.replace(' ','_');

        if(text_replace == href_name){
            flag = true;
        }
    });
    
    return flag;
}

var set_vertical_menu_link_active = function(){
    var href = location.href;
    var href_split = href.split('/');
    var href_name = href_split[4];

    reset_vertical_menu_link();
    if(is_href_link_match_vertical_menu_link() === true){
        $('#accordion > div > ul > li > a').each(function(i, item){
            var text = $(this).text().toLowerCase();
            var text_replace = text.replace(' ','_');

            if(text_replace == href_name){
                $(this).addClass('active');
                $('#accordion').addClass('active');
                $('#accordion > div#collapseOne').removeClass('collapse').addClass('in');
//                resize_height();
                return false;
            }
            else{
                $(this).css({
                    'border-left': '2px solid #009999'
                });
            }
        });
    }
}

var reset_vertical_menu_link = function(){
    $('#accordion > div > ul > li > a').each(function(i, item){
        $(this).removeClass('active');
    });
}


