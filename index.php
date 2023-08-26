<?php
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";

$server = $_SERVER['SERVER_NAME'];

$port = $_SERVER['SERVER_PORT'];
$port = ($port == '80') ? '' : (':' . $port);

$base_url = $protocol . '://' . $server . $port;
$base_url = $base_url . "/invoice";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

</head>
<body>
    <header>
        <nav></nav>
    </header>
    <main class="container">
    <form action="<?= $base_url . '/generate-pdf.php'; ?>" method="post">
        <div class="row">
            <h3>Order information</h3>
            <div class="col-md-6">
                <label for="firmsSelectInput" class="form-label">Select a firm</label>
                <select name="firm" class="form-select" aria-label="Default select example" id="firmsSelectInput">
                    
                </select>
            </div>
            <div class="col-md-6">
                <label for="vendorsSelectInput" class="form-label">Select a vendor</label>
                <select name="vendor" class="form-select" aria-label="Default select example" id="vendorsSelectInput">
                    
                </select>
            </div>
        </div>
        <div class="row">
            <h3>Invoice</h3>
            <div class="col-md-12">
                <table class="table table-bordered" id="invoiceTable">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Unit price</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr data-role="invoice-item-row" id="invoiceInputsRow">
                            <td>
                                <!-- <input type="text" name="name" class="form-control" placeholder="e.g. Cement, Sand" data-role="item-name-input"> -->
                                <select name="invoice_name[]" class="form-select" aria-label="Default select example" data-role="item-name-input">
                                </select>
                            </td>
                            <td>
                                <input type="number" name="invoice_quantity[]" class="form-control" placeholder="Quantity" data-role="item-quantity-input">
                            </td>
                            <td>
                                <input type="number" name="invoice_price[]" class="form-control" placeholder="e.g. 100.00" data-role="item-price-input">
                            </td>
                            <td>
                                <input type="number" name="invoice_total[]" class="form-control" placeholder="" readonly data-role="item-total-input">
                            </td>
                            <td data-role="invoice-action-buttons-container">
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>
                                <button type="button" class="btn btn-primary" data-button-action="add-item-row" id="addInvoiceDataInputsButton">Add a row</button>
                            </td>
                            <td></td>
                            <td></td>
                            <td>
                                <input type="number" name="invoice_subtotal" class="form-control" placeholder="" readonly data-role="item-subtotal-input">
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="row">
            <h3>Vendor details</h3>
            <div class="col-md-6">
                <label for="" class="form-label">Vendor name</label>
                <input type="text" name="vendor_name" class="form-control" placeholder="" data-role="item-quantity-input" id="vendorNameInput">
            </div>
            <div class="col-md-6">
                <label for="" class="form-label">Vendor mobile number</label>
                <input type="text" name="vendor_mobile_number" class="form-control" placeholder="" data-role="item-quantity-input" id="vendorMobileNumberInput">
            </div>
            <div class="col-md-12">
                <label for="" class="form-label">Vendor address</label>
                <textarea name="vendor_address" class="form-control" id="vendorAddressInput"></textarea>
            </div>
        </div>

        <div class="row mb-3">
            <h3>Bank details</h3>
            <div class="col-md-6">
                <label for="" class="form-label">Bank name</label>
                <input type="text" name="bank_name" class="form-control" placeholder="" data-role="item-quantity-input" id="vendorNameInput">
            </div>
            <div class="col-md-6">
                <label for="" class="form-label">Bank branch name</label>
                <input type="text" name="bank_branch_name" class="form-control" placeholder="" data-role="item-quantity-input" id="vendorNameInput">
            </div>
            <div class="col-md-6">
                <label for="" class="form-label">Back IFSC number</label>
                <input type="text" name="bank_ifsc_number" class="form-control" placeholder="" data-role="item-quantity-input" id="vendorMobileNumberInput">
            </div>
            
            <div class="col-md-6">
                <label for="" class="form-label">Back account number</label>
                <input type="text" name="bank_account_number" class="form-control" placeholder="" data-role="item-quantity-input" id="vendorMobileNumberInput">
            </div>
            <div class="col-md-12">
                <label for="" class="form-label">Extra note</label>
                <textarea name="extra_note" class="form-control" id="vendorAddressInput"></textarea>
            </div>
        </div>
        <div class="row">
            <input type="submit" value="Generate pdf" class="btn btn-primary">
        </div>
    </form>
    </main>
    <footer></footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const invoiceTable = document.querySelector('#invoiceTable');
            const invoiceInputsRow = invoiceTable.querySelector('#invoiceInputsRow');
            const addIvoiceDataInputsButton = invoiceTable.querySelector('#addInvoiceDataInputsButton');

            function calculateSubTotal() {
                const totalDataInputs = document.querySelectorAll('table input[data-role="item-total-input"]');
                let subTotal = 0;

                totalDataInputs.forEach(input => {
                    subTotal = subTotal + (+input.value);
                });
                document.querySelector('input[data-role="item-subtotal-input"]').value = subTotal;
            }
            
            function calculateTotal(parentElement) {
                let priceInput = parentElement.querySelector('input[data-role="item-price-input"]');
                let quantityInput = parentElement.querySelector('input[data-role="item-quantity-input"]');
                let totalInput = parentElement.querySelector('input[data-role="item-total-input"]');
                [priceInput,quantityInput].forEach(dataInput => {
                    dataInput.addEventListener('input', event => {
                        totalInput.value = priceInput.value * quantityInput.value;
                        calculateSubTotal();
                    });
                });
                
            }   
            
            calculateTotal(invoiceTable);
                
            addIvoiceDataInputsButton.addEventListener('click', event => {
                let clonedInoviceInputsRow = invoiceInputsRow.cloneNode(true);
                let invoiceTableItemContainer = invoiceTable.querySelector('tbody');
                let removeRowButtonContianer = clonedInoviceInputsRow.querySelector('td[data-role="invoice-action-buttons-container"]');

                let removeRowButton = document.createElement('button');
                removeRowButton.classList.add('btn', 'btn-danger');
                removeRowButton.textContent = "Remove row";
                removeRowButton.setAttribute('type', "button");

                clonedInoviceInputsRow.querySelectorAll('input[data-role]').forEach(dataInput => {
                    dataInput.value = null;
                });
                
                let dropdownElement = clonedInoviceInputsRow.querySelector('select[data-role="item-name-input"]');
                $(dropdownElement).select2({
                    placeholder: "Select a product",
                    ajax: {
                        url: `${baseURL}get-dropdown-data.php?list_of=products`,
                        dataType: 'json',
                        data: function (params) {
                            return {
                                q: params.term, 
                                page: params.page
                            };
                        },
                        processResults: function (data) {
                            return {
                                results: data
                            };
                        },
                        cache: true
                    }
                });

                removeRowButtonContianer.appendChild(removeRowButton);
                
                invoiceTableItemContainer.appendChild(clonedInoviceInputsRow);

                removeRowButton.addEventListener('click', event => {
                    invoiceTableItemContainer.removeChild(clonedInoviceInputsRow);
                });

                calculateTotal(clonedInoviceInputsRow);
                
            });
        });

        const baseURL = window.location.href;
        $('#firmsSelectInput').select2({
            placeholder: "Select a firm",
            ajax: {
                url: `${baseURL}get-dropdown-data.php?list_of=firms`,
                dataType: 'json',
                data: function (params) {
                    return {
                        q: params.term, 
                        page: params.page
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });

        $('#vendorsSelectInput').select2({
            placeholder: "Select a vendor",
            ajax: {
                url: `${baseURL}get-dropdown-data.php?list_of=vendors`,
                dataType: 'json',
                data: function (params) {
                    return {
                        q: params.term, 
                        page: params.page
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });

        $('#vendorsSelectInput').on("select2:select", function (event) {
            let selectedVendorId = $(this).val();
            $.ajax({
                url: `${baseURL}get-vendor.php?vendor=${selectedVendorId}`,
                contentType: 'application/json; charset=utf-8',
                dataType: "json",
                success: function (result) {
                    let vendorNameInput = $('#vendorNameInput')[0];
                    let vendorMobileNumberInput = $('#vendorMobileNumberInput')[0];
                    let vendorAddressInput = $('#vendorAddressInput')[0];

                    vendorNameInput.value =result[0].name;
                    vendorMobileNumberInput.value =result[0].mobile_no;
                    vendorAddressInput.innerText =result[0].address;
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            });
        });
        
    </script>
</body>
</html>