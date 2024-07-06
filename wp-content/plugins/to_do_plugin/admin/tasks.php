<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

    <!-- New task -->
    <h2>Create new task</h2>
    <div class="wrap">
        <form id="tdp_add_new_task">
            <input type="hidden" name="action" value="tdp_add_new_task">
            <?php wp_nonce_field('tdp_add_new_task_nonce', 'tdp_add_new_task_nonce_field'); ?>
            <label for="tdp_task_title">Title:</label>
            <input type="text" id="tdp_task_title" name="tdp_task_title" required>

            <label for="tdp_task_description">Description:</label>
            <textarea name="tdp_task_description" id="tdp_task_description" required></textarea>

            <input type="submit" value="Submit" id="tdp_task_submit">
        </form>
    </div>
    <!-- Tasks list -->
    <h2>Tasks list</h2>
</div>