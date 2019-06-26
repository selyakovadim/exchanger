
jQuery(function($){
    $('.ajax_post_form').ajaxForm({
        dataType:  'json',
        beforeSubmit: function(a,f,o) {
            f.addClass('thisactive');
            $('.thisactive input[type=submit], .thisactive input[type=button]').attr('disabled',true);
            $('.thisactive').find('.ajax_submit_ind').show();
        },
        error: function(res, res2, res3) {
            $('#the_shadow, .reserv_box').hide();
            $('.jserror_shad:first, #jserror_response').show();
            var hei = Math.ceil(($(window).height() - $('#jserror_response .jserror_box').height()) / 2);
            $('#jserror_response').css({'top':hei});
            $('.jserror_text').html(res3);
        },
        success: function(res) {

            if(res['status'] == 'error'){
                if(res['status_text']){
                    $('.thisactive .resultgo').html('<div class="resultfalse"><div class="resultclose"></div>'+res['status_text']+'</div>');
                }
            }
            if(res['status'] == 'success'){
                if(res['status_text']){
                    $('.thisactive .resultgo').html('<div class="resulttrue"><div class="resultclose"></div>'+res['status_text']+'</div>');
                }
            }
            if(res['status'] == 'success_clear'){
                if(res['status_text']){
                    $('.thisactive .resultgo').html('<div class="resulttrue"><div class="resultclose"></div>'+res['status_text']+'</div>');
                }
                $('.thisactive').clearForm();
            }

            if(res['url']){
                window.location.href = res['url'];
            }

            if(res['ncapt1']){
                $('.captcha1').attr('src',res['ncapt1']);
            }
            if(res['ncapt2']){
                $('.captcha2').attr('src',res['ncapt2']);
            }
            if(res['nsym']){
                $('.captcha_sym').html(res['nsym']);
            }

            $('.thisactive input[type=submit], .thisactive input[type=button]').attr('disabled',false);
            $('.thisactive').find('.ajax_submit_ind').hide();
            $('.thisactive').removeClass('thisactive');

        }
    });
});

/* request reserve */
jQuery(function($){
    $(document).on('click', '.js_reserv', function(){
        var title = $(this).attr('data-title');
        var id = $(this).attr('data-id');
        $('#reserv_box_title').html(title);
        $('#reserv_box_id').attr('value',id);

        $('#the_shadow, .reserv_box').show();
        $('.reserv_box .resultgo').html(' ');

        var hei = Math.ceil(($(window).height() - $('.reserv_box_ins').height()) / 2);
        $('.reserv_box').css({'top':hei});

        return false;
    });

    $(document).on('click','.reserv_box_close', function(){
        $('#the_shadow, .reserv_box').hide();
    });
});
/* end request reserve */

/* exchange action */
jQuery(function($){

    function add_cf_error(id, text){
        $('.js_cf'+id).parents('.js_wrap_error').addClass('error');
        if(text.length > 0){
            $('.js_cf'+ id +'_error').html(text);
        }
    }

    function add_cfc_error(id, text){
        $('.js_cfc'+id).parents('.js_wrap_error').addClass('error');
        if(text.length > 0){
            $('.js_cfc'+ id +'_error').html(text);
        }
    }

    $('.ajax_post_bids').ajaxForm({
        dataType:  'json',
        beforeSubmit: function(a,f,o) {
            f.addClass('thisactive');
            $('.thisactive input[type=submit], .thisactive input[type=button]').attr('disabled',true);
            $('.ajax_post_bids_res').html('<div class="resulttrue">Идет обработка. Пожалуйста подождите</div>');
        },
        error: function(res, res2, res3) {
            $('#the_shadow, .reserv_box').hide();
            $('.jserror_shad:first, #jserror_response').show();
            var hei = Math.ceil(($(window).height() - $('#jserror_response .jserror_box').height()) / 2);
            $('#jserror_response').css({'top':hei});
            $('.jserror_text').html(res3);
        },
        success: function(res) {

            if(res['summ1_error'] == 1){
                $('.js_summ1').parents('.js_wrap_error').addClass('error');
                $('.js_summ1_error').html(res['summ1_error_text']);
            }
            if(res['summ2_error'] == 1){
                $('.js_summ2').parents('.js_wrap_error').addClass('error');
                $('.js_summ2_error').html(res['summ2_error_text']);
            }
            if(res['summ1c_error'] == 1){
                $('.js_summ1c').parents('.js_wrap_error').addClass('error');
                $('.js_summ1c_error').html(res['summ1c_error_text']);
            }
            if(res['summ2c_error'] == 1){
                $('.js_summ2c').parents('.js_wrap_error').addClass('error');
                $('.js_summ2c_error').html(res['summ2c_error_text']);
            }
            if(res['account1_error'] == 1){
                $('.js_account1').parents('.js_wrap_error').addClass('error');
                $('.js_account1_error').html(res['account1_error_text']);
            }
            if(res['account2_error'] == 1){
                $('.js_account2').parents('.js_wrap_error').addClass('error');
                $('.js_account2_error').html(res['account2_error_text']);
            }

            if(res['cf']){
                var cf = res['cf'];
                var cf_er = res['cf_er'];
                for (var i = 0; i < cf.length; i++) {
                    var cfid = cf[i];
                    var cftext = cf_er[i];
                    add_cf_error(cfid, cftext);
                }
            }

            if(res['cfc']){
                var cfc = res['cfc'];
                var cfc_er = res['cfc_er'];
                for (var i = 0; i < cfc.length; i++) {
                    var cfid = cfc[i];
                    var cftext = cfc_er[i];
                    add_cfc_error(cfid, cftext);
                }
            }

            if(res['status'] == 'error'){
                $('.ajax_post_bids_res').html('<div class="resultfalse"><div class="resultclose"></div>'+res['status_text']+'</div>');
                if($('.js_wrap_error.error').length > 0){
                    var ftop = $('.js_wrap_error.error:first').offset().top - 100;
                    $('body,html').animate({scrollTop: ftop},500);
                }
            }
            if(res['status'] == 'success'){
                $('.ajax_post_bids_res').html('<div class="resulttrue"><div class="resultclose"></div>'+res['status_text']+'</div>');
            }

            if(res['url']){
                window.location.href = res['url'];
            }

            if(res['ncapt1']){
                $('.captcha1').attr('src',res['ncapt1']);
            }
            if(res['ncapt2']){
                $('.captcha2').attr('src',res['ncapt2']);
            }
            if(res['nsym']){
                $('.captcha_sym').html(res['nsym']);
            }

            $('.thisactive input[type=submit], .thisactive input[type=button]').attr('disabled',false);
            $('.thisactive').removeClass('thisactive');

        }
    });
});
/* end exchange action */

/* exchange table */
jQuery(function($){

    function go_visible_icon_start(){

        $('.js_icon_left').hide();
        $('.js_icon_left:first').show();

        $('.js_item_left').each(function(){
            var vtype = $(this).attr('data-type');
            $('.js_icon_left_' + vtype).show();
        });

        $('.js_icon_right').hide();
        $('.js_icon_right:first').show();

        $('.js_line_tab.active .js_item_right').each(function(){
            var vtype = $(this).attr('data-type');
            $('.js_icon_right_' + vtype).show();
        });

        if($('.js_icon_right.active:visible').length == 0){
            $('.js_item_right').show();
            $('.js_icon_right').removeClass('active');
            $('.js_icon_right:first').addClass('active');
        }

    }

    function go_active_left_col(){

        if($('.js_item_left:visible.active').length == 0){
            $('.js_item_left').removeClass('active');
            $('.js_item_left:visible:first').addClass('active');
        }

        var valid = $('.js_item_left.active').attr('data-id');
        $('.js_line_tab').removeClass('active');
        $('#js_tabnaps_'+valid).addClass('active');
        go_visible_icon_start();

    }

    go_active_left_col();

    $(document).on('click',".js_item_left",function () {
        if(!$(this).hasClass('active')){

            $(".js_item_left").removeClass('active');
            $(this).addClass('active');

            go_active_left_col();
        }
        return false;
    });

    $(document).on('click',".js_icon_left",function () {
        if(!$(this).hasClass('active')){

            var vtype = $(this).attr('data-type');
            $(".js_icon_left").removeClass('active');
            $(this).addClass('active');

            if(vtype == 0){
                $('.js_item_left').show();
            } else {
                $('.js_item_left').hide();
                $('.js_item_left_'+vtype).show();
            }

            go_active_left_col();

        }
        return false;
    });

    $(document).on('click',".js_icon_right",function () {
        if(!$(this).hasClass('active')){

            var vtype = $(this).attr('data-type');
            $(".js_icon_right").removeClass('active');
            $(this).addClass('active');

            if(vtype == 0){
                $('.js_item_right').show();
            } else {
                $('.js_item_right').hide();
                $('.js_item_right_'+vtype).show();
            }

        }
        return false;
    });

});
/* end exchange table */

/* payouts */
jQuery(function($){
    $(document).on('click', '.delpay_link', function(){
        var thet = $(this);
        if(!thet.hasClass('act')){

            var id = $(this).attr('name');
            thet.addClass('act');

            var dataString='id=' + id;
            $.ajax({
                type: "POST",
                url: "http://exchange.premiumexchanger.com/ajax-delete_payoutlink.html?meth=post&yid=47dd8dc51c&lang=ru",
                dataType: 'json',
                data: dataString,
                error: function(res, res2, res3){
                    $('#the_shadow, .reserv_box').hide();
                    $('.jserror_shad:first, #jserror_response').show();
                    var hei = Math.ceil(($(window).height() - $('#jserror_response .jserror_box').height()) / 2);
                    $('#jserror_response').css({'top':hei});
                    $('.jserror_text').html(res2);
                },
                success: function(res)
                {
                    if(res['status'] == 'success'){
                        window.location.href = res['url'];
                    }
                    if(res['status'] == 'error'){
                        $('.jserror_shad:first, #jserror_alert').show();
                        var hei = Math.ceil(($(window).height() - $('#jserror_alert .jserror_box').height()) / 2);
                        $('#jserror_alert').css({'top':hei});
                        if(res['status_text']){
                            $('.jserror_alert').html(res['status_text']);
                        }
                    }
                    thet.removeClass('act');
                }
            });

        }

        return false;
    });
});
/* end payouts */

/* partners */
jQuery(function($){
    $(".promo_menu li a").on('click',function () {
        if(!$(this).hasClass('act')){
            $(".pbcontainer, .promo_menu li").removeClass('act');
            $(".pbcontainer").filter(this.hash).addClass('act');
            $(this).parents('li').addClass('act');
        }
        return false;
    });

    $(".bannerboxlink a").on('click',function() {
        var text = $(this).text();
        var st = $(this).attr('show-title');
        var ht = $(this).attr('hide-title');

        if(text == st){
            $(this).html(ht);
        } else {
            $(this).html(st);
        }
        $(this).parents(".bannerboxone").find(".bannerboxtextarea").toggle();
        $(this).toggleClass('act');

        return false;
    });
});
/* end partners */
jQuery(function($){
    $(document).on('click', '.captcha_reload', function(){

        var thet = $(this);
        thet.addClass('act');

        var dataString='have=reload';
        $.ajax({
            type: "POST",
            url: "http://exchange.premiumexchanger.com/ajax-scp_reload.html?meth=post&yid=47dd8dc51c&lang=ru",
            dataType: 'json',
            data: dataString,
            error: function(res,res2,res3){
                $('#the_shadow, .reserv_box').hide();
                $('.jserror_shad:first, #jserror_response').show();
                var hei = Math.ceil(($(window).height() - $('#jserror_response .jserror_box').height()) / 2);
                $('#jserror_response').css({'top':hei});
                $('.jserror_text').html(res2);
            },
            success: function(res)
            {
                if(res['ncapt1']){
                    $('.captcha1').attr('src',res['ncapt1']);
                }
                if(res['ncapt2']){
                    $('.captcha2').attr('src',res['ncapt2']);
                }
                if(res['nsym']){
                    $('.captcha_sym').html(res['nsym']);
                }

                thet.removeClass('act');
            }
        });

        return false;
    });
});

jQuery(function($){
    $('.wclosearea_hide').click(function(){
        var thet = $(this);
        var id = $(this).parents('.wclosearea').attr('id').replace('wmess_','');
        var dataString='id=' + id;
        thet.addClass('active');
        $.ajax({
            type: "POST",
            url: "http://exchange.premiumexchanger.com/ajax-close_wmess.html?meth=post&yid=47dd8dc51c&lang=ru",
            data: dataString,
            error: function(res, res2, res3){
                $('#the_shadow, .reserv_box').hide();
                $('.jserror_shad:first, #jserror_response').show();
                var hei = Math.ceil(($(window).height() - $('#jserror_response .jserror_box').height()) / 2);
                $('#jserror_response').css({'top':hei});
                $('.jserror_text').html(res2);
            },
            success: function(res)
            {
                $('#wmess_' + id).hide();
                thet.removeClass('active');
            }
        });
        return false;
    });
});

/* tarifs */
jQuery(function($){

    $('.javahref').click(function(){
        var the_link = $(this).attr('name');
        window.location = the_link;
    });

});
/* end tarifs */

/* payouts */
jQuery(function($){
    $(document).on('click', '.pay_purse_link', function(){
        $('.pay_purse_ul').show();
        var id = $('#pay_valut_id').val();
        $('.pay_purse_line').hide();
        var cc = $('.ppl_'+id).length;
        if(cc > 0){
            $('.ppl_'+id).show();
        } else {
            $('.ppl_0').show();
        }
        return false;
    });

    $(document).on('click', '.pay_purse_line', function(){
        var account = $(this).attr('data-purse');
        $('#pay_valut_account').val(account);
        $('.pay_purse_ul').hide();
        return false;
    });

    $(document).click(function(event) {
        if ($(event.target).closest(".pay_purse_link").length) return;
        $('.pay_purse_ul').hide();
        event.stopPropagation();
    });
});
/* end payouts */
/* exchange purse */
jQuery(function($){

    $(document).on('click', function(event) {
        if ($(event.target).closest(".js_purse_link").length) return;
        $('.js_purse_ul').hide();

        event.stopPropagation();
    });

    $(document).on('click', '.js_purse_link', function(){
        $(this).parents('.js_window_wrap').find('.js_purse_ul').show();

        return false;
    });

    $(document).on('click', '.js_purse_line', function(){
        var account = $(this).attr('data-purse');
        $(this).parents('.js_window_wrap').find('input').val(account);
        $('.js_purse_ul').hide();

        return false;
    });

});
/* end exchange purse */

/* userwallets */
jQuery(function($){

    $(document).on('change', '#userbill_valut_select', function(){
        var id = $(this).val();
        $('.userbill_one_tab').hide();
        $('#userbill_one_tab_'+id).show();
    });

    $(document).on('keyup', '.shot_schet', function(){
        var maximum = parseInt($(this).attr('maxlength'));
        var vale = parseInt($(this).val().length);
        var par = $(this).parents('.userbill_one_line');
        if(maximum == vale){
            if($(this).next('.shot_schet').length > 0){
                $(this).next('.shot_schet').focus();
            }
        }
    });
});
/* end userwallets */

/* userverify */
jQuery(function($){
    $(document).on('click', '#go_usve', function(){
        $('#usveformed').submit();
    });

    $('#usveformed').ajaxForm({
        dataType:  'json',
        beforeSubmit: function(a,f,o) {
            $('#go_usve').attr('disabled',true);
        },
        error: function(res, res2, res3) {
            $('#the_shadow, .reserv_box').hide();
            $('.jserror_shad:first, #jserror_response').show();
            var hei = Math.ceil(($(window).height() - $('#jserror_response .jserror_box').height()) / 2);
            $('#jserror_response').css({'top':hei});
            $('.jserror_text').html(res2);
        },
        success: function(res) {
            if(res['status'] == 'success'){
                $('#usveformedres').html('<div class="resulttrue"><div class="resultclose"></div>'+ res['status_text'] + '</div>');
            }
            if(res['status'] == 'error'){
                $('#usveformedres').html('<div class="resultfalse"><div class="resultclose"></div>'+ res['status_text'] + '</div>');
            }

            if(res['url']){
                window.location.href = res['url'];
            }

            $('#go_usve').attr('disabled',false);
        }
    });

    $(document).on('change', '.usveupfilesome', function(){
        var thet = $(this);
        var text = thet.val();
        var par = thet.parents('form');

        var ccn = thet[0].files.length;
        if(ccn > 0){
            var fileInput = thet[0];
            var bitec = fileInput.files[0].size;

            if(bitec > 2097152){
                alert('Макс. 2 МБ !');
                thet.val('');
            } else {
                par.submit();
            }

        }
    });

    var thet = '';

    $('.usveajaxform').ajaxForm({
        dataType:  'json',
        beforeSubmit: function(a,f,o) {
            thet = f;
            $('#usveformedres').html(' ');
            thet.find('input').prop('disabled',true);
        },
        error: function(res, res2, res3) {
            $('#the_shadow, .reserv_box').hide();
            $('.jserror_shad:first, #jserror_response').show();
            var hei = Math.ceil(($(window).height() - $('#jserror_response .jserror_box').height()) / 2);
            $('#jserror_response').css({'top':hei});
            $('.jserror_text').html(res3);
        },
        success: function(res) {

            if(res['status']== 'error'){
                $('#usveformedres').html('<div class="resultfalse"><div class="resultclose"></div>'+ res['status_text'] + '</div>');
                thet.find('.usveupfilesome').attr('value','');
            }

            if(res['response']){
                thet.find('.usveupfileres').html(res['response']);
            }

            if(res['url']){
                window.location.href = res['url'];
            }

            thet.find('input').prop('disabled', false);

        }
    });
});
/* end userverify */

jQuery(function($){

    $(document).on('click', '.verify_tab_action', function(){
        var par = $(this).parents('.usersbill_table_one');
        par.find('.verify_tab_action_div').toggle();

        return false;
    });

    $(document).on('click', '.verify_tab_action_link', function(){
        var par = $(this).parents('.usersbill_table_one');
        var id = $(this).parents('.usersbill_table_one').attr('id').replace('usersbill_id_','');
        var thet = $(this);
        var wait_title = $(this).attr('data-title');

        if(!thet.hasClass('act')){

            thet.addClass('act');

            var dataString='id=' + id;
            $.ajax({
                type: "POST",
                url: "http://exchange.premiumexchanger.com/ajax-goverify_account.html?meth=post&yid=47dd8dc51c&lang=ru",
                dataType: 'json',
                data: dataString,
                error: function(res, res2, res3){
                    $('#the_shadow, .reserv_box').hide();
                    $('.jserror_shad:first, #jserror_response').show();
                    var hei = Math.ceil(($(window).height() - $('#jserror_response .jserror_box').height()) / 2);
                    $('#jserror_response').css({'top':hei});
                    $('.jserror_text').html(res2);
                },
                success: function(res)
                {
                    if(res['status'] == 'success'){
                        par.find('.verify_tab_action_div').hide();
                        par.find('.verify_status').removeClass('not').addClass('wait').html(wait_title);
                    }
                    if(res['status'] == 'error'){
                        $('.jserror_shad:first, #jserror_alert').show();
                        var hei = Math.ceil(($(window).height() - $('#jserror_alert .jserror_box').height()) / 2);
                        $('#jserror_alert').css({'top':hei});
                        if(res['status_text']){
                            $('.jserror_alert').html(res['status_text']);
                        }
                    }
                    thet.removeClass('act');

                }
            });

        }

        return false;
    });
});

jQuery(function($){

    $(document).on('click', '#napsidenty_send', function(){
        if(!$(this).prop('disabled')){

            var id = $(this).attr('data-id');
            var txt = $('#napsidenty_text').val();
            var thet = $(this);
            thet.prop('disabled', true);

            var dataString='id=' + id + '&txt=' + txt;
            $.ajax({
                type: "POST",
                url: "http://exchange.premiumexchanger.com/ajax-save_napsidenty_bids.html?meth=post&yid=47dd8dc51c&lang=ru",
                dataType: 'json',
                data: dataString,
                error: function(res, res2, res3){
                    $('#the_shadow, .reserv_box').hide();
                    $('.jserror_shad:first, #jserror_response').show();
                    var hei = Math.ceil(($(window).height() - $('#jserror_response .jserror_box').height()) / 2);
                    $('#jserror_response').css({'top':hei});
                    $('.jserror_text').html(res2);
                },
                success: function(res)
                {
                    if(res['status'] == 'success'){
                        window.location.href = '';
                    }
                    if(res['status'] == 'error'){
                        thet.prop('disabled', false);
                        $('.jserror_shad:first, #jserror_alert').show();
                        var hei = Math.ceil(($(window).height() - $('#jserror_alert .jserror_box').height()) / 2);
                        $('#jserror_alert').css({'top':hei});
                        if(res['status_text']){
                            $('.jserror_alert').html(res['status_text']);
                        }
                    }
                }
            });
        }

        return false;
    });

});

jQuery(function($){

    if($('.block_smsbutton').length > 0){

        function enable_smsbutton(){
            $('#smsbutton_reload').prop('disabled', false);
        }
        setTimeout(enable_smsbutton, 60000);

        $(document).on('click', '#smsbutton_reload', function(){
            if(!$(this).prop('disabled')){

                var id = $(this).attr('data-id');
                var thet = $(this);
                thet.prop('disabled', true);

                var dataString='id=' + id;
                $.ajax({
                    type: "POST",
                    url: "http://exchange.premiumexchanger.com/ajax-resend_sms_bids.html?meth=post&yid=47dd8dc51c&lang=ru",
                    dataType: 'json',
                    data: dataString,
                    error: function(res, res2, res3){
                        $('#the_shadow, .reserv_box').hide();
                        $('.jserror_shad:first, #jserror_response').show();
                        var hei = Math.ceil(($(window).height() - $('#jserror_response .jserror_box').height()) / 2);
                        $('#jserror_response').css({'top':hei});
                        $('.jserror_text').html(res2);
                    },
                    success: function(res)
                    {
                        if(res['status'] == 'success'){
                            setTimeout(enable_smsbutton, 60000);
                            $('.jserror_shad:first, #jserror_alert').show();
                            var hei = Math.ceil(($(window).height() - $('#jserror_alert .jserror_box').height()) / 2);
                            $('#jserror_alert').css({'top':hei});
                            if(res['status_text']){
                                $('.jserror_alert').html(res['status_text']);
                            }
                        }
                        if(res['status'] == 'error'){
                            thet.prop('disabled', false);
                            $('.jserror_shad:first, #jserror_alert').show();
                            var hei = Math.ceil(($(window).height() - $('#jserror_alert .jserror_box').height()) / 2);
                            $('#jserror_alert').css({'top':hei});
                            if(res['status_text']){
                                $('.jserror_alert').html(res['status_text']);
                            }
                        }
                    }
                });

            }

            return false;
        });

        $(document).on('click', '#smsbutton_send', function(){
            if(!$(this).prop('disabled')){

                var id = $(this).attr('data-id');
                var txt = $('#smsbutton_text').val();
                var thet = $(this);
                thet.prop('disabled', true);

                var dataString='id=' + id + '&txt=' + txt;
                $.ajax({
                    type: "POST",
                    url: "http://exchange.premiumexchanger.com/ajax-repair_sms_bids.html?meth=post&yid=47dd8dc51c&lang=ru",
                    dataType: 'json',
                    data: dataString,
                    error: function(res, res2, res3){
                        $('#the_shadow, .reserv_box').hide();
                        $('.jserror_shad:first, #jserror_response').show();
                        var hei = Math.ceil(($(window).height() - $('#jserror_response .jserror_box').height()) / 2);
                        $('#jserror_response').css({'top':hei});
                        $('.jserror_text').html(res2);
                    },
                    success: function(res)
                    {
                        if(res['status'] == 'success'){
                            window.location.href = '';
                        }
                        if(res['status'] == 'error'){
                            thet.prop('disabled', false);
                            $('.jserror_shad:first, #jserror_alert').show();
                            var hei = Math.ceil(($(window).height() - $('#jserror_alert .jserror_box').height()) / 2);
                            $('#jserror_alert').css({'top':hei});
                            if(res['status_text']){
                                $('.jserror_alert').html(res['status_text']);
                            }
                        }
                    }
                });

            }

            return false;
        });

    }

});

jQuery(function($){
    function get_exchange_step1(id){

        var id1 = $('#select_give').val();
        var id2 = $('#select_get').val();

        $('.exch_ajax_wrap_abs').show();

        var dataString='id='+id+'&id1=' + id1 + '&id2=' + id2;
        $.ajax({
            type: "POST",
            url: "http://exchange.premiumexchanger.com/ajax-exchange_step1.html?meth=post&yid=47dd8dc51c&lang=ru",
            dataType: 'json',
            data: dataString,
            error: function(res, res2, res3){
                $('#the_shadow, .reserv_box').hide();
                $('.jserror_shad:first, #jserror_response').show();
                var hei = Math.ceil(($(window).height() - $('#jserror_response .jserror_box').height()) / 2);
                $('#jserror_response').css({'top':hei});
                $('.jserror_text').html(res2);
            },
            success: function(res)
            {

                $('.exch_ajax_wrap_abs').hide();

                if(res['status'] == 'success'){
                    $('#exch_html').html(res['html']);

                    if($('#the_title_page').length > 0){
                        $('#the_title_page').html(res['titlepage']);
                    }

                    $('title').html(res['title']);

                    var thelink = res['thelink'];
                    if(thelink){
                        window.history.replaceState(null, null, thelink);
                    }

                    $(document).Jselect();
                } else {
                    $('.jserror_shad:first, #jserror_alert').show();
                    var hei = Math.ceil(($(window).height() - $('#jserror_alert .jserror_box').height()) / 2);
                    $('#jserror_alert').css({'top':hei});
                    if(res['status_text']){
                        $('.jserror_alert').html(res['status_text']);
                    }
                }

            }
        });

    }
    $(document).on('change', '#select_give', function(){
        get_exchange_step1(1);
    });

    $(document).on('change', '#select_get', function(){
        get_exchange_step1(2);
    });
});
jQuery(function($){

    $('#check_rule_step').on('change',function(){
        if($(this).prop('checked')){
            $('#check_rule_step_input').prop('disabled',false);
        } else {
            $('#check_rule_step_input').prop('disabled',true);
        }
    });

    $('#check_rule_step_input').on('click',function(){
        $(this).parents('.ajax_post_form').find('.resultgo').html('<div class="resulttrue">Идет обработка. Пожалуйста подождите</div>');
    });

    $('.iam_pay_bids').on('click',function(){
        if (!confirm("Вы уверены, что уже оплатили заявку?")) {
            return false;
        }
    });

});
jQuery(function($){
    if($('#check_payment_hash').length > 0){
        var nowdata = 0;
        var redir = 0;
        function check_payment_now(){
            nowdata = parseInt(nowdata) + 1;
            if(nowdata < 30){
                $('.block_check_payment_abs').html(nowdata);
                var wid = $('.block_check_payment').width();
                if(wid > 1){
                    var onepr = wid / 30;
                    var nwid = onepr * nowdata;
                    $('.block_check_payment_ins').animate({'width': nwid},500);
                }
            } else {
                if(redir == 0){
                    var durl = $('#check_payment_hash').attr('data-hash');
                    redir = 1;
                    if(durl.length > 0){
                        $('.exchange_status_abs').show();

                        var dataString='hashed='+durl+'&auto_check=1';
                        $.ajax({
                            type: "POST",
                            url: "http://exchange.premiumexchanger.com/ajax-refresh_status_bids.html?meth=post&yid=47dd8dc51c&lang=ru",
                            dataType: 'json',
                            data: dataString,
                            error: function(res, res2, res3){
                                $('#the_shadow, .reserv_box').hide();
                                $('.jserror_shad:first, #jserror_response').show();
                                var hei = Math.ceil(($(window).height() - $('#jserror_response .jserror_box').height()) / 2);
                                $('#jserror_response').css({'top':hei});
                                $('.jserror_text').html(res2);
                            },
                            success: function(res)
                            {
                                $('.exchange_status_abs').hide();
                                if(res['html']){
                                    $('#exchange_status_html').html(res['html']);
                                    $(document).Jselect();
                                    redir = 0;
                                    nowdata = 0;
                                }
                            }
                        });
                    }
                }
            }

        }
        setInterval(check_payment_now,1000);
    }
});		
