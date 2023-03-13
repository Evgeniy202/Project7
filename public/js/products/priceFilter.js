var min_price = document.getElementById("min_price");
var max_price = document.getElementById("max_price");
var min_price_label = document.getElementById("min_price_label");
var max_price_label = document.getElementById("max_price_label");

// Set the minimum value of max_price slider to the value of min_price slider
min_price.oninput = function() {
    if(parseInt(this.value) > parseInt(max_price.value)) {
        this.value = max_price.value;
    }
    min_price_label.innerHTML = this.value;
}

// Set the maximum value of min_price slider to the value of max_price slider
max_price.oninput = function() {
    if(parseInt(this.value) < parseInt(min_price.value)) {
        this.value = min_price.value;
    }
    max_price_label.innerHTML = this.value;
}
