jQuery( function ( $ ) {
    //Populate category list table
    function tdp_populate_categories_table(){
        $.ajax({
            type: 'POST',
            url: adminAjax.ajax_url,
            data: {action: 'tdp_get_categories'},
            success: function(data) {
                $('.tdp-table-wrapper tbody').html('');
                $.each(data,function(){
                    console.log(this);
                    var tableRow = '<tr>';
                            tableRow += '<td>'+this['id']+'</td>';
                            tableRow += '<td><input type="text" class="tdp_input_category" value="'+this['title']+'" data-id="'+this['id']+'"></td>';
                            tableRow += '<td><button class="btn btn-info tdp_update_category" data-id="'+this['id']+'">Save</button>';
                            tableRow += '<button class="btn btn-danger tdp_delete_category" data-id="'+this['id']+'">Delete</button></td>';
                        tableRow += '</tr>';
                    $('.tdp-table-wrapper tbody').append(tableRow);
                });
            },
            error: function(xhr, status, error) {
                alert('<p>There was an error - '+error+'</p>');
            }
        });
    }

    //Populate tasks list table
    function tdp_populate_tasks_table(){
        $.ajax({
            type: 'POST',
            url: adminAjax.ajax_url,
            data: {action: 'tdp_get_tasks'},
            success: function(data) {
                $('.tdp-table-wrapper tbody').html('');
                console.log(data['tasks']);
                // $.each(data,function(){
                //     console.log(this);
                //     var tableRow = '<tr>';
                //             tableRow += '<td>'+this['id']+'</td>';
                //             tableRow += '<td><input type="text" class="tdp_input_category" value="'+this['title']+'" data-id="'+this['id']+'"></td>';
                //             tableRow += '<td><button class="btn btn-info tdp_update_category" data-id="'+this['id']+'">Save</button>';
                //             tableRow += '<button class="btn btn-danger tdp_delete_category" data-id="'+this['id']+'">Delete</button></td>';
                //         tableRow += '</tr>';
                //     $('.tdp-table-wrapper tbody').append(tableRow);
                // });
            },
            error: function(xhr, status, error) {
                alert('<p>There was an error - '+error+'</p>');
            }
        });
    }

    $(document).on('click','button.tdp_update_task',function(){
        tdp_populate_tasks_table();
    });

    //Delete category
    $(document).on('click','button.tdp_delete_category',function(){
        $category_id = $(this).attr('data-id');
        $.ajax({
            type: 'POST',
            url: adminAjax.ajax_url,
            data: {action: 'tdp_delete_category',category_id: $category_id},
            success: function(data) {
                if(data.success === true){
                    tdp_populate_categories_table();
                }
            },
            error: function(xhr, status, error) {
                alert('<p>There was an error - '+error+'</p>');
            }
        });
    });

    //Update category
    $(document).on('click','button.tdp_update_category',function(){
        $category_id = $(this).attr('data-id');
        $category_title = $(this).parent().siblings().find('.tdp_input_category').val();
        $.ajax({
            type: 'POST',
            url: adminAjax.ajax_url,
            data: {action: 'tdp_update_category',category_id: $category_id,category_title: $category_title},
            success: function(data) {
                if(data.success === true){
                    tdp_populate_categories_table();
                }
            },
            error: function(xhr, status, error) {
                alert('<p>There was an error - '+error+'</p>');
            }
        });
    });

    $(document).ready(function(){
        //Submit new task
        $('#tdp_add_new_task').on('submit',function(event){
            event.preventDefault();       

            var title = $('#tdp_task_title').val();
            var description = $('#tdp_task_description').val();
            var assigned = $('#tdp_task_assigned').find('option:selected').val();
            var category = $('#tdp_task_category').find('option:selected').val();
            var priority = $('#tdp_task_priority').find('option:selected').val();
            var due_date = $('#tdp_task_due_date').val();

            $.ajax({
                type: 'POST',
                url: adminAjax.ajax_url,
                data: {action: 'tdp_add_new_task',
                        title: title,
                        description: description,
                        assigned: assigned,
                        category: category,
                        priority: priority,
                        due_date: due_date},
                success: function(data) {
                    if(data.success === true){
                        alert('New task created!');
                    }
                },
                error: function(xhr, status, error) {
                    alert('<p>There was an error - '+error+'</p>');
                }
            });
        });
        
        //Submit new category
        $('#tdp_add_new_category').on('submit',function(event){
            event.preventDefault();            
            $.ajax({
                type: 'POST',
                url: adminAjax.ajax_url,
                data: {action: 'tdp_add_new_category',
                        title: $('#tdp_category_title').val()},
                success: function(data) {
                    if(data.success === true){
                        alert('New category created!');
                        tdp_populate_categories_table();
                    }
                },
                error: function(xhr, status, error) {
                    alert('<p>There was an error - '+error+'</p>');
                }
            });
        })    

        
        
    });
});