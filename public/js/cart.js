function apiCall(action, id) {
  return fetch('/bookmart/cart/index.php', {
    method: 'POST',
    credentials: 'include',
    headers: {
      'Content-Type': 'application/json',
      Accept: 'application/json',
    },
    body: JSON.stringify({
      action,
      itemId: id,
    }),
  }).then(res => {
    if (res.ok) {
      if (res.redirected) {
        window.location.href = res.url;
        console.log('redirected');
        console.log(res.url);
      } else {
        return res.json();
      }
    } else {
      throw new Error('something went wrong');
    }
  });
}

function addToCart(id) {
  apiCall('add', id).then(res => {
    if (res.success) {
      if (!res.alreadyAdded) {
        const currentNo = parseInt(document.querySelector('.cart-no-of-items').innerHTML);
        document.querySelector('.cart-no-of-items').innerHTML = currentNo + 1;
      }
      showToast('success', '✔️ added to cart');
    } else if (res.errorType == 'maxlimit') {
      showToast('warning', 'Not enough stock available !');
    } else {
      console.log(res.error);
    }
  });
}

function decreaseQuantity(id) {
  const currentQuantity = parseInt(document.querySelector(`[data-quantity-id="${id}"]`).innerHTML);
  if (currentQuantity == 1) {
    removeItem(id);

    return;
  }
  apiCall('decreaseQuantity', id)
    .then(res => {
      if (res.success) {
        const currentTotalAmt = parseFloat(document.querySelector("[data-totalamt-id='totalamt']").innerHTML.substring(1));
        const currentTotalPrice = parseFloat(document.querySelector(`[data-total-id="${id}"]`).innerHTML.substring(1));
        const currentPrice = parseFloat(document.querySelector(`[data-price-id="${id}"]`).innerHTML.substring(1));
        const currentNoOfBooks = parseInt(document.querySelector("[data-noofbooks-id='noofbooks']").innerHTML);
        document.querySelector(`[data-quantity-id="${id}"]`).innerHTML = currentQuantity - 1;
        document.querySelector("[data-totalamt-id='totalamt']").innerHTML = '₹' + (currentTotalAmt - currentPrice).toFixed(2);
        document.querySelector(`[data-total-id="${id}"]`).innerHTML = '₹' + (currentTotalPrice - currentPrice).toFixed(2);
        document.querySelector("[data-noofbooks-id='noofbooks']").innerHTML = currentNoOfBooks - 1;
        if (document.querySelector("[data-totalamt-id='totalamt']").innerHTML == '₹0.00') {
          window.location.reload();
        }
      }
    })
    .catch(err => {
      showToast('failure', '⚠️ Something went wrong, please try again later');
    });
}

function increaseQuantity(id) {
  apiCall('increaseQuantity', id)
    .then(res => {
      console.log(res);
      if (res.success) {
        const currentQuantity = parseInt(document.querySelector(`[data-quantity-id="${id}"]`).innerHTML);
        const currentTotalAmt = parseFloat(document.querySelector("[data-totalamt-id='totalamt']").innerHTML.substring(1));
        const currentTotalPrice = parseFloat(document.querySelector(`[data-total-id="${id}"]`).innerHTML.substring(1));
        const currentPrice = parseFloat(document.querySelector(`[data-price-id="${id}"]`).innerHTML.substring(1));
        const currentNoOfBooks = parseInt(document.querySelector("[data-noofbooks-id='noofbooks']").innerHTML);
        document.querySelector(`[data-quantity-id="${id}"]`).innerHTML = currentQuantity + 1;
        document.querySelector("[data-totalamt-id='totalamt']").innerHTML = '₹' + (currentTotalAmt + currentPrice).toFixed(2);
        document.querySelector(`[data-total-id="${id}"]`).innerHTML = '₹' + (currentTotalPrice + currentPrice).toFixed(2);
        document.querySelector("[data-noofbooks-id='noofbooks']").innerHTML = currentNoOfBooks + 1;
      } else if (res.errorType == 'maxlimit') {
        showToast('warning', 'Not enough stock available !');
      }
    })
    .catch(err => showToast('failure', '⚠️ Something went wrong, please try again later'));
}

function removeItem(id) {
  apiCall('delete', id)
    .then(res => {
      if (res.success) {
        const currentQuantity = parseInt(document.querySelector(`[data-quantity-id="${id}"]`).innerHTML);
        const currentTotalAmt = parseFloat(document.querySelector("[data-totalamt-id='totalamt']").innerHTML.substring(1));
        const currentPrice = parseFloat(document.querySelector(`[data-price-id="${id}"]`).innerHTML.substring(1));
        const currentNoOfBooks = parseInt(document.querySelector("[data-noofbooks-id='noofbooks']").innerHTML);
        document.querySelector("[data-totalamt-id='totalamt']").innerHTML = '₹' + (currentTotalAmt - currentPrice * currentQuantity).toFixed(2);
        document.querySelector("[data-noofbooks-id='noofbooks']").innerHTML = currentNoOfBooks - currentQuantity;
        document.querySelector(`[data-item-id="${id}"]`).remove();
        const currentNo = parseInt(document.querySelector('.cart-no-of-items').innerHTML);
        document.querySelector('.cart-no-of-items').innerHTML = currentNo - 1;
        // if (document.querySelector("[data-totalamt-id='totalamt']").innerHTML == "₹0.00") {
        //   window.location.reload();
        // }
        window.location.reload();
      }
    })
    .catch(err => showToast('failure', '⚠️ Something went wrong, please try again later'));
}

function showToast(type, msg) {
  const div = document.createElement('div');
  div.classList.add(`toast-${type}-norefresh`);
  div.innerHTML = msg;
  document.body.append(div);
}
