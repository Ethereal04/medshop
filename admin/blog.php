<!-- Jericho ADD this -->
<?php
include("../db.php");
include "sidenav.php";
include "topheader.php";
?>
<!-- End Navbar -->
<div class="content">
    <div class="container-fluid">

        <div class="col-lg-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title"> Blog List</h4>

                        </div>
                        <div class="card-body">
                            <div class="col-md-4 offset-md-9"> <a class=" btn btn-primary " href="index.php?page=addblog" id="newblog">Add New</a></div>
                            <br>
                            <div class="table-responsive ps">
                                <table class="table table-striped " id="blog">
                                    <thead class="">
                                    <tr>
                                        <th>Blog title</th>
                                        <th>Content</th>
                                        <th>Image</th>
                                        <th>Published</th>
                                        <th>link</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php

                                    $result = mysqli_query($con, "SELECT * FROM blog ORDER BY blog_title ASC");

                                    while (list($blog_id, $blog_title, $blog_contents, $blog_image, $published, $link) = mysqli_fetch_array($result)) {
                                        echo "<tr>";
                                        echo "<td>{$blog_title}</td>";
                                        echo "<td>{$blog_contents}</td>";
                                        echo "<td><img src='../blog_image/{$blog_image}' alt='Blog Image' width='75' height='100'></td>";
                                        echo "<td>{$published}</td>";
                                        $displayUrl = strlen($link) > 30 ? substr($link, 0, 30) . '...' : $link;
                                        echo "<td>{$displayUrl}</td>";
                                        echo "<td>
                                        
                                                <a class='btn btn-primary btn-sm edit_blog' href='index.php?page=addblog&id=$blog_id'>Edit</a>
                                                <a class='btn btn-danger btn-sm remove_blog' href='javascript:void(0)' data-id ='$blog_id'>Delete</a>
                                            </td>";
                                            "</tr>";
                                    }
                                    ?>
                                    </tbody>
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
                    <script>
                        $(document).ready(function () {
                            $('#blog').dataTable()
                            $('#newblog').click(function () {

                                $('#blogfrm [name="id"]').val('')
                                $('#blogfrm [name="name"]').val('')
                                $('#blogmodal .modal-title').html('New blog')
                                $('#blogmodal').modal('show')

                            })
                            $('#blogfrm').submit(function (e) {
                                e.preventDefault()
                                start_load()
                                $.ajax({
                                    url: 'manageblog.php',
                                    method: "POST",
                                    data: $(this).serialize(),
                                    error: err => console.log(err),
                                    success: function (resp) {
                                        if (resp == 1) {
                                            alert("Data successfully saved");
                                            location.reload();
                                        }
                                    }
                                })
                            })

                            $('.edit_blog').click(function () {
                                var blog_id = $(this).data('id'); // Get the blog ID
                                start_load()
                                $.ajax({
                                    url: 'getblog.php?id=' + blog_id,
                                    success: function (resp) {
                                        if (resp) {
                                            resp = JSON.parse(resp)
                                            $('#blogfrm [name="id"]').val(resp.blog_id)
                                            $('#blogfrm [name="name"]').val(resp.blog_title)
                                            $('#blogmodal .modal-title').html('Edit blog')
                                            $('#blogmodal').modal('show')
                                            end_load()

                                        }
                                    }
                                })
                            })

                            $('.remove_blog').click(function () {

                                var conf = confirm('Are you sure to delete this data?');
                                if (conf == true) {
                                    $.ajax({
                                        url: 'removeblog.php?id=' + $(this).data('id'),
                                        success: function (resp) {
                                            if (resp == 1) {
                                                alert('Data succefully deleted.')
                                                location.reload()

                                            }
                                        }
                                    })
                                }


                            })
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>