<div id="calculator-modal" class="modal">
      <div class="modal-body animate">
        <div class="calculator-grid">
          <div class="output">
            <div data-previous-operand class="previous-operand"></div>
            <div data-current-operand class="current-operand"></div>
          </div>
          <button onclick="document.getElementById('calculator-modal').style.display='none'">OFF</button>
          <button data-all-clear>AC</button>
          <button data-delete>DEL</button>
          <button data-operation>÷</button>
          <button data-number>1</button>
          <button data-number>2</button>
          <button data-number>3</button>
          <button data-operation>*</button>
          <button data-number>4</button>
          <button data-number>5</button>
          <button data-number>6</button>
          <button data-operation>-</button>
          <button data-number>7</button>
          <button data-number>8</button>
          <button data-number>9</button>
          <button data-operation style="grid-row: span 2;">+</button>
          <button data-number>.</button>
          <button data-number>0</button>
          <button data-equals>=</button>
        </div>
      </div>
      <script>
        // Get the modal
        var modal = document.getElementById('calculator-modal');

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
      </script>
    </div>