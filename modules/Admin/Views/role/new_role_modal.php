      <div class="modal fade" id="modal-info" id="edit_role_modal">
          <div class="modal-dialog">
              <div class="modal-content bg-info">
                  <div class="modal-header">
                      <h4 class="modal-title" id="edit_permission_title"></h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <?php echo form_open('admin/roles', ['class' => 'news-form', 'role' => 'form']); ?>
                      <?= csrf_field() ?>
                      <div class="form-group">
                          <label class="control-label">Name</label>
                          <input type="text" id="name" class="form-control" name="name">
                      </div>
                      <?php form_close(); ?>
                  </div>
                  <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-outline-light" name="submit">Save Changes</button>
                  </div>
              </div>
              <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
