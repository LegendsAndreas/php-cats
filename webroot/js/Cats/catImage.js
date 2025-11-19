document.addEventListener('DOMContentLoaded', function () {
    const fileInput = document.querySelector('.js-add-image');
    const base64Field = document.querySelector('#base64_image');

    fileInput.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function (e) {
            const full = e.target.result;
            base64Field.value = full.split(',')[1]; // We only want the part after the comma: data:image/png;base64,AAAA...
        };
        reader.readAsDataURL(file);
    });
});
