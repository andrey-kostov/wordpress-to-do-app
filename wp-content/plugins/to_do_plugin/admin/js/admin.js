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
                    var tableRow = '<tr>';
                            tableRow += '<td>'+this['id']+'</td>';
                            tableRow += '<td><input type="text" class="tdp_input_category" value="'+this['title']+'" data-id="'+this['id']+'"></td>';
                            tableRow += '<td class="tpd_table_actions"><button class="tdp_update_category" data-id="'+this['id']+'">Save</button>';
                            tableRow += '<button class="tdp_delete_category" data-id="'+this['id']+'">Delete</button></td>';
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
                $.each(data['tasks'],function(){

                    var task_assigned = this['assigned'];
                    var task_category_id = this['category_id'];

                    var tableRow = '<tr id="task-'+this['id']+'">';
                            tableRow += '<td>'+this['id']+'</td>';
                            tableRow += '<td><input type="text" class="tdp_input_title" value="'+this['title']+'"></td>';
                            tableRow += '<td><textarea class="tdp_input_description">'+this['description']+'</textarea></td>';
                            
                            tableRow += '<td><select class="tdp_input_assigned">';
                                tableRow += '<option value="0" ' + (task_assigned == '0' ? 'selected' : '') + '>Nobody</option>';
                                $.each(data['users'],function(){
                                    tableRow += '<option value="'+this['data']['ID']+'" ' + (task_assigned == this['data']['ID'] ? 'selected' : '') + '>'+this['data']['user_nicename']+'</option>';
                                });
                            tableRow += '</select></td>';

                            tableRow += '<td><select class="tdp_input_category">';
                                tableRow += '<option value="0" ' + (task_category_id == '0' ? 'selected' : '') + '>No category</option>';
                                $.each(data['categories'],function(){
                                    tableRow += '<option value="'+this['id']+'" ' + (task_category_id == this['id'] ? 'selected' : '') + '>'+this['title']+'</option>';
                                });
                            tableRow += '</select></td>';
                            
                            tableRow += '<td><select class="tdp_input_priority">';
                            tableRow += '    <option value="1" ' + (this['priority'] == '1' ? 'selected' : '') + '>No priority</option>';
                            tableRow += '    <option value="2" ' + (this['priority'] == '2' ? 'selected' : '') + '>Low priority</option>';
                            tableRow += '    <option value="3" ' + (this['priority'] == '3' ? 'selected' : '') + '>Normal</option>';
                            tableRow += '    <option value="4" ' + (this['priority'] == '4' ? 'selected' : '') + '>With priority</option>';
                            tableRow += '    <option value="5" ' + (this['priority'] == '5' ? 'selected' : '') + '>Urgent</option>';
                            tableRow +='</select></td>';                        

                            tableRow += '<td><input type="datetime-local" class="tdp_input_due_date" value="'+this['due_date']+'"></td>';
                            tableRow += '<td>'+this['created_at']+'</td>';
                            tableRow += '<td>'+this['updated_at']+'</td>';

                            tableRow += '<td class="tpd_table_actions"><button class="tdp_update_task" data-id="'+this['id']+'">Save</button>';
                            tableRow += '<button class="tdp_delete_task" data-id="'+this['id']+'">Delete</button></td>';
                        tableRow += '</tr>';
                    $('.tdp-table-wrapper tbody').append(tableRow);
                });
            },
            error: function(xhr, status, error) {
                alert('<p>There was an error - '+error+'</p>');
            }
        });
    }

    //Update task
    $(document).on('click','button.tdp_update_task',function(){
        var task_id = $(this).attr('data-id');
        var task_row = $('#task-'+task_id);

        var task_title = task_row.find('.tdp_input_title').val();
        var task_description = task_row.find('.tdp_input_description').val();
        var task_assigned = task_row.find('.tdp_input_assigned option:selected').val();
        var task_category = task_row.find('.tdp_input_category option:selected').val();
        var task_priority = task_row.find('.tdp_input_priority option:selected').val();
        var task_due_date = task_row.find('.tdp_input_due_date').val();

        $.ajax({
            type: 'POST',
            url: adminAjax.ajax_url,
            data: {
                action: 'tdp_update_task',
                task_id: task_id,
                task_title: task_title,
                task_description: task_description,
                task_assigned: task_assigned,
                task_category: task_category,
                task_priority: task_priority,
                task_due_date: task_due_date},
            success: function(data) {
                if(data.success === true){
                    tdp_populate_tasks_table();
                }
            },
            error: function(xhr, status, error) {
                alert('<p>There was an error - '+error+'</p>');
            }
        });
    });

    //Delete task
    $(document).on('click','button.tdp_delete_task',function(){
        var task_id = $(this).attr('data-id');
        $.ajax({
            type: 'POST',
            url: adminAjax.ajax_url,
            data: {action: 'tdp_delete_task',task_id: task_id},
            success: function(data) {
                if(data.success === true){
                    tdp_populate_tasks_table();
                }
            },
            error: function(xhr, status, error) {
                alert('<p>There was an error - '+error+'</p>');
            }
        });
        
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
                        tdp_populate_tasks_table();
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