<?php
	include "../middlewares/isAuthenticated.php";
	include "../middlewares/isAdminOrStaff.php";
	include "../classes/Purchase.php";

	$purchaseMaster = json_decode(file_get_contents("php://input"));
	if ($purchaseMaster) {
		$purchase = new Purchase($purchaseMaster->purchaseChild, $purchaseMaster->vendorid, $purchaseMaster->date, );
		$purchase->add();
		die(json_encode($data));
	}
?>

<?php include "../layouts/admin_staff/header.php";?>
<div class="form-main">
    <?php if (isset($success)): ?>
    <div class="toast-success">
        🚀 Purchase added successfully
    </div>
    <?php endif?>
    <form class="form add-purchase-form" action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <h1>Add Purchase</h1>
        <div class="fields-wrapper" style="width:500px">
            <div class="dropdown-datalist">
                <div class="input-datalist">
                    <input type="text" class="form-datalist" name="vendor" required />
                    <input hidden type="text" name="vendorid" id="idfield" endpoint="vendors" hasError="false" />
                    <span class="floating-label-datalist">Vendor
                    </span>
                    <div id="spinner-datalist"></div>
                    <p class="error-holder"></p>
                    <div class="dropdown-datalist-content">
                    </div>
                </div>
            </div>
            <div class="input-textfield">
                <input type="date" class="form-textfield" name="Purchase_date" required />
                <span class="floating-label">Purchase Date</span>
                <p></p>
            </div>
        </div>
        <div class="form-group" style="width: 100%;">

        </div>

        <button type="submit" name="submit">ADD</button>
    </form>
</div>

<script src="/public/js/autoComplete.js"></script>


<script>
class PurchaseTable {

    constructor() {
        this.id = 0;
        this.purchaseMaster = {
            purchaseChild: {},
            setChild: function(id, props) {
                this.purchaseChild[id] = {
                    ...this.purchaseChild[id],
                    ...props
                };
            }

        }

        const vendorIdField = document.querySelector("input[name='vendorid'");

        const descriptor = Object.getOwnPropertyDescriptor(Object.getPrototypeOf(vendorIdField), 'value');

        const self = this;

        Object.defineProperty(vendorIdField, 'value', {
            set: function(value) {
                self.purchaseMaster.vendorid = value;
                return descriptor.set.apply(this, arguments);
            },
            get: function() {
                return descriptor.get.apply(this);
            }
        });

    }



    renderFields() {

        const div = document.createElement('div');
        div.classList.add('fields-wrapper');
        div.setAttribute('data-id', this.id++);
        div.style.width = '100%';

        div.innerHTML = `
    <div class="dropdown-datalist">
        <div class="input-datalist">
            <input type="text" class="form-datalist" name="item" required />
            <input hidden type="text" name="itemid" id="idfield" endpoint="items" hasError="false" />
            <span class="floating-label-datalist">Item</span>
            <div id="spinner-datalist"></div>
            <p class="error-holder"></p>
            <div class="dropdown-datalist-content">
            </div>
        </div>
    </div>
    <div class="input-textfield">
        <input type="number" class="form-textfield" name="Purchase_price" required  />
        <span class="floating-label">Purchase Price</span>
        <p id="purchase-price-error-div"></p>
    </div>
    <div class="input-textfield">
        <input type="number" class="form-textfield" name="quantity" required />
        <span class="floating-label">Quantity</span>
        <p id="quantity-error-div"></p>
    </div>
    <div class="input-textfield">
        <img class="add-purchase-btn" state="add" src="/public/images/add.svg" />
    </div>`;


        const formGroup = document.querySelector('.form-group')
        formGroup.appendChild(div);


        autoComplete(div.querySelector('.dropdown-datalist'));


        document.querySelector("input[name='Purchase_date']").addEventListener('input', (e) => {
            this.purchaseMaster.date = e.target.value;
        })


        const itemIdField = div.querySelector("input[name='itemid'");

        const descriptor = Object.getOwnPropertyDescriptor(Object.getPrototypeOf(itemIdField), 'value');

        const self = this;

        Object.defineProperty(itemIdField, 'value', {
            set: function(value) {
                self.purchaseMaster.setChild(div.dataset.id, {
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
                const fieldName = e.target.name;
                const errorP = fieldName === 'Purchase_price' ? div.querySelector('#purchase-price-error-div') : div.querySelector('#quantity-error-div');
                const regex = fieldName === 'Purchase_price' ? /^[0-9.]{1,11}$/ : /^[1-9]{1,5}$/;
                const errorMessage = fieldName === 'Purchase_price' ? 'Invalid purchase price' : 'Invalid quantity';
                if (!regex.test(input)) {
                    errorP.innerHTML = errorMessage;
                    this.purchaseMaster.setChild(div.dataset.id, {
                        [fieldName]: {
                            hasError: true,
                            value: input
                        }
                    })
                } else {
                    errorP.innerHTML = '';
                    this.purchaseMaster.setChild(div.dataset.id, {
                        [fieldName]: {
                            hasError: false,
                            value: input
                        }
                    })

                }
            });
        });


        const toggleBtn = div.querySelector('.add-purchase-btn');

        toggleBtn.addEventListener('click', () => {
            if (toggleBtn.getAttribute('state') == 'add') {
                toggleBtn.setAttribute('state', 'remove');
                toggleBtn.src = '/public/images/remove.svg';
                this.renderFields();

            } else {
                div.remove();
                delete this.purchaseMaster.purchaseChild[div.getAttribute('data-id')];
            }
        });
    }



    validateAndSubmit(e) {
        e.preventDefault();
        const hasErrors = Object.values(this.purchaseMaster.purchaseChild).some(child => {
            return Object.values(child).some(field => {
                return field.hasError;
            })
        })

        // onSubmit is a function in autoComplete.js that checks if any of the id fields have any errors
        if (hasErrors || !onSubmit()) {
            return;
        }

        fetch('/purchases/add_purchase.php', {
                method: 'POST',
                credentials: 'include',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(this.purchaseMaster)
            })
            .then(res => res.json())
            .then(res => console.log(res))



    }

}

const purchases = new PurchaseTable();
purchases.renderFields();

document.querySelector('.add-purchase-form').addEventListener('submit', (e) => purchases.validateAndSubmit(e));
</script>