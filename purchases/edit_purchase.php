<?php
	include "../middlewares/isAuthenticated.php";
	include "../middlewares/isAdminOrStaff.php";
	include "../classes/Purchase.php";
	include "../vendor/autoload.php";

	$masterId = isset($_GET['id']) ? $_GET['id'] : -1;

	$purchases = json_decode(file_get_contents("php://input"));
	if ($purchases) {
		$purchase = new Purchase($purchases->items, $purchases->vendorid, $purchases->date, );
		$purchase->update($masterId);
		die(json_encode(['success' => true]));
	}

	$purchaseMasterDetails = selectOne('SELECT Purchase_master_id,V_name,Vendor_id,Purchase_date,Total_amt,Status FROM tbl_Purchase_master JOIN tbl_Vendor ON Vendor_id=tbl_Vendor.V_id WHERE Purchase_master_id=?;', [$masterId]);

	$purchaseChildDetails = $pdo->prepare('SELECT Purchase_child_id,Purchase_price,Quantity,Total_price,tbl_Purchase_child.Item_id,I_title FROM tbl_Purchase_child LEFT JOIN tbl_Item ON tbl_Item.Item_id=tbl_Purchase_child.Item_id WHERE Purchase_master_id=?');

	$purchaseChildDetails->execute([$masterId]);

	$items = [];
	$vendorid = $purchaseMasterDetails['Vendor_id'];
	$date = $purchaseMasterDetails['Purchase_date'];

?>

<?php include "../layouts/admin_staff/header.php";?>
<div class="form-main">
    <form class="form add-purchase-form">
        <h1>Edit Purchase</h1>
        <div class="fields-wrapper" style="width:500px">
            <div class="dropdown-datalist">
                <div class="input-datalist">
                    <input type="text" class="form-datalist" name="vendor" required value="<?=$purchaseMasterDetails['V_name']?>" />
                    <input hidden type="text" name="vendorid" id="idfield" endpoint="vendors" hasError="false" value=<?=$purchaseMasterDetails['Vendor_id']?> />
                    <span class="floating-label-datalist">Vendor
                    </span>
                    <div id="spinner-datalist"></div>
                    <p class="error-holder"></p>
                    <div class="dropdown-datalist-content">
                    </div>
                </div>
            </div>
            <div class="input-textfield">
                <input type="date" class="form-textfield" name="Purchase_date" required value=<?=$purchaseMasterDetails['Purchase_date']?> />
                <span class="floating-label">Purchase Date</span>
                <p></p>
            </div>
        </div>
        <div class="form-group" style="width: 100%;">

            <?php while ($row = $purchaseChildDetails->fetch()):
            		$items[$row['Purchase_child_id']] = [
            			'newlyAdded' => false,
            			'itemId' => [
            				'value' => $row['Item_id'],
            				'hasError' => false,
            			],
            			'Purchase_price' => [
            				'value' => $row['Purchase_price'],
            				'hasError' => false,
            			],
            			'quantity' => [
            				'value' => $row['Quantity'],
            				'hasError' => false,
            			],
            	]?>
            <div class="fields-wrapper" data-id=<?=$row['Purchase_child_id']?> style="width:100%">
                <div class="input-textfield">
                    <input type="text" readonly class="form-textfield-readonly" name="item" value="<?=$row['I_title']?>" />
                    <span class="floating-label">Item</span>
                    <p id="purchase-price-error-div"></p>
                </div>
                <div class="input-textfield">
                    <input type="number" readonly class="form-textfield-readonly" name="Purchase_price" required value=<?=$row['Purchase_price']?> />
                    <span class="floating-label">Purchase Price</span>
                    <p id="purchase-price-error-div"></p>
                </div>
                <div class="input-textfield">
                    <input type="number" readonly class="form-textfield-readonly" name="quantity" required value=<?=$row['Quantity']?> />
                    <span class="floating-label">Quantity</span>
                    <p id="quantity-error-div"></p>
                </div>
                <div class="input-textfield">
                    <img class="add-purchase-btn" state="remove" src="/bookmart/public/images/remove.svg" onclick="removeItem(<?=$row['Purchase_child_id']?>)" />
                </div>
            </div>
            <?php endwhile?>
        </div>

        <button type="submit" name="submit">UPDATE</button>
    </form>
</div>

<script src="/bookmart/public/js/autoComplete.js"></script>


<script>
class PurchaseTable {

    constructor() {
        this.id = -1;
        this.purchase = {
            date: '<?=$date?>',
            vendorid: <?=$vendorid?>,
            items: <?=json_encode($items)?>,
            setChild: function(id, props) {
                this.items[id] = {
                    ...this.items[id],
                    ...props
                };
            }

        }



        const fields = document.querySelectorAll("input[name='vendorid']");


        fields.forEach(field => {

            const descriptor = Object.getOwnPropertyDescriptor(Object.getPrototypeOf(field), 'value');
            const self = this;

            Object.defineProperty(field, 'value', {
                set: function(value) {
                    self.purchase.vendorid = value;
                    return descriptor.set.apply(this, arguments);
                },
                get: function() {
                    return descriptor.get.apply(this);
                }
            });
        });




        document.querySelectorAll('input[type="number"]').forEach(field => {
            field.addEventListener('input', e => {
                const input = e.target.value;
                const fieldName = e.target.name;
                const errorP = fieldName === 'Purchase_price' ? document.querySelector('#purchase-price-error-div') : document.querySelector('#quantity-error-div');
                const regex = fieldName === 'Purchase_price' ? /^[0-9.]{1,11}$/ : /^[0-9]{1,5}$/;
                const errorMessage = fieldName === 'Purchase_price' ? 'Invalid purchase price' : 'Invalid quantity';
                if (!regex.test(input)) {
                    errorP.innerHTML = errorMessage;
                    this.purchase.setChild(field.parentElement.parentElement.getAttribute("data-id"), {
                        [fieldName]: {
                            hasError: true,
                            value: input
                        }
                    })
                } else {
                    errorP.innerHTML = '';
                    this.purchase.setChild(field.parentElement.parentElement.getAttribute("data-id"), {
                        [fieldName]: {
                            hasError: false,
                            value: input
                        }
                    })
                    console.log(this.purchase);

                }
            });
        });

        document.querySelector("input[type='date']").addEventListener('change', e => {
            this.purchase.date = e.target.value;
        });

    }




    renderFields() {

        const div = document.createElement('div');
        div.classList.add('fields-wrapper');
        div.setAttribute('data-id', this.id--);
        div.style.width = '100%';

        div.innerHTML = `
    <div class="dropdown-datalist">
        <div class="input-datalist">
            <input type="text" class="form-datalist" name="item"  />
            <input hidden type="text" name="itemid" id="idfield" endpoint="items" hasError="false" />
            <span class="floating-label-datalist">Item</span>
            <div id="spinner-datalist"></div>
            <p class="error-holder"></p>
            <div class="dropdown-datalist-content">
            </div>
        </div>
    </div>
    <div class="input-textfield">
        <input type="number" class="form-textfield" name="Purchase_price"   />
        <span class="floating-label">Purchase Price</span>
        <p id="purchase-price-error-div"></p>
    </div>
    <div class="input-textfield">
        <input type="number" class="form-textfield" name="quantity" />
        <span class="floating-label">Quantity</span>
        <p id="quantity-error-div"></p>
    </div>
    <div class="input-textfield">
        <img class="add-purchase-btn" state="add" src="/bookmart/public/images/add.svg" />
    </div>`;


        const formGroup = document.querySelector('.form-group')
        formGroup.appendChild(div);

        this.purchase.setChild(div.dataset.id, {
            newlyAdded: true,
            itemId: {
                hasError: false,
                value: ''
            },
            Purchase_price: {
                hasError: false,
                value: ''
            },
            quantity: {
                hasError: false,
                value: ''
            },

        });

        autoComplete(div.querySelector('.dropdown-datalist'));

        const itemIdField = div.querySelector("input[name='itemid']");

        const descriptor = Object.getOwnPropertyDescriptor(Object.getPrototypeOf(itemIdField), 'value');

        const self = this;

        Object.defineProperty(itemIdField, 'value', {
            set: function(value) {
                self.purchase.setChild(div.dataset.id, {
                    itemId: {
                        value,
                        hasError: false,
                    },
                })
                return descriptor.set.apply(this, arguments);
            },
            get: function() {
                return descriptor.get.apply(this);
            }
        });




        div.querySelectorAll('.form-textfield').forEach(field => {
            field.addEventListener('input', e => {
                const input = e.target.value;
                if (input) {
                    const fieldName = e.target.name;
                    const errorP = fieldName === 'Purchase_price' ? div.querySelector('#purchase-price-error-div') : div.querySelector('#quantity-error-div');
                    const regex = fieldName === 'Purchase_price' ? /^[0-9.]{1,11}$/ : /^[0-9]{1,5}$/;
                    const errorMessage = fieldName === 'Purchase_price' ? 'Invalid purchase price' : 'Invalid quantity';
                    if (!regex.test(input)) {
                        errorP.innerHTML = errorMessage;
                        this.purchase.setChild(div.dataset.id, {
                            [fieldName]: {
                                hasError: true,
                                value: input
                            }
                        })
                    } else {
                        errorP.innerHTML = '';
                        this.purchase.setChild(div.dataset.id, {
                            [fieldName]: {
                                hasError: false,
                                value: input
                            }
                        })
                        console.log(this.purchase);

                    }
                }
            });
        });


        const toggleBtn = div.querySelector('.add-purchase-btn');

        toggleBtn.addEventListener('click', () => {
            if (toggleBtn.getAttribute('state') == 'add') {
                toggleBtn.setAttribute('state', 'remove');
                toggleBtn.src = '/bookmart/public/images/remove.svg';
                this.renderFields();

            } else {
                div.remove();
                if (this.purchase.items[div.getAttribute('data-id')].newlyAdded) {
                    delete this.purchase.items[div.getAttribute('data-id')];
                } else {
                    this.purchase.items[div.getAttribute('data-id')].deleted = true;
                }
            }
        });
    }



    validateAndSubmit(e) {
        e.preventDefault();
        const hasErrors = Object.values(this.purchase.items).some(child => {
            return Object.values(child).some(field => {
                return field.hasError;
            })
        })


        // onSubmit is a function in autoComplete.js that checks if any of the id fields have any errors
        if (hasErrors || !onSubmit()) {
            return;
        }

        fetch('/bookmart/purchases/edit_purchase.php?id=<?=$purchaseMasterDetails['Purchase_master_id']?>', {
                method: 'POST',
                credentials: 'include',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(this.purchase)
            })
            .then(res => res.json())
            .then(res => {
                if (res.success) {
                    const div = document.createElement('div');
                    div.classList.add('toast-success');
                    div.innerHTML = '🚀 Purchase Updated successfully';
                    document.querySelector('.add-purchase-form').appendChild(div);
                }
            })



    }

}

const purchases = new PurchaseTable();
purchases.renderFields();

function removeItem(id) {
    if (confirm('Are you sure you want to delete this purchase? This action cannot be undone after submiting !')) {
        document.querySelector(`[data-id='${id}']`).remove();
        purchases.purchase.items[id].removed = true;
    }
}

document.querySelector('.add-purchase-form').addEventListener('submit', (e) => purchases.validateAndSubmit(e));
</script>