<script>
document.addEventListener("DOMContentLoaded", () => {
  let value = 0;

  function increment() {
    value++; // Increment the current value
    updateDisplay();
  }

  function decrement() {
    if (value > 0) {
      value--; // Decrement the current value
      updateDisplay();
    }
  }

  function updateValue() {
    const input = document.getElementById("number").value;
    const newValue = parseInt(input, 10); // Parse input as an integer
    if (!isNaN(newValue) && newValue >= 0) {
      value = newValue; // Update value from input
    } else {
      value = 0; // Reset to 0 if invalid input
    }
    updateDisplay();
  }

  function validateInput(event) {
    const input = event.target;
    input.value = input.value.replace(/[^0-9]/g, ""); // Allow only numbers (no decimals or negative signs)
  }

  function updateDisplay() {
    document.getElementById("number").value = value; // Update the input field with the new value
  }

  // Attach event listeners for increment and decrement buttons
  document.getElementById("increment-btn").addEventListener("click", increment);
  document.getElementById("decrement-btn").addEventListener("click", decrement);
});


</script>
<style>
    .number-picker {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .number-picker button {
        background-color: #7367F0;
        border: none;
        color: white;
        font-size: 13px;
        width: 20px;
        height: 20px;
        cursor: pointer;
        border-radius: 5px;
    }

    .number-picker input {
        text-align: center;
        width: 55px;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 5px;
        font-size: 12px;
    }

    .number-picker button:active {
        opacity: 0.8;
    }
</style>
<div class="tab-pane" id="electric_tower" aria-labelledby="electric-tower" role="tabpanel">
    <!-- Needs Drilling Operations Field -->
    <div class="card">
        <div class="card-body">

            <div class="row">
                <div class="form-group col-sm-4">
                    <label>عامود ١٠</label>
                    <div class="input-group">
                        <input type="number" name="tower10" class="touchspinC" value="{{$workOrder->electricity_tower->tower10 ?? 0 }}" />
                    </div>
                </div>
                <div class="form-group col-sm-4">
                    <label>عامود ١٣</label>
                    <div class="input-group">
                        <input type="number" name="tower13" class="touchspinC" value="{{$workOrder->electricity_tower->tower13 ?? 0 }}" />
                    </div>
                </div>
                <div class="form-group col-sm-4">
                    <label>محول</label>
                    <div class="input-group">
                        <input type="number" name="converter" class="touchspinC" value="{{$workOrder->electricity_tower->converter ?? 0 }}" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-4">
                    <label>شداد</label>
                    <div class="input-group">
                        <input type="number" name="shadad" class="touchspinC" value="{{$workOrder->electricity_tower->shadad ?? 0 }}" />
                    </div>
                </div>
                <div class="form-group col-sm-4">
                    <label>شبكة ض/ع</label>
                    <div class="number-picker">
                        <button type="button" id="decrement-btn" class="decrement" onclick="decrement()">-</button>
                        <input
                          type="text"
                          id="number"
                          name="grid_high_voltage"
                          value="{{ $workOrder->electricity_tower->grid_high_voltage ?? 0 }}"
                          oninput="validateInput(event)"
                          onchange="updateValue()"
                        />
                        <button type="button" id="increment-btn" class="increment" onclick="increment()">+</button>
                      </div>
                </div>
                <div class="form-group col-sm-4">
                    <label>شبكة ض/م</label>
                    <div class="input-group">
                        <input type="number" name="grid_low_voltage" class="touchspinC" value="{{$workOrder->electricity_tower->grid_low_voltage ?? 0 }}" />
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    $(".touchspinC").TouchSpin({
        min: 0,
        max: 200,
        step: 1,
        forcestepdivisibility: 'none'
    });
</script>
