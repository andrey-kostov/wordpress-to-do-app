<?php 
      require_once(TDP_PLUGIN_DIR.'admin/controller.categories.php');
      $categories_instance = new TDP_Categories;
      $all_categories = $categories_instance->tdp_get_categories(false);
?>
<div class="wrap">
      <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

      <div class="wrap">
            <!-- New category -->
            <h2>Create new category</h2>
            <div class="tdp-form-wrapper">
                  <form id="tdp_add_new_category">
                  <input type="hidden" name="action" value="tdp_add_new_category">
                  <label for="tdp_category_title">Title:</label>
                  <input type="text" id="tdp_category_title" name="tdp_category_title" required>
      
                  <input type="submit" value="Submit" id="tdp_category_submit">
                  </form>
            </div>
      </div>

      <div class="wrap">
            <!-- Categories list -->
            <h2>Categories list</h2>
            <div class="tdp-table-wrapper categories">
                  <table class="table">
                        <thead>
                              <th>ID</th>
                              <th>Category title</th>
                              <th>Category actions</th>
                        </thead>
                        <tbody>
                              <?php foreach($all_categories as $category) : ?>
                                    <tr>
                                          <td><?= $category->id ?></td>
                                          <td><input type="text" class="tdp_input_category" value="<?= $category->title ?>" data-id="<?= $category->id ?>"></td>
                                          <td>
                                                <button class="btn btn-info tdp_update_category" data-id="<?= $category->id ?>">Save</button>
                                                <button class="btn btn-danger tdp_delete_category" data-id="<?= $category->id ?>">Delete</button>
                                          </td>
                                    </tr>
                              <?php endforeach ?> 
                        </tbody>
                  </table>
            </div>
      </div>
</div>