<script>
    window.addEventListener('DOMContentLoaded', (event) => {
        var textareas = document.getElementsByClassName("text-content-editor");

        // Loop through the collection if there are multiple elements with the class
        for (var i = 0; i < textareas.length; i++) {
            var textarea = textareas[i];

            textarea.style.height = "auto"; /* reset the height to auto to prevent overflow */
            textarea.style.height = textarea.scrollHeight + "px"; /* set the height to the actual content height */

            textarea.addEventListener("input", function () {
                this.style.height = "auto"; /* reset the height to auto to prevent overflow */
                this.style.height = this.scrollHeight + "px"; /* set the height to the actual content height */
            });
        }
    });
</script>
