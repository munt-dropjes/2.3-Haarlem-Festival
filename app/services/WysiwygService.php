<?php

namespace Services;

class WysiwygService
{
    function render(string $data, string $action = ""): void
    {
        // Default head
        require_once __DIR__ . '/../views/components/head.php';

        // Default header
        require_once __DIR__ . '/../views/components/header.php';
        ?>
        <script src="https://cdn.tiny.cloud/1/03uqwp4i3bdkf4morifkmptnw3ctwxa5jfij0b924b1n4upy/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
        <script type="text/javascript">
        // Ensure TinyMCE is initialized when DOM is fully loaded
        document.addEventListener('DOMContentLoaded', function () {
            tinymce.init({
                selector: 'textarea#wysiwyg',  // This will target the textarea with ID 'wysiwyg'
                inline: true,  // Inline editing mode
                menubar: false, // Optional: Disable menu bar if needed
                plugins: 'lists link', // Add more plugins as needed
                toolbar: 'undo redo | bold italic | bullist numlist | link', // Define toolbar options
            });
        });
        </script>
        <form method="post" action="<?= $action ?>">
            <label for="wysiwyg"></label>
            <textarea style="width:100%;height:100%;min-height:300px;" id="wysiwyg" name="wysiwyg"><?= htmlspecialchars($data) ?></textarea>
            <button type="submit">Submit</button>
        </form>
        <?php

        // Default footer
        require_once __DIR__ . '/../views/components/footer.php';
    }
}
