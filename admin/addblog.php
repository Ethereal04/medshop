<?php
include("../db.php");
include "sidenav.php";
include "topheader.php";

if (isset($_GET['id'])) {
    $qry = mysqli_query($con, "SELECT * FROM blog where blog_id = " . $_GET['id']);
    foreach(mysqli_fetch_array($qry) as $key => $val){
        $meta[$key] = $val;
      }
    }
    

?>
<div class="content">
    <div class="container-fluid">
        <div class="col-md-14">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">Blog</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive ps">
                        <form action="saveblog.php" method="post" id="manage-blog" enctype="multipart/form-data">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Blog Title</label>
                                    <input type="hidden"  name="blog_id" class="form-control" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
                                    <input type="text" id="blog_title" required name="blog_title" class="form-control" value="<?php echo isset($meta['blog_title']) ? $meta['blog_title'] : '' ?>">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Content</label>
                                    <textarea rows="4" cols="80" id="content" required name="content" class="form-control"><?php echo isset($meta['blog_content']) ? $meta['blog_content'] : '' ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="">
                                    <img src="../blog_image/<?php echo isset($meta['blog_image']) ? $meta['blog_image'] : ''; ?>" alt="" class="img-field" width="75" height="100">
                                    <label for="">Blog Image</label>
                                    <input type="file" name="blog_image" <?php echo !isset($meta['blog_image']) ? 'required' : ''; ?> class="btn btn-fill" id="blog_image" onchange="displayImg(this, $(this))">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Link</label>
                                    <input type="text" id="link" required name="link" class="form-control" value="<?php echo isset($meta['link']) ? $meta['link'] : '' ?>">
                                </div>
                            </div>
                            <div>
                            <div class="card-footer">
                            <button type="submit" id="btn_save" name="btn_save" required class="btn btn-fill btn-primary">Submit</button>
                            </div>
                        </form>
                        <table class="table table-hover table-striped" id="ordertbl">
                        </table>

                        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                        </div>
                        <div class="ps__rail-y" style="top: 0px; right: 0px;">
                            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#manage-blog').submit(function (e) {
        e.preventDefault();
        start_load();
        $.ajax({
            url: 'saveblog.php',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            error: err => console.log(err),
            success: function (resp) {
                if (resp == 1) {
                    alert("Data successfully saved.");
                    location.replace('index.php?page=blog');
                }
            }
        });
    });

    function displayImg(input, _this) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                _this.parent().find('.img-field').attr('src', e.target.result);
                _this.siblings('label').html(input.files[0]['name']);
                _this.parent().find('input[name="blog_image"]').val('<?php echo strtotime(date('y-m-d H:i:s')) ?>' + input.files[0]['name']);
		};
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>