<?php
/**
 * @var \App\View\AppView $this
 */
$rows = 4;
$selectorSize = 3;
?>

<h1>Test</h1>

<div class="seats">
    <?php foreach (range(1, $rows) as $row) { ?>
        <div class="seats__row <?= $row ?> js-seat-row">
            <?php foreach (range(1, 10) as $seat) { ?>
                <div class="seats__row__seat seat-<?= $seat ?> js-hover-seat js-remove-active-seats">
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</div>

<?php $this->append('css') ?>
<style>
    .seats {
        border: 2px solid wheat;
    }

    .seats__row {
        display: flex;
    }

    .seats__row__seat {
        display: flex;
        padding: 20px;
        position: relative;
    }

    .seats__row__seat:after {
        content: "";
        width: 10px;
        height: 10px;
        background-color: red;
        border-radius: 50%;
        transition: height 0.2s, width 0.2s;
        position: absolute;
        transform: translate(-50%, -50%);
    }

    .seats__row__seat.hovering:after {
        height: 15px;
        width: 15px;
    }

    .seats__row__seat.active:after {
        height: 15px;
        width: 15px;
    }
</style>
<?php $this->end() ?>

<?php $this->append('script') ?>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const seatRows = document.querySelectorAll('.js-seat-row');
        const selectorSize = <?= $selectorSize ?>;
        const activeClass = 'active';
        const hoveringClass = 'hovering';

        seatRows.forEach(row => {
            const seats = row.querySelectorAll('.js-hover-seat');
            seats.forEach((seat, index) => {
                seat.addEventListener('mouseover', () => toggleHoveringClass(true, seats, index));
                seat.addEventListener('mouseout', () => toggleHoveringClass(false, seats, index));
                seat.addEventListener('click', (e) => {
                    if (seat.contains(e.target) && seat.classList.contains(activeClass)) {
                        document.querySelectorAll('.js-remove-active-seats, .active').forEach(seat => seat.classList.remove(activeClass, hoveringClass));
                        return;
                    }

                    document.querySelectorAll('.js-remove-active-seats, .active').forEach(seat => seat.classList.remove(activeClass));

                    let startingIndex = index;
                    if (index+selectorSize-1 >= seats.length) {
                        startingIndex = seats.length-selectorSize;
                    }

                    for (let i = 0; i < selectorSize; i++) {
                        seats[startingIndex+i].classList.add(activeClass);
                    }
                })
            });
        })

        const toggleHoveringClass = (isMouseOver, seats, index) => {
            let startingIndex = index;
            if (index + selectorSize - 1 >= seats.length) {
                startingIndex = seats.length - selectorSize;
            }

            for (let i = 0; i < selectorSize; i++) {
                seats[startingIndex + i].classList[isMouseOver ? 'add' : 'remove'](hoveringClass);
            }
        };

    })
</script>
<?php $this->end() ?>
