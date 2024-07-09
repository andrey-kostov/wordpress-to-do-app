<?php
    //Get all categories
    require_once(TDP_PLUGIN_DIR.'admin/controller.categories.php');
    require_once(TDP_PLUGIN_DIR.'admin/controller.tasks.php');

    $categories_instance = new TDP_Categories;
    $all_categories = $categories_instance->tdp_get_categories(false);

    //Get all users
    $users = get_users();

    //Get all tasks
    $tasks_instance = new TDP_Tasks;
    $all_tasks = $tasks_instance -> tdp_get_tasks(false);
?>

<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

    <div class="wrap">
        <!-- New task -->
        <h2>Create new task</h2>
        <div class="tdp-form-wrapper">
            <form id="tdp_add_new_task">
                <input type="hidden" name="action" value="tdp_add_new_task">
                <div class="task_title_wrapper wrapper">
                    <label for="tdp_task_title">Title:</label>
                    <input type="text" id="tdp_task_title" name="tdp_task_title" required>
                </div>
                <div class="task_description_wrapper wrapper">
                    <label for="tdp_task_description">Description:</label>
                    <textarea name="tdp_task_description" id="tdp_task_description" required></textarea>
                </div>
                <div class="task_assigned_wrapper wrapper">
                    <label for="tdp_task_assigned">Assigned:</label>
                    <select name="tdp_task_assigned" id="tdp_task_assigned">
                        <option value="0" selected>Nobody</option>
                        <?php foreach($users as $user) : ?>
                            <option value="<?= $user->ID ?>"><?= $user->user_nicename ?></option>           
                        <?php endforeach ?> 
                    </select>
                </div>
                <div class="task_category_wrapper wrapper">
                    <label for="tdp_task_category">Category:</label>
                    <select name="tdp_task_category" id="tdp_task_category">
                        <option value="0" selected>No category</option>
                        <?php foreach($all_categories as $category) : ?>
                        <option value="<?= $category->id ?>"><?= $category->title ?></option>
                        <?php endforeach ?> 
                    </select>
                </div>
                <div class="task_priority_wrapper wrapper">
                    <label for="tdp_task_priority">Priority:</label>
                    <select name="tdp_task_priority" id="tdp_task_priority">
                        <option value="1" selected>No priority</option>
                        <option value="2">Low priority</option>
                        <option value="3">Normal</option>
                        <option value="4">With priority</option>
                        <option value="5">Urgent</option>
                    </select>
                </div>
                <div class="task_due_wrapper wrapper">
                    <label for="tdp_task_due_date">Due date:</label>
                    <input type="datetime-local" name="tdp_task_due_date" id="tdp_task_due_date">
                </div>
    
                <input type="submit" value="Submit" class="submit-button" id="tdp_task_submit">
            </form>
        </div>
    </div>

    <div class="wrap">
        <!-- Tasks list -->
        <h2>Tasks list</h2>
        <div class="tdp-table-wrapper tasks">
        <table class="table">
            <thead>
                  <th>ID</th>
                  <th>Title</th>
                  <th>Description</th>
                  <th>Assigned</th>
                  <th>Category</th>
                  <th>Priority</th>
                  <th>Task Status</th>
                  <th>Due date</th>
                  <th>Created</th>
                  <th>Last modified</th>
            </thead>
            <tbody>
                  <?php foreach($all_tasks as $task) : ?>
                        <tr id="task-<?= $task->id ?>">
                              <td><?= $task->id ?></td>
                              <td><input type="text" class="tdp_input_title" value="<?= $task->title ?>"></td>
                              <td><textarea class="tdp_input_description"><?= $task->description ?></textarea></td>
                              <td>
                                <select class="tdp_input_assigned">
                                        <option value="0" <?php if($task->assigned === 0) : ?>selected<?php endif ?>>Nobody</option>
                                        <?php foreach($users as $user) : ?>
                                            <option value="<?= $user->ID ?>" <?php if($task->assigned == $user->ID) : ?>selected<?php endif ?>><?= $user->user_nicename ?></option>           
                                        <?php endforeach ?> 
                                </select>
                              </td>
                              <td>
                                <select class="tdp_input_category">
                                        <option value="0" <?php if($task->category_id === 0) : ?>selected<?php endif ?>>No category</option>
                                        <?php foreach($all_categories as $category) : ?>
                                            <option value="<?= $category->id ?>" <?php if($task->category_id == $category->id) : ?>selected<?php endif ?>><?= $category->title ?></option>           
                                        <?php endforeach ?> 
                                </select>
                              </td>
                              <td>
                                <select class="tdp_input_priority">
                                    <option value="1" <?php if($task->priority == 1) : ?>selected<?php endif ?>>No priority</option>
                                    <option value="2" <?php if($task->priority == 2) : ?>selected<?php endif ?>>Low priority</option>
                                    <option value="3" <?php if($task->priority == 3) : ?>selected<?php endif ?>>Normal</option>
                                    <option value="4" <?php if($task->priority == 4) : ?>selected<?php endif ?>>With priority</option>
                                    <option value="5" <?php if($task->priority == 5) : ?>selected<?php endif ?>>Urgent</option>
                                </select>
                              </td>
                              <td>
                                <select class="tdp_input_status">
                                    <option value="0" <?php if($task->task_status == 0) : ?>selected<?php endif ?>>Pending</option>
                                    <option value="1" <?php if($task->task_status == 1) : ?>selected<?php endif ?>>Worked on</option>
                                    <option value="2" <?php if($task->task_status == 2) : ?>selected<?php endif ?>>Completed</option>
                                </select>
                              </td>
                              <td><input type="datetime-local" class="tdp_input_due_date" value="<?= $task->due_date ?>"></td>
                              <td class="tdp-dates-strict"><?= $task->created_at ?></td>
                              <td class="tdp-dates-strict"><?= $task->updated_at ?></td>
                              <td class="tpd_table_actions">
                                    <button class="tdp_update_task" data-id="<?= $task->id ?>">Save</button>
                                    <button class="tdp_delete_task" data-id="<?= $task->id ?>">Delete</button>
                              </td>
                        </tr>
                  <?php endforeach ?> 
            </tbody>
        </div>
    </div>
</div>