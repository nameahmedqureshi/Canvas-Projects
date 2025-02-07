<footer class="footer_wrapper section"></footer>

<script src="assets/front/js/jquery-3.6.3.min.js"></script>
<script src="assets/front/js/custom.js"></script>
<script>
    const categoryTitles = document.querySelectorAll('.category_box_heading');

    categoryTitles.forEach(function (categoryTitle) {
        const separators = categoryTitle.parentElement.querySelectorAll('.box_seprator');
        separators.forEach(function (sep) {
            sep.style.display = 'block';
        });

        categoryTitle.addEventListener('click', function () {
            categoryTitle.classList.toggle('open');

            separators.forEach(function (sep) {
                if (sep.style.display === 'none') {
                    sep.style.display = 'block';
                } else {
                    sep.style.display = 'none';
                }
            });
        });
    });
</script>


<script>
    const sliderTrack = document.querySelector('.slider-track');
    const sliderThumb = document.getElementById('sliderThumb');
    const sliderValue = document.getElementById('sliderValue');

    const defaultValue = 50;
    let isDragging = false;

    function updateSlider(value) {
        const trackWidth = sliderTrack.offsetWidth;
        const thumbWidth = sliderThumb.offsetWidth;

        const offsetX = (value / 100) * (trackWidth - thumbWidth);
        sliderThumb.style.left = `${offsetX}px`;
        sliderValue.textContent = value;
    }


    updateSlider(defaultValue);

    sliderThumb.addEventListener('mousedown', (e) => {
        isDragging = true;
    });

    document.addEventListener('mouseup', () => {
        isDragging = false;
    });

    document.addEventListener('mousemove', (e) => {
        if (!isDragging) return;

        const rect = sliderTrack.getBoundingClientRect();
        let offsetX = e.clientX - rect.left;
        const thumbWidth = sliderThumb.offsetWidth;
        const trackWidth = rect.width;

        // Clamp the offset to the track width
        offsetX = Math.max(0, Math.min(offsetX, trackWidth - thumbWidth));

        const value = Math.round((offsetX / (trackWidth - thumbWidth)) * 100);
        sliderThumb.style.left = `${offsetX}px`;
        sliderValue.textContent = value;
    });

    sliderTrack.addEventListener('click', (e) => {
        const rect = sliderTrack.getBoundingClientRect();
        let offsetX = e.clientX - rect.left;
        const thumbWidth = sliderThumb.offsetWidth;
        const trackWidth = rect.width;

        offsetX = Math.max(0, Math.min(offsetX, trackWidth - thumbWidth));
        const value = Math.round((offsetX / (trackWidth - thumbWidth)) * 100);
        sliderThumb.style.left = `${offsetX}px`;
        sliderValue.textContent = value;
    });
</script>


<script>
    const plusButtons = document.querySelectorAll('.plus_click');
    const minusButtons = document.querySelectorAll('.minus_click');

    plusButtons.forEach((plusButton) => {
        plusButton.addEventListener('click', function () {
            const quantityInput = this.parentElement.querySelector('.quantity_input');
            quantityInput.value = parseInt(quantityInput.value) + 1;
        });
    });

    // Add event listeners for all minus buttons
    minusButtons.forEach((minusButton) => {
        minusButton.addEventListener('click', function () {
            const quantityInput = this.parentElement.querySelector('.quantity_input');
            if (quantityInput.value > 1) {
                quantityInput.value = parseInt(quantityInput.value) - 1;
            }
        });
    });
</script>


<script>
    const addClickButtons = document.querySelectorAll('.add_click');
    const fileInputs = document.querySelectorAll('.file_input');

    addClickButtons.forEach((addButton, index) => {
        addButton.addEventListener('click', function () {
            fileInputs[index].click();
        });
    });
</script>





</body>

</html>