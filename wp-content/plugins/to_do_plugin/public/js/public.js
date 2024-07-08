jQuery(document).ready(function($) {
    $('.tdp-shortcode-wrapper .owl-carousel').owlCarousel({
        loop: true,
        margin: 15,
        rewind: true,
        nav: false,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });


    $(document).on('click','.tdp-task-info-btn',function(){
        var clickedButton = $(this);
        var task_id = clickedButton.attr('data-id');
        var append_to = clickedButton.parents('.owl-carousel').siblings('.tdp-shortcode-alert-wrapper').find('.shortcode-popup-info');
        var alert_wrapper = clickedButton.parents('.owl-carousel').siblings('.tdp-shortcode-alert-wrapper');

        $.ajax({
            type: 'POST',
            url: publicAjax.ajax_url,
            data: {action: 'tdp_task_info',task_id: task_id},
            success: function(data) {
                if(data.success === true){
                    var info = data.data[0];
                    console.log(info);
                    var infoPopup = '<div class="tdp-popup-title">'+info.title+'</div><div class="tdp-popup-description">'+info.description+'</div>';
                    append_to.append(infoPopup);
                    alert_wrapper.addClass('open');
                }
            },
            error: function(xhr, status, error) {
                alert('<p>There was an error - '+error+'</p>');
            }
        });
    });

    $(document).on('change','.tdp-task-actions>select',function(){
        var task_id = $(this).attr('data-id');
        var task_status = $(this).find('option:selected').val();
        $.ajax({
            type: 'POST',
            url: publicAjax.ajax_url,
            data: {action: 'tdp_task_status',task_id: task_id,task_status: task_status},
            success: function(data) {
                alert('Task changed successfully!');
            },
            error: function(xhr, status, error) {
                alert('<p>There was an error - '+error+'</p>');
            }
        });
    });

    $(document).on('click','#shortcode-alert-close',function(){
        $('.shortcode-popup-info').empty();
        $('.tdp-shortcode-alert-wrapper').removeClass('open');
    });
});