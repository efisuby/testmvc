<?php
$object = isset($object) ? $object : \App\Models\Todo::create();
$action = $object->getId() ? 'update' : 'create';
?>
<form id="changeForm" action="/todo/<?= $action ?>" method="post" enctype="multipart/form-data">
    <?php if ($object->getId()) { ?>
        <input type="hidden" name="id" value="<?= $object->getId() ?>">
    <?php } ?>
    <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" class="form-control" id="email"  name="email" value="<?= $object->getEmail() ?>" placeholder="Email">
    </div>
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name"  name="name" value="<?= $object->getName() ?>" placeholder="User name">
    </div>
    <div class="form-group">
        <label for="text">Text</label>
        <textarea class="form-control" rows="3" id="text" name="text" ><?= $object->getText() ?></textarea>
    </div>
    <div class="form-group">
        <label for="image">Image</label>
        <input type="file" id="image" name="image" >
    </div>
    <div class="btn-group">
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#previewModal" >Preview</button>
    </div>
</form>
<div class="modal fade" tabindex="-1" id="previewModal" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Todo preview</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr><th width="30%">Field</th><th>Value</th></tr>
                    </thead>
                    <tbody>
                        <tr><td>Name</td><td><span id="preview_name"></span></td></tr>
                        <tr><td>EMail</td><td><span id="preview_email"></span></td></tr>
                        <tr><td>Text</td><td><span id="preview_text"></span></td></tr>
                        <tr><td>Image</td><td><img id="preview_image"></span></td></tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<img src="" id=imageURL alt="">