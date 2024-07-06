jQuery( function ( $ ) {
    $(document).ready(function(){
        $('#tdp_add_new_task').on('submit',function(event){
            event.preventDefault();
            console.log(addNewTaskForm);
            
            var formData = {
                action: 'tdp_add_new_task',
                nonce: addNewTaskForm.nonce,
                title: $('#tdp_task_title').val(),
                description: $('#tdp_task_description').val()
            };
            
            $.ajax({
                type: 'POST',
                url: addNewTaskForm.ajax_url+'/tdp_add_new_task',
                data: formData,
                success: function(response) {
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    alert('<p>There was an error processing your request. Please try again later.</p>');
                }
            });
        })       
    });
});