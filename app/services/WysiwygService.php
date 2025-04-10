<?php

namespace Services;

class WysiwygService
{
    function render(string $data, string $action = ""):void{
        ?>
        <script src="https://cdn.tiny.cloud/1/03uqwp4i3bdkf4morifkmptnw3ctwxa5jfij0b924b1n4upy/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                tinymce.init({
                    selector: 'textarea#wysiwyg',
                    plugins: [
                      'autolink', 'link', 'image', 'fullscreen', 'insertdatetime',
                      'media', 'help'
                    ],
                    
                    invalid_elements: 'script,object,embed,form'
                });
            });
        </script>
        <form method="post" action="<?= $action ?>">
            <label for="wysiwyg"></label>
            <textarea id="wysiwyg" name="wysiwyg"><?=$data ?></textarea>
            <button type="submit">Submit</button>
        </form>
        <?php
    }
}
