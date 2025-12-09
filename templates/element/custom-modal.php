<?php
/**
 * @var \App\View\AppView $this
 */
?>

<div class="custom-modal">
    <div class="custom-modal__message js-modal-message">

    </div>
</div>

<style>
    .custom-modal {
        visibility: hidden;
        opacity: 0;
        transition: opacity 0.5s, visibility 0.5s; /* visibility for fade out */

        position: fixed;
        bottom: 0;
        right: 0;
        background-color: #d33c43;
        color: white;
        width: fit-content;
        height: fit-content;
        font-size: 20px;
        margin-bottom: 20px;
        margin-right: 20px;
        padding: 10px 20px;
        border-radius: 5px;
        z-index: 10000;
        border: 4px double wheat;
    }

    .custom-modal.active {
        visibility: visible;
        opacity: 1;
    }
</style>

<script>
    let modalTimeout = null;
    function callModal(msg, wait = 3000) {
        const modal              = document.querySelector('.custom-modal');
        const modalMessage       = modal.querySelector('.js-modal-message');
        modalMessage.textContent = msg;
        modal.classList.add('active');

        // Clear, in case of multiple presses.
        clearTimeout(modalTimeout);

        modalTimeout = setTimeout(() => {
            modal.classList.remove('active');
        }, wait);
    }
</script>
