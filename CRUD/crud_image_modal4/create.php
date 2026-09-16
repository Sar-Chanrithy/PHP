<!-- Modal Add Course -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="index.php" method="POST" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add New Course</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Course Name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter course name" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Price ($)</label>
            <input type="number" step="any" min="0" name="price" class="form-control" placeholder="Enter course price" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Image</label>
            <input type="file" name="image" class="form-control" accept="image/*" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="btn_save" class="btn btn-primary">Save Course</button>
        </div>
      </form>
    </div>
  </div>
</div>
