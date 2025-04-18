<?php include 'header.php'; ?>
<style>
    body {
        background-color: white;
    }
</style>

<div class="create-product-container mt-5">
    <h1>Create Your Product</h1>

    <form class="create-product-form" action="submit_product.php" method="POST" enctype="multipart/form-data">
        <label for="name">Product Name</label>
        <input type="text" name="name" id="name" placeholder="Enter product name" required>

        <label for="room">Room</label>
        <select name="room" id="room" required>
            <option value="" disabled selected>Select a room or enter your own</option>
            <?php foreach ($rooms as $room): ?>
                <option value="<?php echo htmlspecialchars($room['room_id'], ENT_QUOTES, 'UTF-8'); ?>">
                    <?php 
                        if ($preferred_language === 'fr') {
                            echo htmlspecialchars($room['room_name_fr'], ENT_QUOTES, 'UTF-8'); 
                        } elseif ($preferred_language === 'ar') {
                            echo htmlspecialchars($room['room_name_ar'], ENT_QUOTES, 'UTF-8'); 
                        } else {
                            echo htmlspecialchars($room['room_name_en'], ENT_QUOTES, 'UTF-8'); 
                        }
                    ?>
                </option>
            <?php endforeach; ?>
        </select>
        
        <input type="hidden" name="UserID" value="<?php echo $_SESSION['UserID']; ?>">

        <input type="text" name="custom_room" id="custom-room" placeholder="Or enter a custom room" style="display: none;">

        <label for="price">Price</label>
        <input type="number" min="0" name="price" id="price" placeholder="Enter price" required>

        <div class="row">
            <div class="col">
                <label for="height">Height (cm)</label>
                <input type="number" min="0" name="height" id="height" placeholder="Enter height" required>
            </div>
            <div class="col">
                <label for="width">Width (cm)</label>
                <input type="number" min="0" name="width" id="width" placeholder="Enter width" required>
            </div>
        </div>

        <label for="material">Material Used</label>
        <input type="text" name="material" id="material" placeholder="Enter material used" required>

        <label for="colors">Available Colors</label>
        <div id="color-fields">
            <div class="color-field">
                <input type="text" placeholder="Enter color name or code" value="Red" class="item color-name" style="width: 60%;">
                <input type="color" name="color_values[]" value="#ff0000" class="item color-picker" style="width: 20%;">
                <input type="file" name="color_images[]" accept="image/*" class="color-image" required style="width: 20%; height: 4rem;">
            </div>
        </div>

        <button type="button" id="add-color-btn">Add another color</button><br>

        <button class="mt-2" type="submit">Post Product</button>
    </form>
</div>

<script>
    function nameToHex(colorName) {
        const dummy = document.createElement('div');
        dummy.style.color = colorName;
        document.body.appendChild(dummy);
        const color = getComputedStyle(dummy).color;
        document.body.removeChild(dummy);
        
        const rgb = color.match(/\d+/g);
        if (!rgb) return null;
        return "#" + rgb.map(x => ("0" + parseInt(x).toString(16)).slice(-2)).join('');
    }

    function addColorField() {
        const colorFieldsContainer = document.getElementById('color-fields');
        const colorFieldHTML = `
            <div class="color-field">
                <input type="text" placeholder="Enter color name or code" class="color-name" style="width: 70%;">
                <input type="color" name="color_values[]" class="color-picker" style="width: 30%;">
                <input type="file" name="color_images[]" accept="image/*" class="color-image" required style="width: 20%; height: 4rem;">
            </div>
        `;
        colorFieldsContainer.insertAdjacentHTML('beforeend', colorFieldHTML);
        initializeColorFieldEvents(colorFieldsContainer.lastElementChild);
    }

    function initializeColorFieldEvents(field) {
        const colorNameInput = field.querySelector('.color-name');
        const colorPickerInput = field.querySelector('.color-picker');

        colorNameInput.addEventListener('input', function () {
            const colorValue = colorNameInput.value.trim();
            if (colorValue[0] === '#') {
                if (/^#[0-9A-F]{6}$/i.test(colorValue)) {
                    colorPickerInput.value = colorValue;
                }
            } else {
                const hexValue = nameToHex(colorValue);
                if (hexValue) {
                    colorPickerInput.value = hexValue;  
                }
            }
        });

        colorPickerInput.addEventListener('input', function () {
            colorNameInput.value = colorPickerInput.value;
        });
    }

    document.getElementById('add-color-btn').addEventListener('click', addColorField);

    initializeColorFieldEvents(document.querySelector('.color-field'));
    
    const roomSelect = document.getElementById('room');
    const customRoomInput = document.getElementById('custom-room');

    roomSelect.addEventListener('change', function() {
        if (roomSelect.value === "") {
            customRoomInput.style.display = 'block';
        } else {
            customRoomInput.style.display = 'none';
        }
    });
</script>
<?php include 'footer.php'; ?>
